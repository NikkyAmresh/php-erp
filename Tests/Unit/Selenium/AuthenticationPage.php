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