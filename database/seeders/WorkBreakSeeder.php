<?php

namespace Database\Seeders;

use App\Models\WorkBreak;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WorkBreakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkBreak::firstOrCreate([
            'since' => new Carbon('12:00'),
            'until' => new Carbon('12:45'),
        ]);
    }
}
