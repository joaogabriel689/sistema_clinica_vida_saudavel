<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'zapi' => [
        'url' => env('URL_Z_API'),
        'token' => env('TOKEN_Z_API'),
        'instance' => env('INSTANCE_Z_API'),
        'client_token' => env('CLIENTE_TOKEN_Z_API'),
    ],

    'evolution' => [
        'url' => env('EVOLUTION_API_URL', 'http://evolution-api:8080'),
        'api_key' => env('EVOLUTION_API_KEY', 'change_me_evolution_api_key'),
    ],

    'asaas' => [
        'api_key' => env('ASAAS_API_KEY'),
        'webhook_token' => env('ASAAS_WEBHOOK_TOKEN'),
        'environment' => env('ASAAS_ENVIRONMENT', 'sandbox'),
        'url' => env('ASAAS_ENVIRONMENT', 'sandbox') === 'production' 
            ? 'https://api.asaas.com/v3' 
            : 'https://sandbox.asaas.com/api/v3',
    ],

];
