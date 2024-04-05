<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timestamp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workIn',
        'WorkOut',
        'breakIn',
        'breakTime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'created_at' => 'date:Y-m-d',    // ←日付の形式を指定
        'updated_at' => 'date:Y-m-d',    // ←日付の形式を指定
    ];
}
