<?php

namespace Tests\Unit\Integration;

use PHPUnit\Framework\TestCase;

use App\Helpers\Constants;

class StackTest extends TestCase
{
    public function testPushAndPop()
    {
        echo Constants::REQUEST_METHOD_POST;
        $stack = array();
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack) - 1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }
}
