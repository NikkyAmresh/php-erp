<?php

namespace Tests\Unit\Selenium;

use Tests\Unit\Selenium\SeleniumTest;
use App\Helpers\Admin;
use App\Helpers\Teacher;
use App\Helpers\Student;
use Core\Container;

class HomePage extends SeleniumTest
{
    protected static $container;
    protected static $userID;

    public function testStudentLogin()
    {
        self::$container = new Container();

        $this->openUrl('/');
        $studentHelper = self::$container->get(Student::class);
        $student= [
            'name'=>'Test Student',
            'mobile'=>'9988788982',
            'email'=>'email@student.com',
            'password'=>'123456',
            'course' => 4,
            'batch' => 3,
            'class' => 9,
            'rollNum' => 1999283912
        ];
        self::$userID = $studentHelper->create($student);
        $this->assertEquals('Login', $this->title());
        $page = new AuthenticationPage($this);
        $page->isLogout();
        $welcomePage = $page->username($student['email'])
            ->password($student['password'])
            ->submit();
        $welcomePage->assertWelcomeIs($student['name']);
    }

    public function testStudentLogout()
    {
        $studentHelper = self::$container->get(Student::class);
        $this->openUrl('/');
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
        $studentHelper->delete(self::$userID);   
    }

    public function testAdminLogin()
    {
        $adminHelper = self::$container->get(Admin::class);
        $admin= [
            'name'=>'Test Admin',
            'mobile'=>'9988788982',
            'email'=>'email@admin.com',
            'password'=>'123456'
        ];
        self::$userID = $adminHelper->create($admin);
        $this->openUrl('/admin');
        $this->assertEquals('Login', $this->title());
        $page = new AuthenticationPage($this);
        $page->isLogout();
        $welcomePage = $page->username($admin['email'])
            ->password($admin['password'])
            ->submit();
        $this->assertEquals('Admin | Dashboard', $this->title());
        $welcomePage->assertWelcomeIs($admin['name']);
    }

    public function testAdminLogout()
    {
        $adminHelper = self::$container->get(Admin::class);
        $this->openUrl('/admin');
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
        $adminHelper->delete(self::$userID);   
    }

    public function testTeacherLogin()
    {
        $teacherHelper = self::$container->get(Teacher::class);
        $teacher= [
            'name'=>'Test Teacher',
            'mobile'=>'9988788982',
            'email'=>'email@teacher.com',
            'password'=>'123456',
            'departmentID' => 1
        ];
        $this->openUrl('/teacher');
        $this->assertEquals('Login', $this->title());
        self::$userID = $teacherHelper->create($teacher);
        $page = new AuthenticationPage($this);
        $page->isLogout();
        $welcomePage = $page->username($teacher['email'])
            ->password($teacher['password'])
            ->submit();
        $this->assertEquals('Teacher | Dashboard', $this->title());
        $welcomePage->assertWelcomeIs($teacher['name']);
    }

    public function testTeacherLogout()
    {
        $teacherHelper = self::$container->get(Teacher::class);
        $this->openUrl('/teacher');
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
        $teacherHelper->delete(self::$userID);   
    }
}
