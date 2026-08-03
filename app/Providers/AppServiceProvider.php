<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\Company;
use DB;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // When the app is served from a subdirectory (e.g. /tvt-erp), generated
        // url()/route() links must include that path or AJAX and redirects break.
        if (!$this->app->runningInConsole()) {
            $request = $this->app->bound('request') ? $this->app->make('request') : null;
            if ($request && $request->getHttpHost()) {
                URL::forceRootUrl(rtrim($request->getSchemeAndHttpHost() . $request->getBasePath(), '/'));
            }
        }

        // Make the company profile (name, address, contact details) available to
        // every view, including print/PDF templates and mailables.
        View::composer('*', function ($view) {
            $view->with('company', Company::current());
        });

        DB::listen(function($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });
    }
}
