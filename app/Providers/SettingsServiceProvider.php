<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Admin\Settings;

class SettingsServiceProvider extends ServiceProvider
{

    /**
     * @var string
     */
    public const MAIL_CODE = 'mail_settings';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (\Schema::hasTable('settings')) {
            $settings = Settings::where('settings_code', self::MAIL_CODE)->first();
            if ($settings) {
                $config = [
                    'driver' => $settings->settings['send_method'],
                    'host' => $settings->settings['server_name'],
                    'port' => $settings->settings['smtp_port'],
                    'from' => [
                        'address' => $settings->settings['address_from'],
                        'name' => $settings->settings['name_from'],
                    ],
                    'encryption' => $settings->settings['encrypt_protocol'],
                    'username' => $settings->settings['server_login'],
                    'password' => $settings->settings['server_password'],
                    'sendmail' =>  '/usr/sbin/sendmail -bs',
                ];
                \Config::set('mail', $config);
            }
        }
    }
}
