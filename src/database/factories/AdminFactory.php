<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    protected $model = Admin::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'userid' => 'admin001',
            'password' => Hash::make('12345678'),
            'note' => 'テスト用管理ユーザー',
            'created_at' => now(),
        ];
    }
}
