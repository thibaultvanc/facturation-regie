<?php

namespace FacturationRegie\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Model;
use FacturationRegie\Exceptions\PointableWithoutResponsableException;
use FacturationRegie\Pointage;

class FacturationRegieController extends Controller
{
    /**
     * Transform a pointable (Task - Meeting)
     *
     * @return void
     */
    public function transform()
    {
        $class = request('class');
        $id = request('id');

        $instance = $class::findOrFail($id);

        try {
            $pointage = $instance->tranformPointage();
        } catch (PointableWithoutResponsableException $e) {
            return response(['data'=> 'Need to associate a user'], 422);
        }

        return response(['data'=> $pointage]);
    }
    
    
    
    
    public function store()
    {
        $a = request()->validate([
            
            'date'=>'required',
            'name'=>'required',
            'description'=>'required',
            'pointable_type'=>'required',
            'pointable_id'=>'required',
            'user_id'=>'required',
            'is_facturable'=>'required',
            ]);

        $pointage = Pointage::create($a);
            
        //dd(__METHOD__.':'.__LINE__, '$a', $pointage);

        return response(['data'=> $pointage]);
    }


    public function storeDay()
    {
        // dd(__METHOD__.':'.__LINE__, '__ H E R E __', request('date'));
    }
}
