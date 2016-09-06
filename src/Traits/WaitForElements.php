<?php

namespace LaravelSeleniumDriver\Traits;


use LaravelSeleniumDriver\Exceptions\CannotFindElement;

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
            throw new CannotFindElement("Can't find an element with the class name of "
                . $class. " within the time period of " . $timeout . " miliseconds");
        }

        return $this;
    }

    protected function waitForElementWithId($id, $timeout = 2000)
    {
        try{
            $this->waitForElement('Id', $id, $timeout);
        }catch (\Exception $e) {
            throw new CannotFindElement("Can't find an element with an ID of "
                . $id. " within the time period of " . $timeout . " miliseconds");
        }

        return $this;
    }

    protected function waitForElementWithXPath($xpath, $timeout = 2000)
    {
        try{
            $this->waitForElement('XPath', $xpath, $timeout);
        }catch (\Exception $e) {
            throw new CannotFindElement("Can't find an element with an XPath of "
                . $xpath. " within the time period of " . $timeout . " miliseconds");
        }

        return $this;
    }


}