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

class PointageScopeTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_get_all_the_pointages()
    {
        $pointage = factory(Pointage::class, 6)->create();
        $this->assertCount(6, Pointage::all());
    }
    
    
    /** @test */
    public function can_get_all_the_pointages_beetween_two_days()
    {
        $pointage = factory(Pointage::class, 2)->create(['date'=>now()]);
        $pointage = factory(Pointage::class, 3)->create(['date'=>now()->subDays(100)]);


        $this->assertCount(2, Pointage::between(now()->subDays(1), now()->addDays(1))->get());
    }
    

    /** @test */
    public function can_get_all_the_pointages_for_a_day()
    {
        $pointage = factory(Pointage::class, 1)->create(['date'=>now()->subMinutes(5)]);
        $pointage = factory(Pointage::class, 1)->create(['date'=>now()->subMinutes(25)]);
        $pointage = factory(Pointage::class, 1)->create(['date'=>now()->addMinutes(10)]);
        $pointage = factory(Pointage::class, 1)->create(['date'=>now()->addMinutes(20)]);
        
        $pointage = factory(Pointage::class, 3)->create(['date'=>now()->subDays(100)]);

        $this->assertCount(4, Pointage::forDay(now())->get());
    }


    /** @test */
    public function can_get_all_the_pointages_for_a_month()
    {
        $pointage = factory(Pointage::class, 4)->create(['date'=>now()->startOfMonth()->addHours(10)]);
        $pointage = factory(Pointage::class, 4)->create(['date'=>now()->startOfMonth()->addDays(10)]);
        $pointage = factory(Pointage::class, 4)->create(['date'=>now()->startOfMonth()->addDays(15)]);
        $pointage = factory(Pointage::class, 4)->create(['date'=>now()->startOfMonth()->addDays(20)]);
        
        $pointage = factory(Pointage::class, 5)->create(['date'=>now()->subDays(100)]);
        
        $this->assertCount(16, Pointage::forMonth(now())->get());
    }




    /** @test */
    public function can_get_all_the_pointages_for_a_year()
    {
        $pointage = factory(Pointage::class, 2)->create(['date'=>now()->startOfYear()->addHours(10)]);
        $pointage = factory(Pointage::class, 2)->create(['date'=>now()->startOfYear()->addDays(10)]);
        $pointage = factory(Pointage::class, 2)->create(['date'=>now()->startOfYear()->addMonth(10)]);
        $pointage = factory(Pointage::class, 2)->create(['date'=>now()->startOfYear()->addDays(20)]);
        
        $pointage = factory(Pointage::class, 5)->create(['date'=>now()->startOfYear()->subMinutes(2)]);

        $this->assertCount(8, Pointage::forYear(now())->get());
    }


    /** @test */
    public function can_get_all_the_pointages_for_a_user()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $pointage = factory(Pointage::class, 2)->create(['user_id'=>$user1]);
        $pointage = factory(Pointage::class, 6)->create(['user_id'=>$user2]);

        $this->assertCount(2, Pointage::forUser($user1)->get());
    }
 
 
 
    /** @test */
    public function can_get_all_the_pointages_facturable()
    {
        $pointage = factory(Pointage::class, 2)->create(['is_facturable'=>true]);
        $pointage = factory(Pointage::class, 6)->create(['is_facturable'=>false]);

        $this->assertCount(2, Pointage::facturable()->get());
    }

    /** @test */
    public function can_get_all_the_pointages_no_facturable()
    {
        $pointage = factory(Pointage::class, 2)->create(['is_facturable'=>true]);
        $pointage = factory(Pointage::class, 6)->create(['is_facturable'=>false]);
        
        $this->assertCount(6, Pointage::noFacturable()->get());
    }


    /**
     *
     * units and unit_types are not required
     * When transforming these fields are set to null
     *
     * @test */
    public function can_get_all_the_pointages_transformed_but_not_achieved()
    {
        $pointageachived = factory(Pointage::class, 3)->create();

        $pointageNONachived = factory(Task::class, 2)->create()->each->transformPointage();
        
        $this->assertCount(2, Pointage::nonAchieved()->get());
    }
    
    /**
     *
     * a task belongs to a project
     *
     * @test */
    public function can_get_all_the_pointages_for_a_Project()
    {
        $project = factory(Project::class)->create();
        
        $taskProject = $project->tasks()->create(['name'=>'task-1']);
        
        $pointage = factory(Pointage::class, 5)->create([
            'pointable_type'=> get_class($taskProject),
            'pointable_id'=> $taskProject->id
        ]);
            
        
        //intrus
        factory(Pointage::class, 1)->create();
            
        
        $this->assertCount(5, Pointage::forProject($project)->get());
    }


    /** @test */
    public function global_scope_test_with_multiple_scopes()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $taskProject = $project->tasks()->create(['name'=>'task-1', 'responsable_id'=>$user->id]);
        
        $taskProject->transformPointage(['is_facturable'=>1]);
       
        $q = Pointage::query()
        ->forProject($project)
        ->forMonth(now())
        ->forUser($user)
        ->facturable();
        
        $this->assertCount(1, $q->get());

        $founded = $q->get()->first();
        $this->assertEquals('task-1', $founded->name);
        $this->assertEquals('task-1(description)', $founded->description);
    }
}
