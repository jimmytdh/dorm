<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage_users',fn(User $user) => $user->isAdmin());
        Gate::define('manage_beds',fn(User $user) => $user->isAdmin());
        Gate::define('manage_profiles',fn(User $user) => $user->isAdmin());
//        Gate::define('edit_document',function(User $user, Document $document, $section_id){
//            return $document->section_id === $section_id;
//        });
    }
}
