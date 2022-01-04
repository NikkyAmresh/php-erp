<?php

namespace Tests\Unit\Selenium;

use App\Config;
use Core\Container;
use Core\Model;
use PHPUnit\Extensions\Selenium2TestCase;

class SeleniumTest extends Selenium2TestCase
{
    protected $baseUrl = 'http://localhost';
    protected $path = '/';
    protected $url;
    protected static $container;

    public static function cleanDB()
    {
        self::$container = new Container();

        $model = self::$container->get(Model::class);
        $tables = ['admin', 'teachers', 'students', 'users', 'departments'];

        foreach ($tables as $table) {
            print("\nCleaning table..." . $table . ' ');
            $model->bind()->runQuery('DELETE FROM ' . $table . ' WHERE 1');
            print("Done");
        }
        print("\n");
    }

    public static function setUpBeforeClass(): void
    {
        self::cleanDB();
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
