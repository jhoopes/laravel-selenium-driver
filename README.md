# Laravel Selenium Driver for Laravel 5 and PHPUnit

This package is designed around much of what the integrated package from Jeffery Way.  It emulates much of the API from Laravel's existing testing packages for PHP Unit.


## Set Up / Install

1. Download the latest version of selenium 2 from here: https://github.com/SeleniumHQ/selenium/releases
2. If you are going to be using firefox as your browser, running the selenium server is all you need.
    * If you would like to use chrome, you will need to download the chrome driver and install it to your path (i.e. /usr/local/bin on a mac)
    * You can find the chrome driver here: https://sites.google.com/a/chromium.org/chromedriver/
3.  After you have downloaded those 2 things, install the package via composer


## Configuration and setting up your first test

 - This package uses a selenium .env file for certain settings.  You can create this file based on the sample below
 
Sample .env.seleniumConfig
```

# Application environment
APP_ENV=testing

# Which browser you'd like to use
BROWSER=chrome 

# The base url for the application on your local machine
BASE_URL=http://test.dev 

# Whether or not you'd like to boot up a laravel application during your testing
#   this is so you can use things like "seeInDatabase"
USE_LARAVEL=true

#If you booted laravel, set this to 1 if you'd like your database connection to be auto migrated
MIGRATE=0

#If you booted laravel, set this to 1 if you'd like your database connection to be auto seeded
SEED=0

#OPTIONAL:  You can optionally set the window's witdth and height with these values.  Be sure that they are integers
WINDOW_WIDTH=1250
WINDOW_HEIGHT=900
```

 - This configuration file is used in consort with the phpunit.xml file.
     - For example, to connect to the database through phpunit and working with laravel, you will need to set your database configuration information there.
     - Or make sure the database configuration setup in your normal .env file.
     - e.g. For when using homestead, this is what I would put in your phpunit.xml file
          
 ```xml
    <?xml version="1.0" encoding="UTF-8"?>
    <phpunit backupGlobals="false"
             backupStaticAttributes="false"
             bootstrap="bootstrap/autoload.php"
             colors="true"
             convertErrorsToExceptions="true"
             convertNoticesToExceptions="true"
             convertWarningsToExceptions="true"
             processIsolation="false"
             stopOnFailure="false">
        <testsuites>
            <testsuite name="Application Test Suite">
                <directory>./tests/</directory>
            </testsuite>
        </testsuites>
        <filter>
            <whitelist>
                <directory suffix=".php">app/</directory>
            </whitelist>
        </filter>
        <php>
            <env name="APP_ENV" value="testing"/>
            <env name="CACHE_DRIVER" value="array"/>
            <env name="SESSION_DRIVER" value="array"/>
            <env name="QUEUE_DRIVER" value="sync"/>
            <env name="DB_CONNECTION" value="mysql"/>
            <env name="DB_HOST" value="127.0.0.1:33060"/>
            <env name="DB_DATABASE" value="yourDatabase" />
            <env name="DB_USERNAME" value="homestead" />
            <env name="DB_PASSWORD" value="secret" />
        </php>
    </phpunit>
 ```
 - If you are using Laravel Valet, Your database should be local to your host, and so phpunit should be able to connect to it via the normal .env file
 - Once you have the configuration set up, please see examples to further understand how to set up your tests.

## Writing tests

 - Additional documentation is forthcoming, but I wanted to note that it is important to remember that selenium will be running a live session inside of your browser on the application.
    - Because of this, your phpunit session (if using laravel) when running tests will be entirely different than the one running within the browser.
    - Keep this in mind when performing "session" items within your test code and not running it within the web browser

## Running Tests

 - The first step before running tests is that you will need to start your selenium server
   - To do that, simply run ``` java -jar /path/to/selenium-server/selenium-server.jar```
 - To run your tests, you can run an entire directory or a single class with acceptance tests.
 - e.g.
```
phpunit tests/acceptance
phpunit tests/acceptance/ExampleTest.php
```
 - What should occur is that your web browser opens, and runs through the acceptance test
 
## Documentation
 
 - Documentation is currently in the works.
 - To see what is in the current API look through the traits directory for function names.
 
 
## Future features
 - A more fleshed out API
 - Additional helpers for JS widgets like selectize, dropzone, etc.
 - Tests for this package
 - Better documentation
  
  