<?php
namespace OneDayToDie\TicketSystem\Settings;

use Spatie\LaravelSettings\Settings;

class TicketSettings extends Settings
{

    public bool $enabled;
    public string $webhooknew;
    public string $webhookclosed;
    public string $webhookreply;

    public static function group(): string
    {
        return 'ticket';
    }


}
