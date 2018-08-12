<?php

namespace Tests\Unit;

use App\Dealer;
use Tests\TestCase;
use App\UserCommission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserCommissionTest extends TestCase
{
    /** @test */
    function test_for_get_user_commission_sums()
    {
        $userCommission = UserCommission::get()
            ->groupBy('dealer_id')
            ->map(function ($value) {
                return $value->sum('user_commission');
            });

        $this->assertEquals($userCommission->toArray(), [
            '1' =>  26.00, // dealer_id = 1, richo1263
            '5' =>  25.80, // dealer_id = 5, hendry1264
            '6' =>  28.80, // dealer_id = 6, andry1267
        ]);
    }

    /** @test */
    function test_for_hierarchy_commission_table()
    {
        $dealer = Dealer::leftJoin('user_commissions', 'dealer.id', '=', 'user_commissions.dealer_id')
        ->select(
            'dealer.id',
            'dealer.username',
            'dealer.upline',
            DB::raw('SUM(user_commissions.user_commission) as user_commission')
        )
        ->groupBy('user_commissions.dealer_id')
        ->orderBy('upline', 'DESC')
        ->get();

        $buildUp = collect([]);
        $counter = $dealer->first()->upline;
        $dealer = collect($dealer)->each(function ($group) use (&$counter, &$buildUp){
            $checker = $counter;
            $counter = $group->upline;

            if ($buildUp->isEmpty()) {
                $buildUp = $buildUp->push($group->toArray());
                return;
            }

            if ($group->id == $checker) {
                $buildUp = collect($group->toArray())->merge([
                    'downline' => $buildUp
                ]);
                return;
            }

            if ($group->id > $checker && $group->upline == $checker) {
                $buildUp = $buildUp->push($group->toArray());
            }
        });

        $this->assertEquals([
        "id" => 1,
        "username" => "richo1263",
        "upline" => "0",
        "user_commission" => "26.0",
        "downline" => [
            "id" => 5,
            "username" => "hendry1264",
            "upline" => "1",
            "user_commission" => "25.8",
                "downline" => [
                    "0" => [
                        "id" => 6,
                        "username" => "andry1267",
                        "upline" => "5",
                        "user_commission" => "28.8",
                    ]
                  ],
            ]
        ],
        $buildUp->toArray());

        dd($buildUp->toArray());
    }

    // /** @test */
    // function test_results()
    // {
    //     $test = [
    //         'dealer_id'       => 1, 
    //         'user_commission' => 26.00, 
    //         'downline'        => [
    //             'id'              =>5,
    //             'user_commission' =>25.8, 
    //             'downline'        => [
    //                 'id'=>6,
    //                 'user_commission'=>28.80
    //             ]
    //         ]
    //     ];
    //     dd($test);
    // }
}