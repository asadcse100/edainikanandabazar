<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $host = url('/');
        view()->share('up_dir', $host.'/');
        view()->share('uploads_path', 'uploads/epaper/');
        view()->share('uploads_path_temp', 'uploads/temp/');
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
