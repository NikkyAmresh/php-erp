<?php

namespace Unit\Selenium;

use Unit\Selenium\SeleniumTest;

class HomePage extends SeleniumTest
{
    public function testLogin()
    {
        $this->url('http://localhost:8080');
        $this->assertEquals('Login', $this->title());

        $page = new AuthenticationPage($this);
        $welcomePage = $page->username('nikkyamresh8@gmail.com')
            ->password('test')
            ->submit();
        $welcomePage->assertWelcomeIs('Nikky Amresh');
    }
}
