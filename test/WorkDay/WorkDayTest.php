<?php

use Carbon\Carbon;
use WorkDay\WorkDay;

class WorkDayTest extends \PHPUnit_Framework_TestCase
{

	protected $workDay;

    protected function setUp()
    {
        $this->workDay = new WorkDay('Asia/Colombo');
    }

    public function testEndOfDay()
    {
    	$saturday = Carbon::createFromDate(2013, 7, 20, 'Asia/Colombo');
    	$endOfDay = Carbon::create(2013, 7, 20, 13, 0, 0, 'Asia/Colombo');
    	$this->assertEquals($endOfDay, $this->workDay->endOfDay($saturday));

    	$sunday = Carbon::createFromDate(2013, 7, 21, 'Asia/Colombo');
    	$this->assertNull($this->workDay->endOfDay($sunday));

    	$monday = Carbon::createFromDate(2013, 7, 22, 'Asia/Colombo');
    	$endOfDay = Carbon::create(2013, 7, 22, 17, 0, 0, 'Asia/Colombo');
    	$this->assertEquals($endOfDay, $this->workDay->endOfDay($monday));
    }

    public function testDueSaturday()
    {
        // Sat 10am
        $saturdayTen = Carbon::create(2013, 7, 20, 10, 0, 0, 'Asia/Colombo');
        $delayInMinutes = 10;
        // Due Sat 10:10am
        $due = $this->workDay->due($saturdayTen, $delayInMinutes);
        $expected = Carbon::create(2013, 7, 20, 10, 10, 0, 'Asia/Colombo');
        $this->assertEquals($expected, $due);
    }

    public function testSatDueMonday()
    {
        // Sat 1pm
        $fromDate = Carbon::create(2013, 7, 20, 13, 0, 0, 'Asia/Colombo');
        $delayInMinutes = 10;
        // Due Mon 8:40am
        $dueDate = $this->workDay->due($fromDate, $delayInMinutes);
        $expected = Carbon::create(2013, 7, 22, 8, 40, 0, 'Asia/Colombo');
        $this->assertEquals($expected, $dueDate);
    }

    public function testDueMonday()
    {
        // Mon 1pm
        $fromDate = Carbon::create(2013, 7, 22, 13, 0, 0, 'Asia/Colombo');
        $delayInMinutes = 10;
        // Due Mon 1:10pm
        $dueDate = $this->workDay->due($fromDate, $delayInMinutes);
        $expected = Carbon::create(2013, 7, 22, 13, 10, 0, 'Asia/Colombo');
        $this->assertEquals($expected, $dueDate);
    }

    public function testMondayDueTuesday()
    {
        // Mon 5pm
        $fromDate = Carbon::create(2013, 7, 22, 17, 0, 0, 'Asia/Colombo');
        $delayInMinutes = 10;
        // Due Tue 8:40pm
        $dueDate = $this->workDay->due($fromDate, $delayInMinutes);
        $expected = Carbon::create(2013, 7, 23, 8, 40, 0, 'Asia/Colombo');
        $this->assertEquals($expected, $dueDate);
    }
}