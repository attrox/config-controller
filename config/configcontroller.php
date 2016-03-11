<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Configuration for ConfigController
    |--------------------------------------------------------------------------
    |
    | Page name is placed within an array associated with 'slug'.
    |
    | Each slug should have an entry of an array called 'input' which corresponds
    | to an html input form available within the admin controller.
    |
    | A slug should have an entries in both 'input' and 'content' array below.
    |
    |
    */
    'slug' => ['page-1', 'page-2'],

    /*
    | The accepted user input to update configuration content.
    | This is used by the admin interface to determine accepted user input.
    |
    | Format: 'name_of_configurable_content' => 'type',
    | where 'type' matches the method name of Laravel Form facade.
    | See (https://laravel.com/docs/4.2/html)
    |
    | Eg: Your view can simply call Form::$type to generate Form::text
    */
    'input' => [
        // Matches the slug config above
        'page-1' => [
            'name' => 'text',
            'e_mail' => 'email'
        ],

        'page-2' => []
    ],

    /*
    | The configurable content.
    | Format is 'key' => 'value', where 'key' must match the 'name_of_configurable_content' set in the 'input' above
    */
    'content' => [
        // Matches the slug config above
        'page-1' => [
            'name' => 'First Name',
            'e_mail' => 'test@test.com',
        ],

        'page-2' => []
    ]

];
