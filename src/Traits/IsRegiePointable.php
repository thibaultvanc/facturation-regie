<?php

namespace FacturationRegie\Traits;

use FacturationRegie\Pointage;
use FacturationRegie\Exceptions\PointableWithoutResponsableException;

/**
 *
 * for ex : extends task or meeting
 */


trait IsRegiePointable
{
    public function pointages()
    {
        return $this->morphMany(Pointage::class, 'pointable');
    }
    
    
    public function regie_responsable()
    {
        return $this->belongsTo(config('facturation-regie.user_model'), 'responsable_id');
    }
    
    
    public function tranformPointage($user=null)
    {
        $responsable = $user?: $this->regie_responsable;

        //dd(__METHOD__.':'.__LINE__, '__ H E R E __');
        if (!$responsable) {
            throw new PointableWithoutResponsableException("the " . get_class($this) . " #" . $this->{$this->primaryKey} . " has no responsable", 1);
        }

        return $this->pointages()->create([
            'date'=>$this->getPointageDate(),
            'user_id'=>$responsable->id,
            'pointable_type'=>get_class($this),
            'pointable_id'=>$this->id,
            'name'=> $this->getPointageName(),
            'description'=> $this->getPointageDescription(),
        ]);
    }


    public function getPointageDate()
    {
        return now();
    }

    public function getPointageName()
    {
        return $this->name;
    }
    
    public function getPointageDescription()
    {
        return $this->name . '(description)';
    }
}
