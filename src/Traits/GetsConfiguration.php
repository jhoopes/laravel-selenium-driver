<?php

namespace LaravelSeleniumDriver\Traits;

trait GetsConfiguration {



    protected function loadConfiguration()
    {

        if (file_exists(__DIR__ . '/../../../../../.env.seleniumConfig')) {
            \Dotenv::load(__DIR__ . '/../../../../..', '.env.seleniumConfig');
        }else {
            putenv('APP_ENV=testing');
            putenv('BASE_URL=http://localhost');
            putenv('USE_LARAVEL=false');
            putenv('BROWSER=firefox');
        }

        $this->setUpClassConfig();
    }

    public function setUpClassConfig() {

        $this->baseUrl = getenv('BASE_URL');

    }


}