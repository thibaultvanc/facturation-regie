<?php

namespace FacturationRegie\Tests;

use FacturationRegie\Pointage;
use FacturationRegie\Tests\Stubs\Models\Task;
use FacturationRegie\Tests\Stubs\Models\User;
use FacturationRegie\Tests\Stubs\Models\Meeting;
use FacturationRegie\Tests\Stubs\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use FacturationRegie\Exceptions\PointableWithoutResponsableException;

class CreateSimplePointageTest extends TestCase
{
    use RefreshDatabase;

    
    /** @test */
    public function it_creates_a_simple_pointage()
    {
        //$this->withExceptionHandling();
        $n='creation module';
        
        $this->assertDatabaseMissing('pointages', ['name'=>$n]);
        
        $meeting = factory(Meeting::class)->create();

        $response = $this->post(route('facturation-regie.pointage.store'), $a = [
            'date'=>now(),
            'name'=>$n,
            'description'=>'creation module de Facturation régie permettant de noter/consulter les pointages',
            'pointable_type'=>get_class($meeting),
            'pointable_id'=>$meeting->id,
            'user_id'=>factory(User::class)->create()->id,
            'is_facturable'=>true
        ])
        ->assertOk();
        
        $createdPointage = $response->decodeResponseJson()['data'];

        $this->assertEquals($n, $createdPointage['name']);

        $this->assertDatabaseHas('pointages', ['name'=>$n]);
        ;
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
    public function it_requires_a_user_id()
    {
        $r = factory(Pointage::class)->raw(['user_id'=>null]);
        $this->post(route('facturation-regie.pointage.store'), $r)
                    ->assertSessionHasErrors('user_id');
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
    public function it_requires_a_namem_min_10()
    {
        $r = factory(Pointage::class)->raw(['name'=>'short']);
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


    /** @test */
    public function it_requires_a_description_min()
    {
        $r = factory(Pointage::class)->raw(['description'=>'too_short']);
        $this->post(route('facturation-regie.pointage.store'), $r)
                    ->assertSessionHasErrors('description');
    }
  
    /** @test */
    public function it_requires_a_is_facturable_field()
    {
        $r = factory(Pointage::class)->raw(['is_facturable'=>null]);
        $this->post(route('facturation-regie.pointage.store'), $r)
                    ->assertSessionHasErrors('is_facturable');
    }
 
    /** @test */
    public function it_requires_a_is_facturable_field_2()
    {
        $r = factory(Pointage::class)->raw(['is_facturable'=>0]);
        $this->post(route('facturation-regie.pointage.store'), $r)
                    ->assertSessionHasNoErrors('is_facturable');
    }
}
