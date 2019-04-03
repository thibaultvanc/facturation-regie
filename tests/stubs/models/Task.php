<?php

namespace FacturationRegie\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use FacturationRegie\Traits\RegieInvoicable;

class Task extends Model
{
    use RegieInvoicable
}
