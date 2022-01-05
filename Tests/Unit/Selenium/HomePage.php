<?php

namespace Tests\Unit\Selenium;

use App\Helpers\Admin;
use App\Helpers\Student;
use App\Helpers\Teacher;
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
        $this->openUrl('/');
        $this->assertEquals('Login', $this->title());
        $page = new AuthenticationPage($this);
        $page->isLogout();
        $welcomePage = $page->username(self::$student['email'])
            ->password(self::$student['password'])
            ->submit();
        $welcomePage->assertWelcomeIs(self::$student['name']);
    }

    public function testStudentProfile()
    {
        $this->openUrl('/student');
        $this->byCssSelector('body > div > div.flex.flex-col.w-80.sm\:w-56.bg-white.rounded-r-3xl.overflow-hidden > ul > li:nth-child(2) > a > span.text-sm.font-medium')->click();
        $this->assertEquals('Student | Profile', $this->title());
        $studentName = $this->byCssSelector('body > div > div.container > div > div > div > div > div.bg-white.p-3.shadow-sm.rounded-sm > div.text-gray-700 > div > div:nth-child(1) > div:nth-child(2)')->text();
        $this->assertEquals(self::$student['name'], $studentName);
    }

    public function testStudentLogout()
    {
        $this->openUrl('/');
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
    }

    public function testStudentDelete()
    {
        $studentHelper = self::$container->get(Student::class);
        $studentHelper->delete(self::$userID);
        $user = $studentHelper->get(self::$userID);
        $this->assertEquals($user, null);
    }

    public function testAdminCreate()
    {
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
        $this->openUrl('/admin');
        $this->byCssSelector('ul > li:nth-child(2) > a')->click();
        $this->assertEquals('Admin | Profile', $this->title());
        $adminName = $this->byCssSelector('body > div > div.container > div > div > div > div > div > div.text-gray-700 > div > div:nth-child(1) > div:nth-child(2)')->text();
        $adminEmail = $this->byCssSelector('body > div > div.container > div > div > div > div > div > div.text-gray-700 > div > div:nth-child(3) > div:nth-child(2) > a')->text();
        $this->assertEquals(self::$admin['name'], $adminName);
        $this->assertEquals(self::$admin['email'], $adminEmail);
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

    public function testTeacherProfile()
    {
        $this->openUrl('/teacher');
        $this->byCssSelector('body > div > div.flex.flex-col.w-80.sm\:w-56.bg-white.rounded-r-3xl.overflow-hidden > ul > li:nth-child(2) > a')->click();
        $this->assertEquals('Teacher | Profile', $this->title());
        $teacherName = $this->byCssSelector('body > div > div.container > div > div > div > div > div.bg-white.p-3.shadow-sm.rounded-sm > div.text-gray-700 > div > div:nth-child(1) > div:nth-child(2)')->text();
        $teacherEmail = $this->byCssSelector('body > div > div.container > div > div > div > div > div.bg-white.p-3.shadow-sm.rounded-sm > div.text-gray-700 > div > div:nth-child(4) > div:nth-child(2) > a')->text();
        $this->assertEquals(self::$teacher['name'], $teacherName);
        $this->assertEquals(self::$teacher['email'], $teacherEmail);
    }

    public function testTeacherLogout()
    {
        $this->openUrl('/teacher');
        $page = new WelcomePage($this);
        $page->logout();
        $page->isLogout();
    }

    public function testTeacherDelete()
    {
        $teacherHelper = self::$container->get(Teacher::class);
        $teacherHelper->delete(self::$userID);
        $user = $teacherHelper->get(self::$userID);
        $this->assertEquals($user, null);
    }
}
