<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->char('transaction_id', 32)->unique();
            $table->char('reference_id', 32);
            $table->integer('merchant_id')->unsigned();
            $table->integer('acquirer_id')->unsigned();
            $table->integer('client_id')->unsigned()->nullable();
            $table->char('number', 16);
            $table->enum('status', ['APPROVED', 'WAITING', 'DECLINED', 'ERROR']);
            $table->enum('operation', ['DIRECT', 'REFUND', '3D', '3DAUTH', 'STORED']);
            $table->enum('payment_method', ['CREDITCARD', 'CUP', 'IDEAL', 'GIROPAY', 'MISTERCASH', 'STORED', 'PAYTOCARD']);
            $table->char('error_code', 3)->nullable();
            $table->decimal('amount', 19, 4)->unsigned();
            $table->char('currency', 3);
            $table->timestamps();
            $table->foreign('merchant_id')->references('id')->on('users')->onDelete('no action')->onUpdate('cascade'); 
            $table->foreign('acquirer_id')->references('id')->on('acquirers')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('no action')->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactions');
    }
}
