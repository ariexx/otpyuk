<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'OTPYuk');
        $this->migrator->add('general.rate', 249);
        $this->migrator->add('general.profit', 10);
    }
}
