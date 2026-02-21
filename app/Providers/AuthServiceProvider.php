<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Registration;
use App\Policies\EventPolicy;
use App\Policies\RegistrationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Event::class => EventPolicy::class,
        Registration::class => RegistrationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
