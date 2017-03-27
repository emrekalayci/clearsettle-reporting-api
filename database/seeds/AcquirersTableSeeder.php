<?php

use Illuminate\Database\Seeder;

class AcquirersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Acquirer::class)->create([
        	'name' => 'NX Pay'
        ]);

        factory(App\Acquirer::class)->create([
            'name' => 'Elavon'
        ]);

        factory(App\Acquirer::class)->create([
            'name' => 'HSBC'
        ]);

        factory(App\Acquirer::class)->create([
            'name' => 'WorldPay'
        ]);

    }
}
