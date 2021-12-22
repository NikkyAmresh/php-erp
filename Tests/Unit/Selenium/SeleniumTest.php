<?php

namespace Tests\Unit\Selenium;

use PHPUnit\Extensions\Selenium2TestCase;
use App\Config;

class SeleniumTest extends Selenium2TestCase
{
    protected $baseUrl = 'http://localhost';
    protected $path = '/';
    protected $url;

    public static function setUpBeforeClass(): void
    {
        self::shareSession(true);
    }

    public function openUrl($path)
    {
        $this->path = $path;
        $this->url = $this->baseUrl.':'.Config::getEnv('PORT').$this->path;
        $this->url($this->url);
    }

    public function setUp(): void
    {
        $this->url = $this->baseUrl.':'.Config::getEnv('PORT').$this->path;
        $this->setBrowser('chrome');
        $this->setBrowserUrl($this->url);
    }
}
