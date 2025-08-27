<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleChargeSucceeded(array $payload)
    {
        \Log::info('hello from my webhook controller');
    }
}
