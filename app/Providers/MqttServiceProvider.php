<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Bluerhinos\phpMQTT\phpMQTT;
class MqttServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mqtt', function () {
            $host = 'q35da851.ala.us-east-1.emqxsl.com';
            $port = '8883';
            $clientId = 'your_client_id';
            $username = 'your_mqtt_username';
            $password = 'your_mqtt_password';
    
            return new phpMQTT($host, $port, $clientId);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
