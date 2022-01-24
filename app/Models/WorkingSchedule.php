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
}
