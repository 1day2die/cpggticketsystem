<?php
namespace OneDayToDie\TicketSystem;


use App\Providers\BasePackageServiceProvider;
use App\Enums\NavigationLocation;

class TicketServiceProvider extends BasePackageServiceProvider
{
    public function boot()
    {
            $sidebarNavigation = __DIR__ . '/../resources/sidebar';

        $this->loadNavigation(NavigationLocation::sidebar, $sidebarNavigation);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ticket');
        $this->loadViewsFrom(__DIR__ . '/../resources/views/admin', 'adminticket');

        $this->loadJsonTranslationsFrom(__DIR__ . '/../lang/en.json');

        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/ticket'),
        ]);
    }
}


