<?php

namespace Database\Factories;

use App\Models\Timestamp;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimestampFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Timestamp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // ユーザーIDを1から10の範囲で順番に割り当てる
        static $userId = 1;

        // 任意の日付を順番に割り当てる
        static $currentDate = '2024-04-18';

        // 作業開始時間と終了時間
        $workIn = '09:00:00'; // 9:00
        $workOut = '18:00:00'; // 18:00
        $breakTotal = '01:00:00'; // 1時間（HH:MM:SS形式）

        // データ生成
        $data = [
            'user_id' => $userId,
            'work_in' => $workIn,
            'work_out' => $workOut,
            'break_total' => $breakTotal,
            'created_at' => $currentDate,
        ];

        // ユーザーIDを更新
        if ($userId < 10)
        {
            $userId++;
        }
        else
        {
            $userId = 1;
            // 日付を次の日に更新
            $currentDate = date('Y-m-d', strtotime($currentDate . ' + 1 day'));
        }

        return $data;
    }
}
