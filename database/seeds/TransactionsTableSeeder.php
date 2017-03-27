<?php

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Transaction::class)->create([
            'transaction_id' => '1-1444392550-1',
            'reference_id' => '1-1568845-56',
            'merchant_id' => 1,
            'acquirer_id' => 1,
            'client_id' => 1,
        	'number' => '401288XXXXXX1881',
            'status' => 'WAITING',
            'operation' => 'DIRECT',
            'payment_method' => 'PAYTOCARD',
            'amount' => '100',
            'currency' => 'EUR',
            'created_at' => '2017-03-05 03:14:16',
            'updated_at' => '2017-03-05 03:14:16'
        ]);

        factory(App\Transaction::class)->create([
            'transaction_id' => '529-1438673740-2',
            'reference_id' => '1-9463125-36',
            'merchant_id' => 3,
            'acquirer_id' => 4,
            'client_id' => 2,
            'number' => '492057XXXXXX6005',
            'status' => 'APPROVED',
            'operation' => '3D',
            'payment_method' => 'CREDITCARD',
            'amount' => '75',
            'currency' => 'EUR',
            'created_at' => '2017-03-07 12:00:11',
            'updated_at' => '2017-03-07 12:00:11'
        ]);

        factory(App\Transaction::class)->create([
            'transaction_id' => '24-1438675360-9',
            'reference_id' => '12-9463125-6',
            'merchant_id' => 4,
            'acquirer_id' => 2,
            'client_id' => 3,
            'number' => '400012XXXXXX9010',
            'status' => 'DECLINED',
            'operation' => 'DIRECT',
            'payment_method' => 'GIROPAY',
            'amount' => '599',
            'currency' => 'USD',
            'created_at' => '2017-03-10 18:25:10',
            'updated_at' => '2017-03-10 18:25:10'
        ]);

        factory(App\Transaction::class)->create([
            'transaction_id' => '50-1438675360-1',
            'reference_id' => '12-109463125-6',
            'merchant_id' => 1,
            'acquirer_id' => 1,
            'client_id' => 3,
            'number' => '400012XXXXXX9010',
            'status' => 'APPROVED',
            'operation' => '3D',
            'payment_method' => 'CREDITCARD',
            'amount' => '90',
            'currency' => 'USD',
            'created_at' => '2017-03-11 10:02:41',
            'updated_at' => '2017-03-11 10:02:41'
        ]);

        factory(App\Transaction::class)->create([
            'transaction_id' => '68-867536034-9',
            'reference_id' => '1-0009463125-7',
            'merchant_id' => 2,
            'acquirer_id' => 2,
            'client_id' => 2,
            'number' => '401288XXXXXX1881',
            'status' => 'WAITING',
            'operation' => 'REFUND',
            'payment_method' => 'CREDITCARD',
            'amount' => '45',
            'currency' => 'USD',
            'created_at' => '2017-03-26 21:00:33',
            'updated_at' => '2017-03-26 21:00:33'
        ]);

    }
}
