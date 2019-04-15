<?php

namespace FacturationRegie\Tests;

use FacturationRegie\Pointage;

use FacturationRegie\Tests\Stubs\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use FacturationRegie\Tests\Stubs\Models\Task;

class PointageListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_the_pointage_list()
    {
        $this->be(factory(User::class)->create());

        factory(Pointage::class)->create();
        
        $data = $this->get(route('facturation-regie.pointage.index'))
                    ->assertOk()
                    ->decodeResponseJson()['data'];
        
        $this->assertCount(1, $data);
    }
}
