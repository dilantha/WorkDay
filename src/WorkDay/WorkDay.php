<?php

namespace WorkDay;

use Carbon\Carbon;

class WorkDay {

	public $now;
	public $timeZone;

	public function __construct($timeZone)
	{
		$this->timeZone = $timeZone;
		$this->now = Carbon::now($timeZone);
	}

	/**
	 * Calculate next due working date from a given date
	 * @param  DateTime $fromDate From date
	 * @param  int $delayInMinutes Delay in minutes
	 * @return DateTime Next working due date
	 */
	public function due($fromDate, $delayInMinutes)
	{
		$fromDate->addMinutes($delayInMinutes);
		$eod = $this->endOfDay($fromDate);
		// Sat
		if ($fromDate->gt($eod) and $fromDate->dayOfWeek == 6)
		{
			$nextDayMins = $fromDate->diffInMinutes($eod);
			$fromDate->addDays(2);
			$fromDate->hour = 8;
			$fromDate->minute = 30;
			$fromDate->second = 0;
			$fromDate->addMinutes($nextDayMins);
		}
		return $fromDate;
	}

	/**
	 * Get the end of day for a given date.
	 * @param  DateTime $date The input date
	 * @return DateTime End of day
	 */
	public function endOfDay($date)
	{
		$endOfDay = null;
		// Mon to Fri end of day 5pm
		if ($date->dayOfWeek > 0 and $date->dayOfWeek < 6)
		{
			$endOfDay = Carbon::create($date->year, $date->month, $date->day, 17, 0, 0, $this->timeZone);
		}
		// Saturday end of day 1pm
		else if ($date->dayOfWeek === 6)
		{
			$endOfDay = Carbon::create($date->year, $date->month, $date->day, 13, 0, 0, $this->timeZone);
		}
		return $endOfDay;
	}

}
