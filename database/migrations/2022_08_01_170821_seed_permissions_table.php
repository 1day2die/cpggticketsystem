<?php

namespace OneDayToDie\Ticketsystem;

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::findOrCreate('1day2die.ticket.read');
        Permission::findOrCreate('1day2die.ticket.write');
        Permission::findOrCreate('1day2die.admin.ticket.read');
        Permission::findOrCreate('1day2die.admin.ticket.write');
        Permission::findOrCreate('1day2die.admin.ticket.settings');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::findByName('1day2die.ticket.read')->delete();
        Permission::findByName('1day2die.ticket.write')->delete();
        Permission::findByName('1day2die.admin.ticket.read')->delete();
        Permission::findByName('1day2die.admin.ticket.write')->delete();
        Permission::findByName('1day2die.admin.ticket.settings')->delete();
    }
};
