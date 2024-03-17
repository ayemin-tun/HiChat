<?php

namespace App\Services;

use Carbon\Carbon;

class DateFormatter
{
    public static function format($date)
    {
        $carbonDate = Carbon::parse($date);
        $time = $carbonDate->format('h:i A');

        if ($carbonDate->isToday()) {
            return $time;
        } elseif ($carbonDate->isYesterday()) {
            return 'Yesterday,'.$time;
        } else {
            return $carbonDate->format('F j').', '.$time;
        }
    }
}
