<?php

namespace Tests\Unit\Selenium;

use App\Config;
use PHPUnit\Extensions\Selenium2TestCase;

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
        $this->url = $this->baseUrl . ':' . Config::getEnv('PORT') . $this->path;
        $this->url($this->url);
    }

    public function setUp(): void
    {
        $this->url = $this->baseUrl . ':' . Config::getEnv('PORT') . $this->path;
        $this->setBrowser('chrome');
        $this->setBrowserUrl($this->url);
    }

    public function skip($message = "Test Skipped"): void
    {
        $this->markTestSkipped(
            $message
        );
    }
}
