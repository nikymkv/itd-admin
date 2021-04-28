<?php
namespace App\Services\Admin;

use App\Models\Admin\Settings;
use App\Providers\SettingsServiceProvider;

class SettingsService
{
    public function getMailSettings()
    {
        $settings = Settings::firstWhere('settings_code', SettingsServiceProvider::MAIL_CODE);
        return $settings;
    }

    public function setMailSettings($data)
    {
        $settings = Settings::updateOrCreate(
            ['settings_code' => SettingsServiceProvider::MAIL_CODE],
            $data,
        );
        return isset($settings) ? true : false;
    }
}