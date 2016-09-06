<?php

namespace LaravelSeleniumDriver\Traits;

trait Application
{

    protected $app;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUpLaravel()
    {
        if (!$this->app) {
            $this->app = $this->createApplication();
        }
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDownLaravel()
    {
        if ($this->app) {
            $this->app->flush();
        }
    }

    /**
     * Creates the application.
     * Note that Configuration has been loaded already through Dotenv.
     * Because of that, overlapping environment variables will already be set
     *
     * @return \Illuminate\Foundation\Application
     */
    protected function createApplication()
    {
        $app = require __DIR__ . '/../../../../../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    /**
     * Migrate the database
     */
    protected function migrate()
    {
        $this->artisan('migrate:refresh');
    }

    /**
     * Seed a given database connection.
     *
     * @param  string  $class
     * @return void
     */
    public function seed($class = 'DatabaseSeeder')
    {
        $this->artisan('db:seed', ['--class' => $class]);
    }


}