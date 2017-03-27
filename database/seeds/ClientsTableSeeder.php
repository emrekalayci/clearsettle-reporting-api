<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        factory(App\Client::class)->create([
        	'number' => '401288XXXXXX1881',
            'expiration_date' => '2017-06-00',
            'email' => 'michael@gmail.com',
            'birthday' => '1986-03-20 12:09:10',
            'billing_firstname' => 'Michael',
            'billing_lastname' => 'Kara',
            'billing_address1' => 'Varlik Mah. 181 Sk. Muratpasa',
            'billing_city' => 'Antalya',
            'billing_postcode' => '07050',
            'billing_country' => 'TR',
            'shipping_firstname' => 'Michael',
            'shipping_lastname' => 'Kara',
            'shipping_address1' => 'Varlik Mah. 181 Sk. Muratpasa',
            'shipping_city' => 'Antalya',
            'shipping_postcode' => '07050',
            'shipping_country' => 'TR',
            'created_at' => '2017-03-01 10:02:41',
            'updated_at' => '2017-03-01 10:02:41'
        ]);

        factory(App\Client::class)->create([
            'number' => '492057XXXXXX6005',
            'expiration_date' => '2019-03-00',
            'email' => 'emre@emrekalayci.com',
            'gender' => 'male',
            'birthday' => '1990-01-01 00:00:00',
            'billing_firstname' => 'Emre',
            'billing_lastname' => 'Kalayci',
            'billing_address1' => 'Uncali Mah. 32. Cd. Konyaalti',
            'billing_city' => 'Antalya',
            'billing_postcode' => '07070',
            'billing_country' => 'TR',
            'shipping_firstname' => 'Emre',
            'shipping_lastname' => 'Kalayci',
            'shipping_address1' => 'Uncali Mah. 32. Cd. Konyaalti',
            'shipping_city' => 'Antalya',
            'shipping_postcode' => '07070',
            'shipping_country' => 'TR',
            'created_at' => '2017-03-15 11:22:05',
            'updated_at' => '2017-03-15 11:22:05'
        ]);

        factory(App\Client::class)->create([
            'number' => '400012XXXXXX9010',
            'expiration_date' => '2021-01-00',
            'email' => 'leylaozer@hotmail.com',
            'gender' => 'female',
            'birthday' => '1988-07-21 00:00:00',
            'billing_firstname' => 'Leyla',
            'billing_lastname' => 'Özer',
            'billing_address1' => 'Gunestepe Mah. Senler Sk. Güngören',
            'billing_city' => 'İstanbul',
            'billing_postcode' => '34164',
            'billing_country' => 'TR',
            'shipping_firstname' => 'Leyla',
            'shipping_lastname' => 'Özer',
            'shipping_address1' => 'Gunestepe Mah. Senler Sk. Güngören',
            'shipping_city' => 'İstanbul',
            'shipping_postcode' => '34164',
            'shipping_country' => 'TR',
            'created_at' => '2017-03-11 06:02:41',
            'updated_at' => '2017-03-11 06:02:41'
        ]);

    }
}
