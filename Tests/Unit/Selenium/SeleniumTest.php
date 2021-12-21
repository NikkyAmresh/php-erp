<?php

namespace Unit\Selenium;

use PHPUnit\Extensions\Selenium2TestCase;

class SeleniumTest extends Selenium2TestCase
{

    public static function setUpBeforeClass(): void
    {
        self::shareSession(true);
    }

    public function setUp(): void
    {
        $this->setBrowser('chrome');
        $this->setBrowserUrl($this->url);
    }
}
