<?php

namespace App\System;

class Time
{

	public static function smartFormat(int $unix) : string {

		if(round((time() - $unix) /60) < 1440)
			$timeStr = 'Prije '. Self::inBetween($unix);
		else
			$timeStr = date("d.m.Y", $unix) .' u '. date("H:i", $unix);

		return $timeStr;
	}

	public static function dateDiff(int $date_1, int $date_2, string $differenceFormat = '%a' ) : string {
	    
		$datetime1 = new \DateTime(date("Y-m-d H:i", $date_1));
		$datetime2 = new \DateTime(date("Y-m-d H:i", $date_2));

	    return $datetime1->diff($datetime2)->format($differenceFormat);
	    
	}

	public static function inBetween(int $day, $day2 = false) : string {

		if(!$day2) $day2 = time();
		$minutes = round(($day2 - $day) /60);
		
		if($minutes < 60) {

			if($minutes <= 1)
				$mintext = '1 minute';
			else
				$mintext = $minutes .' minuta';

		} else if($minutes >= 60 && $minutes < 1440) { // sati

			$mathvar = $minutes / 60;
			
			$minnumber = round($mathvar, null, PHP_ROUND_HALF_DOWN);
			
			if($minnumber <= 3)
				$mintext = '1 sata';
			else
				$mintext = $minnumber .' sati';

		} else if($minutes >= 1440) { // dani

			$mathvar = $minutes / 1440;
			
			$minnumber = round($mathvar, null, PHP_ROUND_HALF_DOWN);
			
			$mintext = $minnumber.' dana';

		}
		
		return $mintext;
	}
}