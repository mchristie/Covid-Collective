<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Covid\Users\Domain\UsersQuery;
use Covid\Users\Domain\UserId;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();
        
        $this->app->rebinding('request', function ($app, $request) {
            $request->setUserResolver(function() use($app, $request) {
                if (!$request->session()->has('userId')) {
                    return null;
                }
                $users = $app->get(UsersQuery::class);
                
                $userId = new UserId($request->session()->get('userId'));

                return $users->find($userId);
            });
        });
    }
}
