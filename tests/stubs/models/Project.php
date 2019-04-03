<?php

namespace FacturationRegie\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use FacturationRegie\Traits\RegieProject;

class Project extends Model
{
    use RegieProject;
}
