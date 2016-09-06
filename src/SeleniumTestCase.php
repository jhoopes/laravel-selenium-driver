<?php

namespace LaravelSeleniumDriver;

use LaravelSeleniumDriver\Traits\Application;
use LaravelSeleniumDriver\Traits\GetsConfiguration;
use LaravelSeleniumDriver\Traits\InteractsWithPage;
use LaravelSeleniumDriver\Traits\WaitForElements;
use LaravelSeleniumDriver\Traits\WorksWithLaravel;

class SeleniumTestCase extends \PHPUnit_Extensions_Selenium2TestCase
{
    use GetsConfiguration,
        WaitForElements,
        InteractsWithPage,
        Application,
        WorksWithLaravel;

    protected $baseUrl = 'http://localhost';

    protected function setUp()
    {

        $this->loadConfiguration();
        if(getenv('USE_LARAVEL') == 'true') {
            $this->setUpLaravel();
        }

        $this->setBrowser(getenv('BROWSER'));
        $this->setBrowserUrl($this->baseUrl);
    }

    protected function wait($seconds = 1)
    {
        sleep($seconds);

        return $this;
    }

}

