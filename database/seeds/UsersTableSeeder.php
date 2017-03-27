<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'name' => 'Türk Hava Yolları',
            'email' => 'merchant@thy.com',
            'password' => app('hash')->make('cjaiU8CV'),
            'created_at' => '2017-01-02 23:12:00',
            'updated_at' => '2017-01-02 23:12:00'
        ]);

        factory(App\User::class)->create([
            'name' => 'Zara Türkiye',
            'email' => 'merchant@zara.com',
            'password' => app('hash')->make('cjaiU8CV'),
            'created_at' => '2017-02-02 16:12:00',
            'updated_at' => '2017-02-02 16:12:00'
        ]);

        factory(App\User::class)->create([
            'name' => 'Bellona',
            'email' => 'merchant@bellona.com',
            'password' => app('hash')->make('cjaiU8CV'),
            'created_at' => '2017-02-05 01:32:00',
            'updated_at' => '2017-02-05 01:32:00'
        ]);

        factory(App\User::class)->create([
            'name' => 'Bumin',
            'email' => 'demo@bumin.com.tr',
            'password' => app('hash')->make('cjaiU8CV'),
            'created_at' => '2017-02-10 10:02:41',
            'updated_at' => '2017-02-10 10:02:41'
        ]);
    }
}