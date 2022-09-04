<?php
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateTicketSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('ticket.enabled', 'true');
        $this->migrator->add('ticket.webhooknew', 'none');
        $this->migrator->add('ticket.webhookclosed', 'none');
        $this->migrator->add('ticket.webhookreply', 'none');
    }
}

