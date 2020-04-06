<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FacebookLoginService;

class FacebookLoginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\SocialLoginServiceInterface', function() {
            return new FacebookLoginService(request('_fb_access_token'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
