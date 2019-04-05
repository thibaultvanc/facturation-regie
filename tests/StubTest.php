<?php

namespace FacturationRegie\Tests;

use FacturationRegie\Pointage;
use FacturationRegie\Traits\RegieInvoicable;
use FacturationRegie\Tests\Stubs\Models\Task;
use FacturationRegie\Tests\Stubs\Models\User;
use FacturationRegie\Tests\Stubs\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use FacturationRegie\Tests\Stubs\Models\Meeting;
use FacturationRegie\Traits\IsRegiePointable;

//use FacturationRegie\Tests\TestCase;

//use PHPUnit\Framework\TestCase;

class StubTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_can_create_the_models_stubs()
    {
        $user = factory(User::class)->create(['name'=>'thibault']);
        $this->be($user);
        $this->assertEquals('thibault', $user->name);
        $this->assertEquals('thibault', auth()->user()->name);
        
        $project = factory(Project::class)->create(['name'=>'project-1']);
        $this->assertEquals('project-1', $project->name);
        
        $task = factory(Task::class)->create(['name'=>'task-1']);
        $this->assertEquals('task-1', $task->name);
    }
    
    
    /** @test */
    public function pointables_models_belongs_to_a_user_responsable()
    {
        $user = factory(User::class)->create(['name'=>'thibault']);

        $task = factory(Task::class)->create(['name'=>'task-1', 'responsable_id' => $user->id]);
        $this->assertTrue($task->regie_responsable->is($user));
        
        
        $meeting = factory(Meeting::class)->create(['name'=>'meeting-1', 'user_id' => $user->id]);
        $this->assertTrue($meeting->regie_responsable->is($user));
    }

    /** @test */
    public function a_project_has_many_tasks()
    {
        $project = Project::create(['name'=>'project-1']);

        $task = $project->tasks()->create(['name'=>'task-for-project-1']);

        $this->assertTrue($task->project->is($project));
        $this->assertTrue($project->tasks->first()->is($task));
    }
    
    
    /** @test */
    public function a_project_has_many_meetings()
    {
        $project = factory(Project::class)->create();
        
        $meeting = $project->meetings()->create(factory(Meeting::class)->raw());

        $this->assertTrue($meeting->project->is($project));
        $this->assertTrue($project->meetings->first()->is($meeting));
    }



    /** @test */
    public function meeting_and_task_model_has_trait_invoicable()
    {
        $this->assertContains(IsRegiePointable::class, array_keys((new \ReflectionClass(Task::class))->getTraits()));
        $this->assertContains(IsRegiePointable::class, array_keys((new \ReflectionClass(Meeting::class))->getTraits()));
    }






    // meeting extends Invoicable
}
