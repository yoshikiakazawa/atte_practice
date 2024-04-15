<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timestamp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'work_in',
        'Work_out',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function breakTime()
    {
        return $this->hasMany(BreakTime::class);
    }
}
