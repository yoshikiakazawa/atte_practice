<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Timestamp;
use App\Models\BreakTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BreakTimeController extends Controller
{
    public function breakIn()
    {
        $user = Auth::user();
        $oldTimes = Timestamp::where('user_id', $user->id)->latest()->first();
        $oldBreaks = BreakTime::where('timestamp_id', $oldTimes->id)->latest()->first();
        $today = Carbon::today()->format('Y-m-d');
        if ($oldTimes && $oldTimes->created_at->format('Y-m-d') == $today)
        {
            if (empty($oldTimes->work_out))
            {
                if ($oldBreaks && $oldBreaks->created_at->format('Y-m-d') == $today)
                {
                    if (!empty($oldBreaks->break_out))
                    {
                        BreakTime::create([
                            'timestamp_id' => $oldTimes->id,
                            'break_in' => Carbon::now(),
                        ]);
                        return redirect('/')->with('flash_message', '休憩に入りました');
                    }
                    return redirect('/')->with('flash_message', '休憩中です');
                }
                BreakTime::create([
                    'timestamp_id' => $oldTimes->id,
                    'break_in' => Carbon::now(),
                ]);
                return redirect()->back()->with('flash_message', '休憩開始しました');
            }
            return redirect()->back()->with('flash_message', '退勤されています');
        }
        return redirect()->back()->with('flash_message', '出勤されていません');
    }

    public function breakOut()
    {
        $user = Auth::user();
        $oldTimes = Timestamp::where('user_id', $user->id)->latest()->first();
        $oldBreaks = BreakTime::where('timestamp_id', $oldTimes->id)->latest()->first();
        $today = Carbon::now()->format('Y-m-d');
        if ($oldTimes && $oldTimes->created_at->format('Y-m-d') == $today)
        {
            if (empty($oldTimes->work_out))
            {
                if ($oldBreaks && $oldBreaks->created_at->format('Y-m-d') == $today)
                {
                    if (empty($oldBreaks->break_out) && empty($oldTimes->break_total))
                    {
                        $currentTime = Carbon::now();
                        $oldBreaks->break_out = $currentTime;
                        $oldBreaks->break_out;
                        $oldBreaks->save();
                        $breakIn = Carbon::parse($oldBreaks->break_in);
                        $breakOut = Carbon::parse($oldBreaks->break_out);
                        $breakTime = $breakOut->diff($breakIn)->format('%H:%I:%S');
                        $oldTimes->break_total = $breakTime;
                        $oldTimes->save();
                        return redirect('/')->with('flash_message', '休憩終了しました');
                    }
                    elseif (empty($oldBreaks->break_out) && !empty($oldTimes->break_total))
                    {
                        $currentTime = Carbon::now();
                        $oldBreaks->break_out = $currentTime;
                        $oldBreaks->break_out;
                        $oldBreaks->save();
                        $breakIn = Carbon::parse($oldBreaks->break_in);
                        $breakOut = Carbon::parse($oldBreaks->break_out);
                        $diffInSeconds = $breakIn->diffInSeconds($breakOut);
                        $oldBreakTimeSeconds = Carbon::parse($oldTimes->break_total)->hour * 3600 +
                            Carbon::parse($oldTimes->break_total)->minute * 60 +
                            Carbon::parse($oldTimes->break_total)->second;
                        $newBreakTimeSeconds = $oldBreakTimeSeconds + $diffInSeconds;
                        $oldTimes->break_total = gmdate('H:i:s', $newBreakTimeSeconds);
                        $oldTimes->save();
                        return redirect('/')->with('flash_message', '休憩終了しました');
                    }
                    return redirect('/')->with('flash_message', '休憩開始されていません');
                }
                return redirect()->back()->with('flash_message', '休憩開始されていません');
            }
            return redirect()->back()->with('flash_message', '退勤されています');
        }
        return redirect()->back()->with('flash_message', '出勤されていません');
    }
}
