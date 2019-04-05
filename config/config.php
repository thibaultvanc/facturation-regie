<?php

return [

    /**
     * units
     */
    'units'=> [

        'ut'=>[
                'value' => 15,
                'label' => 'minutes',
                'amount' => 10,
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


    /**
     * Model class name of users.
     */
    'user_model' => config('auth.providers.users.model', App\User::class),
    'users_table_name' => 'users',
    'users_table_primary_key' => 'id',
    'users_table_foreign_key' => 'user_id',
    
    
    'followable_table' => 'followables',
    /**
     * Prefix of many-to-many relation fields.
     */
    'morph_prefix' => 'pointable',
    
    /**
     * Date format for created_at.
     */
    'date_format' => 'Y-m-d H:i:s',

    /**
     * Namespace of models.
     */
    'model_namespace' => 'App',
    
];
