<?php

namespace LaravelSeleniumDriver;

class SeleniumTestCase extends \PHPUnit_Extensions_Selenium2TestCase
{

    protected $baseUrl = 'http://dieselforward.dev';

    protected function setUp()
    {
        $this->setBrowser('chrome');
        $this->setBrowserUrl($this->baseUrl);
    }

    protected function visit($path)
    {
        $this->url($path);

        return $this;
    }

    protected function see($text, $tag = 'body')
    {

        //$this->assertEquals($text, $this->byTag($tag)->text());
        $this->assertContains($text, $this->byTag($tag)->text());
        return $this;
    }

    protected function type($value, $name)
    {
        $this->byName($name)->value($value);

        return $this;
    }

    protected function press($text)
    {
        $this->byXPath("//button[contains(text(), '{$text}')]")->click();
        return $this;
    }

    protected function wait($seconds = 1)
    {
        sleep($seconds);

        return $this;
    }

    protected function seePageIs($path)
    {

        $this->assertEquals($this->baseUrl . $path, $this->url());

        return $this;
    }


    /**
     * @param $class the class you're looking for
     * @param int $timeout miliseconds to timeout with
     */
    public function waitForElementsWithClass($class, $timeout = 2000) {

        $this->waitUntil(function() use($class, $this) {

            try {
                $this->byClassName($class);
            }

        }, $timeout);

    }

}

