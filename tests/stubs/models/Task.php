<?php

namespace FacturationRegie\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use FacturationRegie\Traits\IsRegiePointable;

class Task extends Model
{
    use IsRegiePointable;

    
    protected $guarded=[];

    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
