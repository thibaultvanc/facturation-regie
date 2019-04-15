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

class PointableTest extends TestCase
{
    use RefreshDatabase;
    



    /** @test */
    public function a_pointable_can_be_transformed_to_pointage()
    {
        $task = factory(Task::class)->create();
        $this->assertCount(0, $task->pointages);
        
        $task->transformPointage();

        $task = $task->fresh();
        $this->assertCount(1, $task->pointages);
        $pointage = $task->pointages->first();

        $this->assertEquals(Task::class, $pointage->pointable_type);
        $this->assertEquals($task->id, $pointage->pointable_id);
    }



    /** @test */
    public function when_transforming_if_the_pointable_has_no_responsable_then_an_error_is_thrown()
    {
        $task = factory(Task::class)->create(['responsable_id'=>null]);
        $this->assertCount(0, $task->pointages);
        
        $this->expectException(PointableWithoutResponsableException::class);
        $task->transformPointage();
    }



    /** @test */
    public function a_pointable_belongs_to_a_user()
    {
        $pointage = factory(Pointage::class)->create([
            'user_id'=> $u= factory(User::class)->create()
        ]);
        
        $this->assertTrue($pointage->user->is($u));

        $this->assertInstanceOf(Pointage::class, $pointage);
    }



    /** @test */
    public function a_pointable_has_a_date()
    {
        $pointage = factory(Pointage::class)->create([
            'date'=> $n=now()
        ]);
        $this->assertEquals($n, $pointage->date);
    }

    /** @test */
    public function a_pointable_has_a_name_and_adescription()
    {
        $pointage = factory(Pointage::class)->create([
            'name'=> 'title-1',
            'description'=> 'description-1'
        ]);
        $this->assertEquals('title-1', $pointage->name);
        $this->assertEquals('description-1', $pointage->description);
    }


    /** @test */
    public function a_pointable_can_be_hors_forfait()
    {
        $pointage = factory(Pointage::class)->create([
            'is_facturable'=> true
        ]);
        $this->assertEquals(true, $pointage->is_facturable);
    }





    /** @test */
    public function a_pointable_belongs_to_a_project()
    {
        $project = factory(Project::class)->create();

        $task=factory(Task::class)->create(['project_id'=>$project->id]);
        $task->transformPointage();

        $this->assertCount(1, $project->getPointages());
    }
}
