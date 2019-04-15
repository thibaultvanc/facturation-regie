<?php

namespace FacturationRegie;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    protected $guarded = [];

    protected $casts = ['units'=>'float'];

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

    public function scopeNonAchieved($query)
    {
        return $query->whereNull('units')->orWhereNull('unit_type');
    }
    
    public function scopeForProject($query, $project)
    {
        $ids = $project->getPointages()->pluck('id');
        return $query->whereIn('id', $ids);
    }

    
    public static function getUnits()
    {
        return array_keys(config('facturation-regie.units'));
    }



    public static function verifyUserDay($user, Carbon $date)
    {
        if (!is_object($user)) {
            $userClass = config('facturation-regie.user_model');
            $user = $userClass::find($user);
        }

        $utSum =  (float) self::forDay($date)
        ->forUser($user)
        ->where('unit_type', 'ut')
        ->sum('units');

        $min = config('facturation-regie.units.ut.min_per_day');

        //dd(__METHOD__.':'.__LINE__, '$utSum', $utSum);
        return $utSum == $min;
    }
}
