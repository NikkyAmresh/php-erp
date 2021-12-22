<?php
namespace Tests\Unit\Selenium;

class Page
{
    public function __construct($page)
    {
        $this->page = $page;
    }

    public function isLogout()
    {
        return $this->page->assertMatchesRegularExpression("/Sign in as/", $this->page->byCssSelector('body > div > div > div > div > div h2')->text());
    }
}
class WelcomePage extends Page
{
    public function __construct($page)
    {
        parent::__construct($page);
    }

    public function assertWelcomeIs($text)
    {
        $this->page->assertMatchesRegularExpression("/$text/", $this->page->byCssSelector('body > nav')->text());
    }

    public function logout()
    {
        $logoutElement = $this->page->byCssSelector('body > nav > div.flex.items-center.justify-end.p-6.gap-5 > div > a');
        $logoutElement->click();
    }
}

class AuthenticationPage extends Page
{
    public function __construct($page)
    {
        $this->usernameInput = $page->byName('email');
        $this->passwordInput = $page->byName('password');
        parent::__construct($page);
    }

    public function username($value)
    {
        $this->usernameInput->value($value);
        return $this;
    }

    public function password($value)
    {
        $this->passwordInput->value($value);
        return $this;
    }

    public function submit()
    {
        $this->page->clickOnElement('submitButton');
        return new WelcomePage($this->page);
    }
}
