<?php

namespace Moxga\BackendHelper;

use Illuminate\Support\ServiceProvider;

class BackendHelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'backendhelper');


        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/backendhelper'),
        ], 'views');

        // $this->publishes([
        //     __DIR__.'/../config/config.php' => config_path('backendhelper.php'),
        // ], 'config');

        $this->publishes([
            __DIR__.'/../public/assets' => public_path('vendor/backendhelper'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../BaseBackendController.php' => app_path('Http/Controllers/Backend/BaseBackendController.php'),
        ], 'controller');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(
        //     __DIR__.'/../config/config.php', 
        //     'backendhelper'
        // );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['backendhelper', 'Moxga\BackendHelper\BackendHelperService'];
    }
}
