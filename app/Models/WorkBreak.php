<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkBreak extends Model
{
    /**
     * Model's table.
     */
    protected $table = 'work_breaks';

    /**
     * Disable timestamps.
     */
    public $timestamps = false;

    /**
     * Fields that can be changed.
     */
    protected $fillable = [
        'since',
        'until',
    ];

    /**
     * Finds last break in `$date`.
     * 
     * @param Carbon $date
     * 
     * @return WorkBreak|null
     */
    public static function lastBreakByDate(Carbon $date) {
        // Get all breaks that yet to come.
        $breaks = self::where([
            ['until', '>=', $date->toTimeString()],
        ])->get();

        // If first break some time after `$date`, return the given date.
        if (!count($breaks) || $breaks[0]->since > $date->toTimeString()) {
            return null;
        }

        // Find the nearest gap.
        for ($i = 0; $i < count($breaks) - 1; ++$i) {
            if ($breaks[$i]->until < $breaks[$i + 1]->since) {
                break;
            }
        }

        return $breaks[$i];
    }
}
