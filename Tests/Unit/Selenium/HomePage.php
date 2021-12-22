<?php

namespace Tests\Unit\Selenium;

use Tests\Unit\Selenium\SeleniumTest;
class HomePage extends SeleniumTest
{
    public function testLogin()
    {
        $this->openUrl('/');
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
        $this->openUrl('/');
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
    }

    public function testAdminLogin()
    {
        $this->openUrl('/admin');
        $this->assertEquals('Login', $this->title());
        $page = new AuthenticationPage($this);
        $page->isLogout();
        $welcomePage = $page->username('nikkyamresh8@gmail.com')
            ->password('test')
            ->submit();
        $this->assertEquals('Admin | Dashboard', $this->title());
        $welcomePage->assertWelcomeIs('Nikky Amresh');
    }

    public function testAdminLogout()
    {
        $this->openUrl('/admin');
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
    }

    public function testTeacherLogin()
    {
        $this->openUrl('/teacher');
        $this->assertEquals('Login', $this->title());
        $page = new AuthenticationPage($this);
        $page->isLogout();
        $welcomePage = $page->username('nikkyamresh8@gmail.com')
            ->password('test')
            ->submit();
        $this->assertEquals('Teacher | Dashboard', $this->title());
        $welcomePage->assertWelcomeIs('Nikky Amresh');
    }

    public function testTeacherLogout()
    {
        $this->openUrl('/teacher');
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
    }
}
