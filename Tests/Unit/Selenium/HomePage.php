<?php

namespace Tests\Unit\Selenium;

use App\Helpers\Admin;
use Core\Container;
use Tests\Unit\Selenium\SeleniumTest;

class HomePage extends SeleniumTest
{
    protected static $container;
    protected static $userID;
    protected static $student;
    protected static $admin;
    protected static $teacher;

    public function testCreateStudent()
    {
        $this->skip();
        self::$container = new Container();
        $studentHelper = self::$container->get(Student::class);
        self::$student = [
            'name' => 'Test Student',
            'mobile' => '9988788982',
            'email' => 'email@student.com',
            'password' => '123456',
            'course' => 4,
            'batch' => 3,
            'class' => 9,
            'rollNum' => 1999283912,
        ];
        self::$userID = $studentHelper->create(self::$student);
        $user = $studentHelper->get(self::$userID);
        $this->assertEquals($user['name'], self::$student['name']);
        $this->assertEquals($user['mobile'], self::$student['mobile']);
        $this->assertEquals($user['email'], self::$student['email']);
    }

    public function testStudentLogin()
    {
        $this->skip();
        $this->openUrl('/');
        $this->assertEquals('Login', $this->title());
        $page = new AuthenticationPage($this);
        $page->isLogout();
        $welcomePage = $page->username(self::$student['email'])
            ->password(self::$student['password'])
            ->submit();
        $welcomePage->assertWelcomeIs(self::$student['name']);
    }

    public function testStudentLogout()
    {
        $this->skip();
        $this->openUrl('/');
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
    }

    public function testStudentDelete()
    {
        $this->skip();
        $studentHelper = self::$container->get(Student::class);
        $studentHelper->delete(self::$userID);
        $user = $studentHelper->get(self::$userID);
        $this->assertEquals($user, null);
    }

    public function testAdminCreate()
    {
        self::$container = new Container();
        $adminHelper = self::$container->get(Admin::class);
        self::$admin = [
            'name' => 'Test Admin',
            'mobile' => '9988788982',
            'email' => 'email@admin.com',
            'password' => '123456',
        ];
        self::$userID = $adminHelper->create(self::$admin);
        $user = $adminHelper->get(self::$userID);

        $this->assertEquals($user['name'], self::$admin['name']);
        $this->assertEquals($user['mobile'], self::$admin['mobile']);
        $this->assertEquals($user['email'], self::$admin['email']);
    }

    public function testAdminLogin()
    {
        $this->openUrl('/admin');
        $this->assertEquals('Login', $this->title());
        $page = new AuthenticationPage($this);
        $page->isLogout();
        $welcomePage = $page->username(self::$admin['email'])
            ->password(self::$admin['password'])
            ->submit();
        $this->assertEquals('Admin | Dashboard', $this->title());
        $welcomePage->assertWelcomeIs(self::$admin['name']);
    }
    public function testAdminProfile()
    {
        $this->openUrl('/admin/profile');
        $this->assertEquals('Admin | Profile', $this->title());
    }
    public function testAdminLogout()
    {
        $this->openUrl('/admin');
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
    }

    public function testAdminDelete()
    {
        $adminHelper = self::$container->get(Admin::class);
        $adminHelper->delete(self::$userID);
        $user = $adminHelper->get(self::$userID);
        $this->assertEquals($user, null);
    }

    public function testTeacherCreate()
    {
        $this->skip();
        $teacherHelper = self::$container->get(Teacher::class);
        self::$teacher = [
            'name' => 'Test Teacher',
            'mobile' => '9988788982',
            'email' => 'email@teacher.com',
            'password' => '123456',
            'department' => 1,
        ];
        self::$userID = $teacherHelper->create(self::$teacher);
        $user = $teacherHelper->get(self::$userID);
        $this->assertEquals($user['name'], self::$teacher['name']);
        $this->assertEquals($user['mobile'], self::$teacher['mobile']);
        $this->assertEquals($user['email'], self::$teacher['email']);
    }

    public function testTeacherLogin()
    {
        $this->skip();
        $this->openUrl('/teacher');
        $this->assertEquals('Login', $this->title());
        $page = new AuthenticationPage($this);
        $page->isLogout();
        $welcomePage = $page->username(self::$teacher['email'])
            ->password(self::$teacher['password'])
            ->submit();
        $this->assertEquals('Teacher | Dashboard', $this->title());
        $welcomePage->assertWelcomeIs(self::$teacher['name']);
    }

    public function testTeacherLogout()
    {
        $this->skip();
        $this->openUrl('/teacher');
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
    }

    public function testTeacherDelete()
    {
        $this->skip();
        $teacherHelper = self::$container->get(Teacher::class);
        $teacherHelper->delete(self::$userID);
        $user = $teacherHelper->get(self::$userID);
        $this->assertEquals($user, null);
    }
}
