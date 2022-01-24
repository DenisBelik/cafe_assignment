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
}
