<?php

namespace FacturationRegie\Tests;

use FacturationRegie\Pointage;
use FacturationRegie\Tests\Stubs\Models\Task;
use FacturationRegie\Tests\Stubs\Models\User;
use FacturationRegie\Tests\Stubs\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use FacturationRegie\Exceptions\PointableWithoutResponsableException;

//use FacturationRegie\Tests\TestCase;

//use PHPUnit\Framework\TestCase;

class VerifyPointageTest extends TestCase
{
    use RefreshDatabase;
    


    /** @test */
    public function it_says_true_if_it_s_not_equal_to_the_daily_min()
    {
        $u = factory(User::class)->create();
        $date = now();

        $pointageIntrus = factory(Pointage::class)->create();

        $pointage = factory(Pointage::class)->create([
            'user_id'=> $u->id,
            'units'=> 8,
            'unit_type'=> 'ut',
            'date'=>$date
        ]);
        $pointage = factory(Pointage::class)->create([
            'user_id'=> $u->id,
            'units'=> 8,
            'unit_type'=> 'ut',
            'date'=>$date
        ]);
        $pointage = factory(Pointage::class)->create([
            'user_id'=> $u->id,
            'units'=> 8,
            'unit_type'=> 'ut',
            'date'=>$date
        ]);
        $pointage = factory(Pointage::class)->create([
            'user_id'=> $u->id,
            'units'=> 8,
            'unit_type'=> 'ut',
            'date'=>$date
        ]);

        $is_valid = Pointage::verifyUserDay($u, $date);
        
        $this->assertTrue($is_valid);
    }



    /** @test */
    public function it_says_false_if_it_s_not_equal_to_the_daily_min()
    {
        $u = factory(User::class)->create();
        $date = now();

        $pointageIntrus = factory(Pointage::class)->create();

        $pointage = factory(Pointage::class)->create([
            'user_id'=> $u->id,
            'units'=> 12,
            'unit_type'=> 'ut',
            'date'=>$date
        ]);
        $pointage = factory(Pointage::class)->create([
            'user_id'=> $u->id,
            'units'=> 1,
            'unit_type'=> 'ut',
            'date'=>$date
        ]);

        $is_valid = Pointage::verifyUserDay($u, $date);
        
        $this->assertFalse($is_valid);
    }
}
