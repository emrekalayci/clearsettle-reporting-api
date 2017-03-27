<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acquirer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'acquirers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}