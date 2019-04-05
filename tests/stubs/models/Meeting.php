<?php

namespace FacturationRegie\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use FacturationRegie\Traits\RegieInvoicable;
use FacturationRegie\Traits\IsRegiePointable;

class Meeting extends Model
{
    use IsRegiePointable;

    
    protected $guarded=[];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    /**
     * overwrite parent method to set the 'user_id' field has the responsable
     *
     */
    public function regie_responsable()
    {
        return $this->belongsTo(config('facturation-regie.user_model'), 'user_id');
    }
}
