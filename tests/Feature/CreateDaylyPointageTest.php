<?php

namespace FacturationRegie\Tests;

use FacturationRegie\Pointage;
use FacturationRegie\Tests\Stubs\Models\Task;
use FacturationRegie\Tests\Stubs\Models\User;
use FacturationRegie\Tests\Stubs\Models\Meeting;
use FacturationRegie\Tests\Stubs\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use FacturationRegie\Exceptions\PointableWithoutResponsableException;

class VerifyDailyPointageTest extends TestCase
{
    use RefreshDatabase;

    
    /** @test */
    public function given_a_date_it_verify_the_ut_against_the_miniumim_sprecified_in_config()
    {
        $pointage = factory(Task::class)->create();

        $this->post(route('facturation-regie.pointage.verify_daily'), $a = [
            'date'=>now(),
            'pointages'=>[
            ]
        ])
        //->assertOk()
        ;
        
        // $this->assertDatabaseHas('pointages', ['name'=>$n]);
    }
    










    /** @test */
    public function it_requires_a_pointable_type_and_a_pointable_id()
    {
        $r = factory(Pointage::class)->raw(['pointable_type'=>null,'pointable_id'=>null]);
        $this->post(route('facturation-regie.pointage.store'), $r)
                    ->assertSessionHasErrors('pointable_type')
                    ->assertSessionHasErrors('pointable_id');
    }


    /** @test */
    public function it_requires_a_date()
    {
        $r = factory(Pointage::class)->raw(['date'=>null]);
        $this->post(route('facturation-regie.pointage.store'), $r)
                    ->assertSessionHasErrors('date');
    }
    
    /** @test */
    public function it_requires_a_name()
    {
        $r = factory(Pointage::class)->raw(['name'=>null]);
        $this->post(route('facturation-regie.pointage.store'), $r)
                    ->assertSessionHasErrors('name');
    }
   
    /** @test */
    public function it_requires_a_description()
    {
        $r = factory(Pointage::class)->raw(['description'=>null]);
        $this->post(route('facturation-regie.pointage.store'), $r)
                    ->assertSessionHasErrors('description');
    }
}
