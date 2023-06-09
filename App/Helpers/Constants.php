<?php
namespace App\Helpers;

class Constants
{
    const REQUEST_METHOD_POST = "POST";
    const REQUEST_METHOD_GET = "GET";
    const LOGGED_IN_USER_ID = "LOGGED_IN_USER_ID";
    const LOGGED_IN_USER_NAME = "LOGGED_IN_USER_NAME";
    const LOGGED_IN_USER_EMAIL = "LOGGED_IN_USER_EMAIL";
    const MESSAGE_TYPE =
    ['INFO' => 'INFO_MESSAGE', 'ERROR' => 'ERROR_MESSAGE', 'SUCCESS' => 'SUCCESS_MESSAGE', 'WARNING' => 'WARNING_MESSAGE'];
    const INFO = "INFO";
    const ERROR = "ERROR";
    const SUCCESS = "SUCCESS";
    const WARNING = "WARNING";

    const LOGGED_IN_ADMIN_ID = "LOGGED_IN_ADMIN_ID";
    const LOGGED_IN_ADMIN_USER_ID = "LOGGED_IN_ADMIN_USER_ID";
    const LOGGED_IN_ADMIN_NAME = "LOGGED_IN_ADMIN_NAME";
    const LOGGED_IN_ADMIN_EMAIL = "LOGGED_IN_ADMIN_EMAIL";

    const LOGGED_IN_STUDENT_ID = "LOGGED_IN_STUDENT_ID";
    const LOGGED_IN_STUDENT_USER_ID = "LOGGED_IN_STUDENT_USER_ID";
    const LOGGED_IN_STUDENT_NAME = "LOGGED_IN_STUDENT_NAME";
    const LOGGED_IN_STUDENT_EMAIL = "LOGGED_IN_STUDENT_EMAIL";

    const LOGGED_IN_TEACHER_ID = "LOGGED_IN_TEACHER_ID";
    const LOGGED_IN_TEACHER_USER_ID = "LOGGED_IN_TEACHER_USER_ID";
    const LOGGED_IN_TEACHER_NAME = "LOGGED_IN_TEACHER_NAME";
    const LOGGED_IN_TEACHER_EMAIL = "LOGGED_IN_TEACHER_EMAIL";

    const HISTORY_URL = "HISTORY_URL";
}
