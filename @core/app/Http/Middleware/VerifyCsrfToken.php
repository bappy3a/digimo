<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'paytm-ipn',
        'paypal-ipn',
        'event-paypal-ipn',
        'event-paytm-ipn',
        'donation-paypal-ipn',
        'donation-paytm-ipn',
        'product-paypal-ipn',
        'product-paytm-ipn',
        'admin-home/update-static-option',
        'admin-home/get-static-option',
        'admin-home/set-static-option',
        'job-paypal-ipn',
        'job-paytm-ipn',
        'appointment-paytm-ipn',
        'courses-paytm-ipn',
    ];
}
