<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // You can define gates here for custom authorization logic
        // Gate::define('update-post', function ($user, $post) {
        //     return $user->id === $post->user_id;
        // });
        // Optionally define gates here
        Gate::define('view-dashboard', function ($user) {
            return $user->hasRole('SuperAdmin'); // Example gate definition
        });
    }
}
