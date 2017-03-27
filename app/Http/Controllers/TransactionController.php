<?php

namespace App\Http\Controllers;

use App\User;
use App\Transaction;
use App\Client;
use App\Acquirer;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use Swap\Laravel\Facades\Swap;

class TransactionController extends Controller
{
    public function get(Request $request)
    {
        $transaction = Transaction::find($request->input('transactionId'));

        if($transaction)
        {
            return response()->json(['fx' => ['merchant' => ['original_amount' => $transaction->amount,
                                                             'original_currency' => $transaction->currency
                                                            ]
                                             ],
                                     'customer_info' => $transaction->client,
                                     'acquirer_transactions' => $transaction->acquirer,
                                     'merchant' => $transaction->merchant,
                                     'merchant_transactions' => ['reference_id' => $transaction->reference_id,
                                                                 'status' => $transaction->status,
                                                                 'operation' => $transaction->operation,
                                                                 'created_at' => $transaction->created_at->toDateTimeString(),
                                                                 'transaction_id' => $transaction->transaction_id
                                                                 ]
                                    ]);          
        }
        else
        {
            return response()->json(['status' => 'ERROR',
                                     'error_code' => 'Transaction ID does not exist'
                                    ]);  
        }
    }

    public function report(Request $request)
    {
        $this->validate($request, [
            'fromDate' => 'required|date_format:Y-m-d',
            'toDate' => 'required|date_format:Y-m-d',
            'merchant' => 'integer',
            'acquirer' => 'integer'
        ]);

        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $merchantId = $request->input('merchant');
        $acquirerId = $request->input('acquirer');

        $transactionQueryBuilder = DB::table('transactions')
                                        ->where('created_at', '>=', $fromDate . '00:00:00')
                                        ->where('created_at', '<=', $toDate   . '23:59:59')
                                        ->when($merchantId, function ($query) use ($merchantId) {
                                            return $query->where('merchant_id', $merchantId);
                                        })
                                        ->when($acquirerId, function ($query) use ($acquirerId) {
                                            return $query->where('acquirer_id', $acquirerId);
                                        });

        $transactions = $transactionQueryBuilder->get();

        if($transactions->isEmpty())
        {
            return response()->json(['status' => 'ERROR',
                                     'error_code' => 'Transactions with given parameters not found'
                                ]);
        }
        else
        {
            /* Each transaction might have a different currency.
             * So it is better to display the total amount of transactions in USD if there is more than one transaction.
             * To get live currency exchange rates, we have made use of Laravel-swap package.
             * More info can be found on https://github.com/florianv/laravel-swap
             */

            $count = $transactionQueryBuilder->count();

            if($count > 1)
            {
                $currency = 'USD';
                $totalAmount = 0; // total amount of transactions in USD

                foreach ($transactions as $t)
                {
                    $rate = Swap::latest($t->currency . '/USD'); // Get live exchange rate.

                    $totalAmount += ($t->currency === 'USD') ? $t->amount : ($t->amount * $rate->getValue()); 
                }             
            }
            else
            {
                $transaction = $transactionQueryBuilder->first();
                $totalAmount = $transaction->amount;
                $currency = $transaction->currency;
            }

            return response()->json(['status' => 'APPROVED',
                                     'response' => ['count' => $count,
                                                    'total' => $totalAmount,
                                                    'currency' => $currency
                                                   ]
                                    ]);
        }
    }

    public function list(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $status = $request->input('status');
        $operation = $request->input('operation');
        $merchantId = $request->input('merchantId');
        $acquirerId = $request->input('acquirerId');
        $paymentMethod = $request->input('paymentMethod');
        $errorCode = $request->input('errorCode');
        $filterField = $request->input('filterField');
        $filterValue = $request->input('filterValue');

        if($filterField)
        {
            switch ($filterField)
            {
                case 'Transaction UUID':
                    $filterField = 'transaction_id';
                    break;
                case 'Customer Email':
                    $filterField = 'customer_email';
                    break;
                case 'Reference No':
                    $filterField = 'reference_id';
                    break;
                case 'Card PAN':
                    $filterField = 'number';
                    break;
            }

            /*
             * If customer email is given as filter field, we cannot directly include it in the query
             * since we only keep customer id on the transaction table.
             * So we first should get customer (client) id using that email address
             * and perform the query with that customer id.
             */

            if($filterField === 'customer_email')
            {
                $filterField = 'client_id';
                $filterValue = DB::table('clients')->where('email', $filterValue)->value('id');
            }
        }

        $transactions = DB::table('transactions')
                                ->join('users', 'users.id', '=', 'transactions.merchant_id')
                                ->join('acquirers', 'acquirers.id', '=', 'transactions.acquirer_id')
                                ->join('clients',   'clients.id',   '=', 'transactions.client_id')
                                ->select('transactions.transaction_id',
                                         'transactions.reference_id',
                                         'transactions.number as transaction_number',
                                         'transactions.status',
                                         'transactions.operation',
                                         'transactions.payment_method',
                                         'transactions.error_code',
                                         'transactions.amount',
                                         'transactions.currency',
                                         'transactions.created_at as transaction_created_at',
                                         'transactions.updated_at as transaction_updated_at',
                                         'users.id as merchant_id',
                                         'users.name as merchant_name',
                                         'users.email as merchant_email',
                                         'acquirers.id as acquirer_id',
                                         'acquirers.name as acquirer_name',
                                         'clients.*')
                                ->when($fromDate, function ($query) use ($fromDate) {
                                    return $query->where('transactions.created_at', '>=', $fromDate . '00:00:00');
                                })
                                ->when($toDate, function ($query) use ($toDate) {
                                    return $query->where('transactions.created_at', '<=', $toDate   . '23:59:59');
                                })
                                ->when($status, function ($query) use ($status) {
                                    return $query->where('transactions.status', $status);
                                })
                                ->when($operation, function ($query) use ($operation) {
                                    return $query->where('transactions.operation', $operation);
                                })
                                ->when($merchantId, function ($query) use ($merchantId) {
                                    return $query->where('transactions.merchant_id', $merchantId);
                                })
                                ->when($acquirerId, function ($query) use ($acquirerId) {
                                    return $query->where('transactions.acquirer_id', $acquirerId);
                                })
                                ->when($paymentMethod, function ($query) use ($paymentMethod) {
                                    return $query->where('transactions.payment_method', $paymentMethod);
                                })
                                ->when($errorCode, function ($query) use ($errorCode) {
                                    return $query->where('transactions.error_code', $errorCode);
                                })
                                ->when($filterField, function ($query) use ($filterField, $filterValue) {
                                    return $query->where($filterField, $filterValue);
                                })
                                ->simplePaginate(3); // Three transactions per page

        if($transactions->isEmpty())
        {
            return response()->json(['status' => 'ERROR',
                                     'error_code' => 'Transactions with given parameters not found'
                                ]);
        }
        else
        {    
            // Before returning transaction list, we need to reformat each transaction data as given on the document.
            $transactions->getCollection()->transform(function ($value) {
                return $this->formatTransactionData($value);
            });
          
            return response()->json($transactions);  
        }                                     
    }

    public function getClient(Request $request)
    {
        $transaction = Transaction::find($request->input('transactionId'));

        return response()->json($transaction ? $transaction->client : ['status' => 'ERROR', 'error_code' => 'Transaction ID does not exist']);
    }

    public function getMerchant(Request $request)
    {
        $transaction = Transaction::find($request->input('transactionId'));

        return response()->json($transaction ? $transaction->merchant : ['status' => 'ERROR', 'error_code' => 'Transaction ID does not exist']);        
    }

    private function formatTransactionData($data)
    {
        return ['fx' => ['merchant' => ['original_amount' => $data->amount,
                                        'original_currency' => $data->currency
                                       ]
                        ],
                'customer_info' => ['id' => $data->id,
                                    'number' => $data->number,
                                    'expiration_date' => $data->expiration_date,
                                    'starting_date' => $data->starting_date,
                                    'issue_number' => $data->issue_number,
                                    'email' => $data->email,
                                    'birthday' => $data->birthday,
                                    'gender' => $data->gender,
                                    'billing_title' => $data->billing_title,
                                    'billing_firstname' => $data->billing_firstname,
                                    'billing_lastname' => $data->billing_lastname,
                                    'billing_address1' => $data->billing_address1,
                                    'billing_address2' => $data->billing_address2,
                                    'billing_city' => $data->billing_city,
                                    'billing_postcode' => $data->billing_postcode,
                                    'billing_state' => $data->billing_state,
                                    'billing_state' => $data->billing_state,
                                    'billing_country' => $data->billing_country,
                                    'billing_phone' => $data->billing_phone,
                                    'billing_fax' => $data->billing_fax,
                                    'shipping_title' => $data->shipping_title,
                                    'shipping_firstname' => $data->shipping_firstname,
                                    'shipping_lastname' => $data->shipping_lastname,
                                    'shipping_address1' => $data->shipping_address1,
                                    'shipping_address2' => $data->shipping_address2,
                                    'shipping_city' => $data->shipping_city,
                                    'shipping_postcode' => $data->shipping_postcode,
                                    'shipping_state' => $data->shipping_state,
                                    'shipping_state' => $data->shipping_state,
                                    'shipping_country' => $data->shipping_country,
                                    'shipping_phone' => $data->shipping_phone,
                                    'shipping_fax' => $data->shipping_fax,
                                    'created_at' => $data->created_at,
                                    'updated_at' => $data->updated_at
                                   ],
                'acquirer_transactions' => ['id' => $data->acquirer_id,
                                            'name' => $data->acquirer_name
                                           ],
                'merchant' => ['id' => $data->merchant_id,
                               'name' => $data->merchant_name,
                               'email' => $data->merchant_email
                              ],
                'merchant_transactions' => ['reference_id' => $data->reference_id,
                                            'status' => $data->status,
                                            'operation' => $data->operation,
                                            'created_at' => $data->transaction_created_at,
                                            'transaction_id' => $data->transaction_id
                                           ]
                ];
    }
}