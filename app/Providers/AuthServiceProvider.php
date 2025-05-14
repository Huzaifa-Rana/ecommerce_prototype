<?php

namespace App\Providers;

use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Product::class => ProductPolicy::class,
    ];
    public function boot()
    {
        $this->registerPolicies();

        // Define gates for role-based access
        Gate::define('access-admin', function ($user) {
            return $user->hasRole('admin');
        });

        Gate::define('access-customer', function ($user) {
            return $user->hasRole('customer');
        });

        // Define gates for specific actions
        Gate::define('manage-products', function ($user) {
            return $user->hasPermissionTo('manage products');
        });

        Gate::define('view-dashboard', function ($user) {
            return $user->hasPermissionTo('view dashboard');
        });

        Gate::define('place-orders', function ($user) {
            return $user->hasPermissionTo('place orders');
        });

        // Define gate for checkout access - customers only
        Gate::define('access-checkout', function ($user) {
            return $user->hasRole('customer');
        });
    }
}
