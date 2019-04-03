<?php

dd(__METHOD__.':'.__LINE__, '__ H E R E __');


return [
    
    'user_model' => config('auth.providers.users.model', App\User::class),
    'invoice_model' => 'App\User',
    'order_model' => 'App\User',
    'invoice_model' => 'App\User',


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
    ]
];
