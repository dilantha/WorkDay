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

	public function due($fromDate, $delayInMinutes)
	{
		$fromDate->addMinutes($delayInMinutes);
		$eod = $this->endOfDay($fromDate);
		if ($fromDate->gt($eod))
		{
			$diff = $this->print_saved->diffInMinutes($eod);
			$nextDayMins = $delay - $diff;
			$due = Carbon::tomorrow()->addHours(8)->addMinutes(30);
			$due->addMinutes($nextDayMins);
			return $due;
		}
		else 
		{
			return $fromDate;
		}
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
