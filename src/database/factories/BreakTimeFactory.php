<?php

namespace Database\Factories;

use App\Models\BreakTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class BreakTimeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BreakTime::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $timestampId = 1;

        // 任意の日付を順番に割り当てる
        static $currentDate = '2024-04-18';

        // 休憩開始時間と終了時間
        $breakIn = '12:00:00';
        $breakOut = '13:00:00';

        // データ生成
        $data = [
            'timestamp_id' => $timestampId,
            'break_in' => $breakIn,
            'break_out' => $breakOut,
            'created_at' => $currentDate,
        ];

        $timestampId++;

        // 日付を10行ごとに1日ずつ増やす
        if ($timestampId % 10 === 1)
        {
            $currentDate = date('Y-m-d', strtotime($currentDate . ' + 1 day'));
        }

        return $data;
    }
}
