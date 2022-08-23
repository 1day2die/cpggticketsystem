<?php

namespace OneDayToDie\Ticketsystem;

use App\Enums\NavigationLocation;
use App\Helper\NavigationHelper;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $helper = app(NavigationHelper::class);

        $helper->importNavigationOptionsFromFolder(NavigationLocation::sidebar, __DIR__ . '/../../resources/sidebar');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $helper = app(NavigationHelper::class);

        $helper->removeNavigationOptionsFromFolder(__DIR__ . '/../../resources/sidebar');
    }
};
