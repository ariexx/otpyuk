<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public int $rate;

    public int $profit;

    public static function group(): string
    {
        return 'general';
    }
}
