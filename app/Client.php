<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'expiration_date', 'starting_date', 'issue_number', 'email', 'birthday', 'gender', 'billing_title', 'billing_firstname', 'billing_lastname', 'billing_company', 'billing_address1', 'billing_address2', 'billing_postcode', 'billing_state', 'billing_country', 'billing_phone', 'billing_fax', 'shipping_title', 'shipping_firstname', 'shipping_lastname', 'shipping_company', 'shipping_address1', 'shipping_address2', 'shipping_postcode', 'shipping_state', 'shipping_country', 'shipping_phone', 'shipping_fax',
    ];
}