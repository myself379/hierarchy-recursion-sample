<?php

use App\UserCommission;
use Illuminate\Database\Seeder;

class UserCommissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCommission::create([
            'dealer_id'         => 1,
            'user_commission'   => 12.50,
        ]);
        UserCommission::create([
            'dealer_id'         => 1,
            'user_commission'   => 13.50,
        ]);
        UserCommission::create([
            'dealer_id'         => 5,
            'user_commission'   => 15.50,
        ]);
        UserCommission::create([
            'dealer_id'         => 6,
            'user_commission'   => 17.50,
        ]);
        UserCommission::create([
            'dealer_id'         => 5,
            'user_commission'   => 10.30,
        ]);
        UserCommission::create([
            'dealer_id'         => 6,
            'user_commission'   => 11.30,
        ]);
    }
}
