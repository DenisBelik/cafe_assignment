<?php

namespace Database\Seeders;

use App\Models\WorkingSchedule;
use Illuminate\Database\Seeder;

class WorkingScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkingSchedule::initWeekendSchedule(WorkingSchedule::Sunday);
        WorkingSchedule::initDefaultSchedule(WorkingSchedule::Monday);
        WorkingSchedule::initWeekendSchedule(WorkingSchedule::Tuesday);
        WorkingSchedule::initDefaultSchedule(WorkingSchedule::Wednesday);
        WorkingSchedule::initWeekendSchedule(WorkingSchedule::Thursday);
        WorkingSchedule::initDefaultSchedule(WorkingSchedule::Friday);
        WorkingSchedule::initWeekendSchedule(WorkingSchedule::Saturday);
    }
}
