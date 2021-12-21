<?php
namespace Unit\Selenium;

class WelcomePage
{
    public function __construct($test)
    {
        $this->header = $test->byCssSelector('body > nav');
        $this->test = $test;
    }

    public function assertWelcomeIs($text)
    {
        $this->test->assertMatchesRegularExpression("/$text/", $this->header->text());
        $this->logout();
    }
    public function logout()
    {
        $logoutElement = $this->test->byCssSelector('body > nav > div.flex.items-center.justify-end.p-6.gap-5 > div > a');
        sleep(5);
        $logoutElement->click();
        $this->test->assertMatchesRegularExpression("/Sign in as Student/", $this->test->byCssSelector('body > div > div > div > div > div h2')->text());
        sleep(2);
        return $this;
    }
}

class AuthenticationPage
{
    public function __construct($test)
    {
        $this->usernameInput = $test->byName('email');
        $this->passwordInput = $test->byName('password');
        $this->test = $test;
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
        $this->test->clickOnElement('submitButton');
        return new WelcomePage($this->test);
    }
}
