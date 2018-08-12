<?php

use App\Dealer;
use Illuminate\Database\Seeder;

class DealerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dealer::create([
            'id'        =>  1,
            'username'  =>  'richo1263',
            'upline'    =>  '0',
        ]);
        Dealer::create([
            'id'        =>  5,
            'username'  =>  'hendry1264',
            'upline'    =>  '1',
        ]);
        Dealer::create([
            'id'        =>  6,
            'username'  =>  'andry1267',
            'upline'    =>  '5',
        ]);
    }
}
