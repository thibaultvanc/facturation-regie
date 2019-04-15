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
    public function happy_path()
    {
        $this->post(route('facturation-regie.pointage.verify_daily'), $a = [
          'date'=> now()->format('d-m-Y'), // 05-04-2019
          'user_id'=> 1,
      ])
      ->assertOk();
    }

    /** @test */
    public function must_specify_a_user()
    {
        $this->post(route('facturation-regie.pointage.verify_daily'), $a = [
            'date'=> now()->format('d-m-Y'), // 05-04-2019
            //'user_id'=> $user->id,
        ])
        ->assertStatus(302)
        ->assertSessionHasErrors('user_id');
    }


    /** @test */
    public function must_specify_a_valid_date()
    {
        $this->post(route('facturation-regie.pointage.verify_daily'), $a = [
            'date'=> '', // 05-04-2019
        ])
        ->assertStatus(302)
        ->assertSessionHasErrors('date');
    }
 
 
 
 
    /** @test */
    public function must_specify_a_day()
    {
        $user = factory(User::class)->create();

        $this->post(route('facturation-regie.pointage.verify_daily'), $a = [
            'date'=> '1212122',
        ])
        ->assertSessionHasErrors('date');
    }





    /** @test */
    public function given_a_date_it_verify_the_ut_against_the_miniumim_sprecified_in_config()
    {
        $user = factory(User::class)->create();

        $pointage1 = factory(Pointage::class)->create(['user_id'=>$user->id]);
        $pointage2 = factory(Pointage::class)->create(['user_id'=>$user->id]);
        $pointage3 = factory(Pointage::class)->create(['user_id'=>$user->id]);
        $pointage4 = factory(Pointage::class)->create(['user_id'=>$user->id]);


        $this->post(route('facturation-regie.pointage.verify_daily'), $a = [
            'date'=> now()->format('d-m-Y'), // 05-04-2019
            'user_id'=> $user->id,
        ])
        ->assertOk()
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
