<?php

namespace LaravelSeleniumDriver\Traits;


trait WaitForElements {


    protected $waitForTypes = ['Id', 'CssSelector', 'ClassName', 'XPath'];


    protected function waitForElement($type, $value, $timeout)
    {

        if(!in_array($type, $this->waitForTypes)) {
            throw new \Exception('Invalid waitfor element type to wait for on the page');
        }

        $webdriver = $this;
        $this->waitUntil(function() use($type, $value, $webdriver) {

            $function = 'by' . $type;

            try {
                $webdriver->$function($value);

                return true;
            }catch (\Exception $e) {
                return null; // haven't found the element yet
            }

        }, $timeout);
    }

    protected function waitForElementsWithClass($class, $timeout = 2000)
    {
        try{
            $this->waitForElement('ClassName', $class, $timeout);
        }catch (\Exception $e) {
            throw new \CannotFindElement("Can't find an element with the class name of "
                . $class. " within the time period of " . $timeout . " miliseconds");
        }

        return $this;
    }


}