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

    /**
     * Default baseUrl to use
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * The callbacks that should be run before the application is destroyed.
     *
     * @var array
     */
    protected $beforeApplicationDestroyedCallbacks = [];

    protected function setUp()
    {

        $this->loadConfiguration();
        if(getenv('USE_LARAVEL') == 'true') {
            $this->setUpLaravel();

            if(getenv('MIGRATE') == 1) {
                $this->migrate();
            }

            if(getenv('SEED') == 1) {
                $this->seed();
            }

        }

        $this->setBrowser(getenv('BROWSER'));
        $this->setBrowserUrl($this->baseUrl);
    }


    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        if ($this->app) {
            foreach ($this->beforeApplicationDestroyedCallbacks as $callback) {
                call_user_func($callback);
            }

            $this->app->flush();
            $this->app = null;
        }

        if (class_exists('Mockery')) {
            \Mockery::close();
        }
    }

    /**
     * Register a callback to be run before the application is destroyed.
     *
     * @param  callable  $callback
     * @return void
     */
    protected function beforeApplicationDestroyed(callable $callback)
    {
        $this->beforeApplicationDestroyedCallbacks[] = $callback;
    }


    protected function wait($seconds = 1)
    {
        sleep($seconds);

        return $this;
    }

}

