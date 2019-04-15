<?php

namespace FacturationRegie\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Model;
use FacturationRegie\Exceptions\PointableWithoutResponsableException;
use FacturationRegie\Pointage;

class FacturationRegieController extends Controller
{
    public function index()
    {
        $query = Pointage::query();



        return response(['data'=> $query->get()]);
    }
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
            $pointage = $instance->transformPointage();
        } catch (PointableWithoutResponsableException $e) {
            return response(['data'=> 'Need to associate a user'], 422);
        }

        return response(['data'=> $pointage]);
    }
    
    
    protected function validateData()
    {
        return request()->validate([
            
            'date'=>'required|date:d-m-Y',
            'name'=>'required|min:10',
            'description'=>'required|min:10',
            'pointable_type'=>'required',
            'pointable_id'=>'required',
            'user_id'=>'required',
            'is_facturable'=>'required',
            ]);
    }
    
    public function store()
    {
        $a = $this->validateData();
        $pointage = Pointage::create($a);
        return response(['data'=> $pointage]);
    }


    public function verifyDaily()
    {
        request()->validate([
            'date'=>'required|date:d-m-Y',
            'user_id'=>'required',
        ]);

        $date = \Carbon\Carbon::createFromFormat('d-m-Y', request('date'));
        

        $response = Pointage::verifyUserDay(request('user_id'), $date);
        return response(['data'=> $response]);
    }
    
    
    
    public function delete($pointage)
    {
        $pointage = Pointage::findOrFail($pointage);
        if (auth()->user()->id !== $pointage->user->id) {
            abort('you are not authorized to delete this pointage, sorry....');
        }

        $pointage->delete();
        return response(['data'=> 'deleted']);
    }

    
    public function update($pointage)
    {
        $pointage = Pointage::findOrFail($pointage);
        if (auth()->user()->id !== $pointage->user->id) {
            abort('you are not authorized to update this pointage, sorry....');
        }
        $a = $this->validateData();
        
        $pointage->update($a);

        return response(['data'=> $pointage]);
    }
}
