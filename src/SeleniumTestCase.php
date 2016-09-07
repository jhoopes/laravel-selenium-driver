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
        if (getenv('USE_LARAVEL') == 'true') {
            $this->setUpLaravel();

            if (getenv('MIGRATE') == 1) {
                $this->migrate();
            }

            if (getenv('SEED') == 1) {
                $this->seed();
            }

        }

        $this->setBrowser(getenv('BROWSER'));
        $this->setBrowserUrl($this->baseUrl);
    }

    public function setupPage()
    {
        if (!empty(getenv('WINDOW_WIDTH')) && !empty(getenv('WINDOW_HEIGHT')) &&
            is_int(intval(getenv('WINDOW_WIDTH'))) && is_int(intval(getenv('WINDOW_HEIGHT')))) {
            $this->prepareSession()->currentWindow()->size([
                'width'  => intval(getenv('WINDOW_WIDTH')),
                'height' => intval(getenv('WINDOW_HEIGHT'))
            ]);
        }
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
     * @param  callable $callback
     * @return void
     */
    protected function beforeApplicationDestroyed(callable $callback)
    {
        $this->beforeApplicationDestroyedCallbacks[] = $callback;
    }


    /**
     * Sleep for a time in seconds
     *
     * @param int|float $seconds Can be less than one for less than a second
     * @return $this
     */
    protected function wait($seconds = 1)
    {

        usleep($seconds * 1000000);

        return $this;
    }

}

