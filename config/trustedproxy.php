<?php

use Symfony\Component\HttpFoundation\Request;

return [

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | Enable this setting to trust Laravel's proxy headers. This is useful
    | if you are behind a load balancer or reverse proxy. You can specify
    | which proxies to trust by IP address or CIDR notation.
    |
    */

    'proxies' => env('TRUSTED_PROXIES', '*'),

    /*
    |--------------------------------------------------------------------------
    | Trusted Headers
    |--------------------------------------------------------------------------
    |
    | Specify which headers to trust from the proxy. By default, Laravel
    | trusts the X-Forwarded-For, X-Forwarded-Host, and X-Forwarded-Proto
    | headers. You can customize this list as needed.
    |
    */

    'headers' => Request::HEADER_X_FORWARDED_FOR
        | Request::HEADER_X_FORWARDED_HOST
        | Request::HEADER_X_FORWARDED_PORT
        | Request::HEADER_X_FORWARDED_PROTO,

];
