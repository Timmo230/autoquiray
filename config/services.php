<?php

$appUrl = trim((string) env('APP_URL', ''));
$appHost = $appUrl !== '' ? (string) parse_url($appUrl, PHP_URL_HOST) : '';
$plausibleDomain = trim((string) env('PLAUSIBLE_DOMAIN', ''));

if ($plausibleDomain === '' && $appUrl !== '') {
    $plausibleDomain = $appHost;
}

if (filter_var($plausibleDomain, FILTER_VALIDATE_URL)) {
    $plausibleDomain = (string) parse_url($plausibleDomain, PHP_URL_HOST);
}

$isPrivateOrLocalDomain = $plausibleDomain === 'localhost'
    || $plausibleDomain === '127.0.0.1'
    || (
        filter_var($plausibleDomain, FILTER_VALIDATE_IP) !== false
        && filter_var(
            $plausibleDomain,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) === false
    );

if ($isPrivateOrLocalDomain && $appHost !== '') {
    $plausibleDomain = $appHost;
}

$plausibleScriptUrl = trim((string) env('PLAUSIBLE_SCRIPT_URL', ''));

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

    'plausible' => [
        'enabled' => (bool) env('PLAUSIBLE_ENABLED', false),
        'domain' => $plausibleDomain,
        'script_url' => $plausibleScriptUrl,
    ],
];
