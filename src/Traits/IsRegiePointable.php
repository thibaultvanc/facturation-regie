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
    
    
    public function transformPointage(array $data=[])
    {
        $responsable = array_key_exists('user', $data) ? $data['user'] : $this->regie_responsable;
        $date = array_key_exists('date', $data) ? $data['date'] : $this->getPointageDate();
        $name = array_key_exists('name', $data) ? $data['name'] : $this->getPointageName();
        $description = array_key_exists('description', $data) ? $data['description'] : $this->getPointageDescription();
        $is_facturable = array_key_exists('is_facturable', $data) ? $data['is_facturable'] : false;

        if (!$responsable) {
            throw new PointableWithoutResponsableException("the " . get_class($this) . " #" . $this->{$this->primaryKey} . " has no responsable", 1);
        }

        return $this->pointages()->create([
            'date'=>$date,
            'is_facturable'=>$is_facturable,
            'user_id'=>$responsable->id,
            'pointable_type'=>get_class($this),
            'pointable_id'=>$this->id,
            'name'=> $name,
            'description'=> $description,
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
