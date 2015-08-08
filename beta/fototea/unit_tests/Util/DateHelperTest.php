<?php

namespace unit_tests\Util;
use Fototea\Util\DateHelper;

class DateHelperTest extends \PHPUnit_Framework_TestCase
{
    //
    public function testIsPastDate() {
        $this->assertTrue(DateHelper::isPastDate('1990-01-18 00:00:00')); //past date
        $this->assertTrue(DateHelper::isPastDate('2012-06-18 00:00:00')); //past date
        $this->assertTrue(DateHelper::isPastDate('2012-06-18 25:15:00')); //past date
        $this->assertTrue(!DateHelper::isPastDate(date('Y-m-d H:i:s',time()))); //same date
        $this->assertTrue(!DateHelper::isPastDate('2080-06-18 00:00:00')); //future date
    }
}