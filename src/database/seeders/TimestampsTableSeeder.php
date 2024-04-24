<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimestampsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '2',
            'work_in' => '09:30:00',
            'work_out' => '17:30:00',
            'break_total' => '01:00:00',
            'created_at' => '2024-01-10 09:00:00',
        ];
        DB::table('timestamps')->insert($param);
        $param = [
            'user_id' => '2',
            'work_in' => '09:30:00',
            'work_out' => '17:00:00',
            'break_total' => '01:00:00',
            'created_at' => '2024-01-09 09:00:00',
        ];
        DB::table('timestamps')->insert($param);
        $param = [
            'user_id' => '2',
            'work_in' => '09:30:00',
            'work_out' => '17:30:00',
            'break_total' => '01:00:00',
            'created_at' => '2024-01-13 09:00:00',
        ];
        DB::table('timestamps')->insert($param);
        $param = [
            'user_id' => '2',
            'work_in' => '09:30:00',
            'work_out' => '17:00:00',
            'break_total' => '01:00:00',
            'created_at' => '2024-01-29 09:00:00',
        ];
        DB::table('timestamps')->insert($param);
        $param = [
            'user_id' => '2',
            'work_in' => '09:30:00',
            'work_out' => '17:30:00',
            'break_total' => '01:00:00',
            'created_at' => '2024-01-03 09:00:00',
        ];
        DB::table('timestamps')->insert($param);
        $param = [
            'user_id' => '2',
            'work_in' => '09:30:00',
            'work_out' => '17:00:00',
            'break_total' => '01:00:00',
            'created_at' => '2024-01-02 09:00:00',
        ];
        DB::table('timestamps')->insert($param);
        $param = [
            'user_id' => '2',
            'work_in' => '09:00:00',
            'work_out' => '16:30:00',
            'break_total' => '01:00:00',
            'created_at' => '2024-01-04 09:00:00',
        ];
        DB::table('timestamps')->insert($param);
        $param = [
            'user_id' => '2',
            'work_in' => '09:00:00',
            'work_out' => '18:00:00',
            'break_total' => '01:00:00',
            'created_at' => '2024-01-05 09:00:00',
        ];
        DB::table('timestamps')->insert($param);
    }
}
