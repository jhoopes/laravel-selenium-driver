<?php

namespace LaravelSeleniumDriver\Traits;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
/**
 * Many functions contained in this class are from the laravel framework's Application trait
 * Class WorksWithLaravel
 * @package LaravelSeleniumDriver\Traits
 */
trait WorksWithLaravel {


    /**
     * Assert that a given where condition exists in the database.
     *
     * @param  string  $table
     * @param  array  $data
     * @param  string  $connection
     * @return $this
     */
    protected function seeInDatabase($table, array $data, $connection = null)
    {
        if(is_null($this->app)) {
            return null; // don't run when there is no application
        }

        $database = $this->app->make('db');

        $connection = $connection ?: $database->getDefaultConnection();

        $count = $database->connection($connection)->table($table)->where($data)->count();

        $this->assertGreaterThan(0, $count, sprintf(
            'Unable to find row in database table [%s] that matched attributes [%s].', $table, json_encode($data)
        ));

        return $this;
    }

    /**
     * Assert that a given where condition does not exist in the database.
     *
     * @param  string  $table
     * @param  array  $data
     * @param  string  $connection
     * @return $this
     */
    protected function missingFromDatabase($table, array $data, $connection = null)
    {
        return $this->notSeeInDatabase($table, $data, $connection);
    }

    /**
     * Assert that a given where condition does not exist in the database.
     *
     * @param  string  $table
     * @param  array  $data
     * @param  string  $connection
     * @return $this
     */
    protected function dontSeeInDatabase($table, array $data, $connection = null)
    {
        return $this->notSeeInDatabase($table, $data, $connection);
    }

    /**
     * Assert that a given where condition does not exist in the database.
     *
     * @param  string  $table
     * @param  array  $data
     * @param  string  $connection
     * @return $this
     */
    protected function notSeeInDatabase($table, array $data, $connection = null)
    {
        if(is_null($this->app)) {
            return null; // don't run when there is no application
        }

        $database = $this->app->make('db');

        $connection = $connection ?: $database->getDefaultConnection();

        $count = $database->connection($connection)->table($table)->where($data)->count();

        $this->assertEquals(0, $count, sprintf(
            'Found unexpected records in database table [%s] that matched attributes [%s].', $table, json_encode($data)
        ));

        return $this;
    }

    /**
     * Call artisan command and return code.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return int
     */
    public function artisan($command, $parameters = [])
    {
        if(is_null($this->app)) {
            return null; // don't run when there is no application
        }

        return $this->code = $this->app['Illuminate\Contracts\Console\Kernel']->call($command, $parameters);
    }

    /**
     * Set a user in laravel
     *
     * @param UserContract $user
     * @param null $driver
     */
    public function be(UserContract $user, $driver = null)
    {
        $this->app['auth']->driver($driver)->setUser($user);
    }

}