<?php

/*
|--------------------------------------------------------------------------
| Honour this project's .env over leftover process variables
|--------------------------------------------------------------------------
|
| On a shared XAMPP stack, Windows or Apache can already have DB_DATABASE
| set (e.g. kitchen_db from another project). phpdotenv will not overwrite
| those by default, so this ERP would query the wrong database and login
| would fail looking for financial_years. Load .env mutably first so this
| application's values always win.
|
*/

$envPath = dirname(__DIR__);
if (class_exists(\Dotenv\Dotenv::class) && is_file($envPath.DIRECTORY_SEPARATOR.'.env')) {
    \Dotenv\Dotenv::createMutable($envPath)->safeLoad();
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
