<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->char('number', 16);
            $table->date('expiration_date');
            $table->date('starting_date')->nullable();
            $table->char('issue_number', 16)->nullable();
            $table->string('email')->unique();
            $table->date('birthday');
            $table->enum('gender', ['male', 'female'])->nullable();

            $table->string('billing_title', 10)->nullable();
            $table->string('billing_firstname', 25);
            $table->string('billing_lastname', 25);
            $table->string('billing_company', 100)->nullable();
            $table->string('billing_address1', 100);
            $table->string('billing_address2', 100)->nullable();
            $table->string('billing_city', 25);
            $table->string('billing_postcode', 5)->nullable();
            $table->string('billing_state', 10)->nullable();
            $table->string('billing_country', 20);
            $table->string('billing_phone', 13)->nullable();
            $table->string('billing_fax', 13)->nullable();
            
            $table->string('shipping_title', 10)->nullable();
            $table->string('shipping_firstname', 25);
            $table->string('shipping_lastname', 25);
            $table->string('shipping_company', 100)->nullable();
            $table->string('shipping_address1', 100);
            $table->string('shipping_address2', 100)->nullable();
            $table->string('shipping_city', 25);
            $table->string('shipping_postcode', 5)->nullable();
            $table->string('shipping_state', 10)->nullable();
            $table->string('shipping_country', 20);
            $table->string('shipping_phone', 13)->nullable();
            $table->string('shipping_fax', 13)->nullable();

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('clients');
    }
}
