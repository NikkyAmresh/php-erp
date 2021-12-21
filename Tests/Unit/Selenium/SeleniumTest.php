<?php

namespace Unit\Selenium;

use PHPUnit\Extensions\Selenium2TestCase;

class SeleniumTest extends Selenium2TestCase
{

    protected $url = 'https://www.google.com';

    protected function setUp():void
    {
        $this->setBrowser('chrome');
        $this->setBrowserUrl($this->url);
    }
}