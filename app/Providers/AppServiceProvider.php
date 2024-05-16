<?php

namespace App\Providers;


use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider{

    protected $policies = [
        Post::class =>PostPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

/*        Gate::define('create_post', function () {
            return Auth::user()->is_admin;
        });

        Gate::define('update_post', function () {
            return Auth::user()->is_admin;
        });


        Gate::define('delete_post', function () {
            return Auth::user()->is_admin;
        });*/

    }
}
