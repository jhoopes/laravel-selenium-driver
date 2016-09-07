<?php

namespace Tests\Cases;

use App\User;

class LaravelSeleniumTestCase extends \LaravelSeleniumDriver\SeleniumTestCase
{
    /**
     * Helper method to log in, and set the user inside of the application if using laravel
     *
     * @param $username
     * @param $password
     * @return $this
     */
    protected function login($username, $password)
    {
        $this->visit('/')
            ->type($username, 'username')
            ->type($password, 'password')
            ->press('Login')
            ->see('Welcome')
            ->seePageIs('/dashboard');

        if(getenv('USE_LARAVEL') == 1) {
            $user = User::where('username', $username)->first();
            $this->be($user);
        }

        return $this;
    }


}
