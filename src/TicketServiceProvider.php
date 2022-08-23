<?php

namespace OneDayToDie\Ticketsystem;

use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
{
    public function boot()
    {
            $sidebarNavigation = __DIR__ . '/../resources/sidebar'
    
        $this->loadNavigation(NavigationLocation::sidebar, $sidebarNavigation);
        
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ticket');

        $this->loadJsonTranslationsFrom(__DIR__ . '/../lang/en.json');

        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/ticket'),
        ]);
    }
}


