<?php

namespace Database\Seeders;

use App\Models\BreakTime;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Timestamp;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Timestamp::factory()->count(300)->create();
        BreakTime::factory()->count(300)->create();
    }
}
