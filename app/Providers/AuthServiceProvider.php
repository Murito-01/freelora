<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Client;
use App\Policies\ClientPolicy;

class AuthServiceProvider extends ServiceProvider {
    protected $policies = [
        Client::class => ClientPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}