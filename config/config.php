<?php
use FacturationRegie\Tests\Stubs\Models\Project;
use FacturationRegie\Tests\Stubs\Models\Task;

return [

    /**
     * units
     */
    'units'=> [

        'ut'=>[
                'value' => 15,
                'label' => 'minutes',
                'amount' => 10,
                'min_per_day'=>32,
        ],

        'km'=>[
                'value' => 1,
                'label' => 'km',
                'amount' => 2,
        ],
        
        'money'=>[
                'value' => 1,
                'label' => '€',
                'amount' => 1,
        ],

    ],

    /**
     * tags
     */
    'tags' => [
        'Déplacement',
        'Bureau',
        'Réunion',
        'Péage',
        'Stationnement',
        'Autre'
    ],


    'pointable_classes'=>[
        \FacturationRegie\Tests\Stubs\Models\Task::class,
        \FacturationRegie\Tests\Stubs\Models\Meeting::class,
    ],

    'pointables_project_foreign_key' => 'project_id',



    /**
     * Model class name of users.
     */
    'user_model' => config('auth.providers.users.model', App\User::class),
    'users_table_name' => 'users',
    'users_table_primary_key' => 'id',
    'users_table_foreign_key' => 'user_id',
    


    /**
     * Model class name of Project.
     'project_model' => \FacturationRegie\Tests\Stubs\Models\Project::class,
     'projects_table_name' => 'projects',
     'projects_table_primary_key' => 'id',
     'projects_table_foreign_key' => 'project_id',
     */
    



    

];
