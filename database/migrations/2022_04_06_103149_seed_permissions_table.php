<?php

namespace Controlpanel\Vouchers;

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
        Permission::findOrCreate('ticket.read');
        Permission::findOrCreate('ticket.write');
        Permission::findOrCreate('admin.ticket.read');
        Permission::findOrCreate('admin.ticket.write');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::findByName('controlpanel.vouchers.read')->delete();
        Permission::findByName('controlpanel.vouchers.write')->delete();
    }
};
