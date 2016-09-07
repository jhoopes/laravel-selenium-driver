<?php

class AuthTest extends \Tests\Cases\SeleniumTestCase {

    /**
     * @test
     */
    public function it_can_login_and_logout()
    {
        $this->login('admin', 'password')
            ->waitForElementsWithClass('dashboard')
            ->click('Logout')
            ->see('Please log into the application');
    }

}