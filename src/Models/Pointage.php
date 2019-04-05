<?php

namespace FacturationRegie;

use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    protected $guarded = [];

    public function pointable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(config('facturation-regie.user_model'), 'user_id');
    }


    public function scopeBetween($query, $a, $b)
    {
        return $query->whereBetween('date', [$a->startOfDay(), $b->endOfDay()]);
    }

    public function scopeForDay($query, $a)
    {
        return $query->whereDay('date', $a);
    }
    
    public function scopeForMonth($query, $a)
    {
        return $query->whereMonth('date', $a);
    }
    
    public function scopeForYear($query, $a)
    {
        return $query->whereYear('date', $a);
    }
    
    public function scopeForUser($query, $user)
    {
        if (is_object($user)) {
            $user = $user->{$this->primaryKey};
        }

        return $query->where('user_id', $user);
    }
    
    
    public function scopeFacturable($query)
    {
        return $query->where('is_facturable', 1);
    }
    
    public function scopeNoFacturable($query)
    {
        return $query->where('is_facturable', 0);
    }
}
