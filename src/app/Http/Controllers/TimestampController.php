<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Timestamp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TimestampController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('index', compact('user'));
    }

    public function workin(Request $request)
    {
        $user = Auth::user();
        $oldDatetime = Timestamp::where('user_id', $user->id)->latest('created_at')->first();
        if ($oldDatetime && $oldDatetime->workIn)
        {
            $timestamp = now()->format('Y-m-d');
            $createdDate = $oldDatetime->created_at->format('Y-m-d');

            if ($timestamp == $createdDate)
            {
                return redirect()->back()->with('flash_message', 'すでに出勤済みです');
            }
        }
        $time = Timestamp::create([
            'user_id' => $user->id,
            'workIn' => Carbon::now(),
        ]);
        return redirect('/')->with('flash_message', 'おはようございます！');
    }

    public function workout(Request $request)
    {
        $user = Auth::user();
        $oldDatetime = Timestamp::where('user_id', $user->id)->latest('created_at')->first();
        if ($oldDatetime && $oldDatetime->workIn)
        {
            $timestamp = now()->format('Y-m-d');
            $createdDate = $oldDatetime->created_at->format('Y-m-d');

            if ($timestamp == $createdDate && empty($oldDatetime->breakIn) && empty($oldDatetime->workOut))
            {
                $oldDatetime->workOut = Carbon::now();
                $oldDatetime->save();
                return redirect('/')->with('flash_message', 'お疲れさまでした！');
            }
            elseif (!empty($oldDatetime->breakIn))
            {
                return redirect()->back()->with('flash_message', '休憩中です');
            }
        }
        return redirect()->back()->with('flash_message', '出勤されていません');
    }

    public function breakin(Request $request)
    {
        $user = Auth::user();
        $oldDatetime = Timestamp::where('user_id', $user->id)->latest('created_at')->first();
        if ($oldDatetime && $oldDatetime->workIn)
        {
            $timestamp = now()->format('Y-m-d');
            $createdDate = $oldDatetime->created_at->format('Y-m-d');

            if ($timestamp == $createdDate && empty($oldDatetime->breakIn) && empty($oldDatetime->workOut))
            {
                $oldDatetime->breakIn = Carbon::now();
                $oldDatetime->save();
                return redirect('/')->with('flash_message', '休憩に入りました');
            }
            elseif (!empty($oldDatetime->breakIn))
            {
                return redirect()->back()->with('flash_message', '休憩中です');
            }
        }
        return redirect()->back()->with('flash_message', '出勤されていません');
    }
    public function breakout(Request $request)
    {
        $user = Auth::user();
        $oldDatetime = Timestamp::where('user_id', $user->id)->latest('created_at')->first();
        if ($oldDatetime && $oldDatetime->workIn)
        {
            $timestamp = now()->format('Y-m-d');
            $createdDate = $oldDatetime->created_at->format('Y-m-d');
            if ($timestamp == $createdDate && !empty($oldDatetime->breakIn) && empty($oldDatetime->workOut))
            {
                if (empty($oldDatetime->breakTime))
                {
                    $breakOut = Carbon::now();
                    $breakIn = Carbon::createFromFormat('Y-m-d H:i:s', $oldDatetime->breakIn);
                    $diffInSeconds = $breakIn->diffInSeconds($breakOut);
                    $oldDatetime->breakTime = $diffInSeconds;
                    $oldDatetime->breakIn = null;
                    $oldDatetime->save();
                    return redirect('/')->with('flash_message', '休憩終わりました');
                }
                else
                {
                    $breakOut = Carbon::now();
                    $breakIn = Carbon::createFromFormat('Y-m-d H:i:s', $oldDatetime->breakIn);
                    $diffInSeconds = $breakIn->diffInSeconds($breakOut);
                    $oldBreakTimeSeconds = Carbon::parse($oldDatetime->breakTime)->hour * 3600 +
                        Carbon::parse($oldDatetime->breakTime)->minute * 60 +
                        Carbon::parse($oldDatetime->breakTime)->second;
                    $newBreakTimeSeconds = $oldBreakTimeSeconds + $diffInSeconds;
                    $oldDatetime->breakTime = gmdate('H:i:s', $newBreakTimeSeconds);
                    $oldDatetime->breakIn = null;
                    $oldDatetime->save();
                    return redirect('/')->with('flash_message', '休憩終わりました');
                }
            }
            elseif (empty($oldDatetime->breakIn))
            {
                return redirect()->back()->with('flash_message', '休憩開始していません');
            }
        }
        return redirect()->back()->with('flash_message', '出勤されていません');
    }

    public function attendance()
    {
        $user = Auth::user();
        $times = Timestamp::with('user')->paginate(5);
        $users = User::all();

        $groups = [];

        foreach ($times as $time)
        {

            $createdAt = Carbon::parse($time->created_at)->format('Y-m-d');
            if (!isset($groups[$createdAt]))
            {
                $groups[$createdAt] = [];
            }

            $time->workIn = Carbon::parse($time->workIn)->format('H:i:s');
            $time->workOut = Carbon::parse($time->workOut)->format('H:i:s');
            $time->breakTime = Carbon::parse($time->breakTime)->format('H:i');
            $workIn = Carbon::parse($time->workIn);
            $workOut = Carbon::parse($time->workOut);
            $workingHours = $workOut->diff($workIn)->format('%H:%I:%S');
            $time->workingHours = $workingHours;
            $fromTimestamp = strtotime($workingHours);
            $toTimestamp = strtotime($time->breakTime);
            $diff = $fromTimestamp - $toTimestamp;
            $workingtime = gmdate("H:i:s", $diff);
            // var_dump($workingtime);
            $time->workingtime = $workingtime;

            $groups[$createdAt][] = $time;
        }
        // $workIn = Carbon::parse($time->workIn);
        // $workOut = Carbon::parse($time->workOut);
        // $workingHours = $workOut->diff($workIn)->format('%H:%I:%S');
        // $time->workingHours = $workingHours;
        // $fromTimestamp = strtotime($workingHours);
        // $toTimestamp = strtotime($time->breakTime);
        // $diff = $fromTimestamp - $toTimestamp;
        // $workingtime = gmdate("H:i:s", $diff);
        // var_dump($workingtime);
        // $times->created_at = Carbon::parse($times->created_at)->format('Y-m-d');
        // $groups = $time->groupBy('created_at');
        // $groups->toArray();
        return view('attendance', compact('times', 'users', 'groups'));
    }
}
