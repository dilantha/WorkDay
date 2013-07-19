<?php

use Carbon\Carbon;
use WorkDay\WorkDay;

class WorkDayTest extends \PHPUnit_Framework_TestCase
{

	protected $nextWorkingDate;

    protected function setUp()
    {
        $this->nextWorkingDate = new WorkDay('Asia/Colombo');
    }

    public function testNow()
    {
    	$expected = Carbon::now('Asia/Colombo');
    	$this->assertEquals($expected, $this->nextWorkingDate->now);
    }

    public function testEndOfDay()
    {
    	$saturday = Carbon::createFromDate(2013, 7, 20, 'Asia/Colombo');
    	$endOfDay = Carbon::create(2013, 7, 20, 13, 0, 0, 'Asia/Colombo');
    	$this->assertEquals($endOfDay, $this->nextWorkingDate->endOfDay($saturday));

    	$sunday = Carbon::createFromDate(2013, 7, 21, 'Asia/Colombo');
    	$this->assertNull($this->nextWorkingDate->endOfDay($sunday));

    	$monday = Carbon::createFromDate(2013, 7, 22, 'Asia/Colombo');
    	$endOfDay = Carbon::create(2013, 7, 22, 17, 0, 0, 'Asia/Colombo');
    	$this->assertEquals($endOfDay, $this->nextWorkingDate->endOfDay($monday));
    }
}