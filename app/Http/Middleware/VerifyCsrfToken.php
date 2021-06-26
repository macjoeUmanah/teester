<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    protected $except = [
        '/webform_save_data',
        '/installation',
        '/callback/mailgun',
        '/callback/sendgrid',
        '/callback/elasticemail',
        '/callback/mailjet'
    ];
}
