<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    protected $primaryKey = 'transaction_id';

    protected $keyType = 'string';

    /**
     * Get the merchant that owns the transaction.
     */
    public function merchant()
    {
    	return $this->belongsTo('App\User', 'merchant_id');
    }

    /**
     * Get the client that owns the transaction.
     */
    public function client()
    {
    	return $this->belongsTo('App\Client');
    }

    /**
     * Get the acquirer that owns the transaction.
     */
    public function acquirer()
    {
    	return $this->belongsTo('App\Acquirer');
    }
}