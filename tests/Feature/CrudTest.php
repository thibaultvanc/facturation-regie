<?php

namespace FacturationRegie\Tests;

use FacturationRegie\Pointage;

use FacturationRegie\Tests\Stubs\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use FacturationRegie\Tests\Stubs\Models\Task;

class CrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function auth_users_CAN_delete_their_own_pointage()
    {
        $this->be($u=factory(User::class)->create());
        $pointage = factory(Pointage::class)->create(['user_id'=>$u->id]);
        
        $this->assertDatabaseHas('pointages', $pointage->toArray());

        $this->delete(route('facturation-regie.pointage.delete', [$pointage]))
                ->assertOk();

        $this->assertDatabaseMissing('pointages', $pointage->toArray());
    }




    /** @test */
    public function auth_users_CANNOT_delete_pointage_of_other_users()
    {
        $user = $u=factory(User::class)->create();
        
        $this->be($malwareUser=factory(User::class)->create());
        
        $pointage = factory(Pointage::class)->create(['user_id'=>$u->id]);
        
        $this->assertDatabaseHas('pointages', $pointage->toArray());

        $this->delete(route('facturation-regie.pointage.delete', [$pointage]));

        $this->assertDatabaseHas('pointages', $pointage->toArray());
    }




    /** @test */
    public function auth_users_CAN_update_their_own_pointage()
    {
        $user = $this->be($u=factory(User::class)->create());
        
        $pointage = factory(Pointage::class)->create(['user_id'=>$u->id, 'name'=>'name-1']);
        
        $this->assertDatabaseHas('pointages', $pointage->toArray());


        $this->put(route('facturation-regie.pointage.update', [$pointage->id]), $new = [
            'date'=>now(),
            'name'=>'modified....',
            'description'=>'description 2 du pointage',
            'pointable_type'=>$pointage->pointable_type,
            'pointable_id'=>$pointage->pointable_id,
            'user_id'=>factory(User::class)->create()->id,
            'is_facturable'=>true
        ])
        ->assertOk();

        $this->assertDatabaseHas('pointages', $new);
    }
}
