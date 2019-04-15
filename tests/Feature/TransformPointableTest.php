<?php

namespace FacturationRegie\Tests;

use FacturationRegie\Pointage;
use FacturationRegie\Tests\Stubs\Models\Task;
use FacturationRegie\Tests\Stubs\Models\User;
use FacturationRegie\Tests\Stubs\Models\Meeting;
use FacturationRegie\Tests\Stubs\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use FacturationRegie\Exceptions\PointableWithoutResponsableException;

//use FacturationRegie\Tests\TestCase;

//use PHPUnit\Framework\TestCase;

class TransformPointableTest extends TestCase
{
    use RefreshDatabase;


    
    /** @test */
    public function can_transform_a_pointable()
    {
        $this->withoutExceptionHandling();
        $meeting = factory(Meeting::class)->create();

        $response = $this->post(route('facturation-regie.transform'), [
            'class'=>Meeting::class,
            'id'=>$meeting->id
        ]);

        $response->assertOk();
        $a = $response->decodeResponseJson()['data'];
        $this->assertEquals(1, $a['pointable_id']);
        $this->assertEquals(Meeting::class, $a['pointable_type']);
    }
    

    /** @test */
    public function cannot_transform_a_pointable_without_responsable()
    {
        $this->withoutExceptionHandling();
        $task = factory(Task::class)->create(['responsable_id'=>null]);
        $response = $this->post(route('facturation-regie.transform'), [
            'class'=>Task::class,
            'id'=>$task->id
        ]);

        $response->assertStatus(422);
    }
}
