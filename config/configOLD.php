<?php

return [

    /**
     * Model class name of users.
     */
    'user_model' => config('auth.providers.users.model', App\User::class),
    /**
     * Table name of users table.
     */
    'users_table_name' => 'users',
    /**
     * Primary key of users table.
     */
    'users_table_primary_key' => 'id',
    /**
     * Foreign key of users table.
     */
    'users_table_foreign_key' => 'user_id',







    
    /**
     * Table name of pointable relations.
     */
    'pointable_table' => 'pointables',
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
