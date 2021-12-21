<?php

namespace Unit\Selenium;

use Unit\Selenium\SeleniumTest;

class HomePage extends SeleniumTest
{
    protected $url = 'http://localhost:8080';
    public function testLogin()
    {
        $this->url($this->url);
        $this->assertEquals('Login', $this->title());

        $page = new AuthenticationPage($this);
        $page->isLogout();
        $welcomePage = $page->username('nikkyamresh8@gmail.com')
            ->password('test')
            ->submit();
        $welcomePage->assertWelcomeIs('Nikky Amresh');

    }

    public function testLogout()
    {
        $this->url($this->url);
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
    }
}
