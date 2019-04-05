<?php

namespace FacturationRegie\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use FacturationRegie\Traits\RegieProject;
use FacturationRegie\Tests\Stubs\Models\Meeting;

class Project extends Model
{
    use RegieProject;

    protected $guarded=[];


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    
    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
