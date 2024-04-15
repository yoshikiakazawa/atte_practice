<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'timestamp_id',
        'break_in',
        'break_out',
    ];

    public function timestamp()
    {
        return $this->belongsTo(Timestamp::class);
    }
}
