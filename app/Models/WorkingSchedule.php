<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingSchedule extends Model
{
    /**
     * Model's table.
     */
    protected $table = 'working_schedule';

    /**
     * Update primary key;
     */
    protected $primaryKey = 'week_day';

    /**
     * Disable timestamps.
     */
    public $timestamps = false;

    /**
     * Define a list of week days in order.
     */
    const Monday = 1;
    const Tuesday = 2;
    const Wednesday = 3;
    const Thursday = 4;
    const Friday = 5;
    const Saturday = 6;
    const Sunday = 7;

    /**
     * Create default working schedule for the given day.
     *
     * @return WorkingSchedule
     */
    public static function initDefaultSchedule(int $day) {
        return self::initSchedule($day, [
            'since' => new Carbon("08:00"),
            'until' => new Carbon("16:00"),
        ]);
    }

    /**
     * Create weekend working schedule for the given day.
     *
     * @return WorkingSchedule
     */
    public static function initWeekendSchedule(int $day) {
        return self::initSchedule($day, [
            'since' => null,
            'until' => null,
        ]);
    }

    /**
     * Create working schedule for the given day.
     *
     * @return WorkingSchedule
     */
    private static function initSchedule(int $day, array $schedule) {
        return WorkingSchedule::updateOrCreate([
            'week_day' => $day
        ], $schedule);
    }

    /**
     * Convert ISO week day index to internal index.
     * 
     * @param int $id
     * 
     * @return int
     */
    public static function convertToIndex(int $id) {
        return $id === 0 ? self::Sunday : $id;
    }

    /**
     * Calculates the closest date until the opening. If store is
     * open in `$date`, then the function returns it. This function
     * also handles wrapping and work breaks.
     * 
     * @param Carbon $date
     * 
     * @return Carbon|null
     */
    public static function untilOpened(Carbon $date) {
        $index = self::convertToIndex($date->dayOfWeek);

        // If we found when store is opened after `$date`.
        $break = WorkBreak::lastBreakByDate($date);
        $schedule = self::untilOpenedSinceDay($date, $index, $break);
        if ($schedule) {
            return $schedule;
        }
        
        // Else, search since the next Monday.
        $date->next('Monday');
        $date->startOfDay();
        $break = WorkBreak::lastBreakByDate($date);
        return self::untilOpenedSinceDay($date, WorkingSchedule::Monday, $break);
    }

    /**
     * Calculates the closest date until the opening since the given
     * week day.
     * 
     * @param Carbon $date
     * 
     * @return Carbon|null
     */
    private static function untilOpenedSinceDay(Carbon $date, int $index, ?WorkBreak $break) {
        $schedules = WorkingSchedule::where('week_day', '>=', $index)
            ->whereNotNull('since')
            ->get();

        for ($i = 0; $i < count($schedules); ++$i) {
            $schedule = $schedules[$i];
            $nextSchedule = $schedules[$i + 1] ?? null;

            if ($schedule->since) {
                $time = self::findFirstInSchedule($date, $schedule, $break);
            }

            if ($time) {
                return $time;
            } else if ($nextSchedule) {
                $date->addDay();

                if ($nextSchedule->since) {
                    $time = Carbon::parse($nextSchedule->since);
                    $date->setTime($time->hour, $time->minute, $time->second);
                    $break = WorkBreak::lastBreakByDate($date);
                }
            }
        }

        return null;
    }

    /**
     * Performs searching the closest opening in the given working day. If
     * it wasn't found, then the function returns null.
     * 
     * @param Carbon $date
     * @param WorkingSchedule $schedule
     * @param WorkBreak|null $break
     * 
     * @return Carbon|null
     */
    private static function findFirstInSchedule(Carbon $date, WorkingSchedule $schedule, ?WorkBreak $break) {
        $until = new Carbon($date);
        if ($break) {
            $time = Carbon::parse($break->until);
            $until->setTime($time->hour, $time->minute, $time->second);
        }

        if ($until->toTimeString() < $schedule->since) {
            $time = Carbon::parse($schedule->since);
            $until->setTime($time->hour, $time->minute, $time->second);
            $break = WorkBreak::lastBreakByDate(new Carbon($until));
            return self::findFirstInSchedule($until, $schedule, $break);
        }

        if ($schedule->until >= $until->toTimeString()) {
            return $until;
        }
        return null;
    }
}
