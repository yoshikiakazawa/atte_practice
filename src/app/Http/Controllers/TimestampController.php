<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Timestamp;
use App\Models\BreakTime;
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
    private function firstTime()
    {
        $user = Auth::user();
        $oldTimes = Timestamp::where('user_id', $user->id)->get();
        if (!$oldTimes)
        {
            return true;
        }
    }

    private function judgmentWorkIn()
    {
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');
        $oldTimeCreated = Timestamp::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->latest()
            ->first();
        if ($oldTimeCreated)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function judgmentOut()
    {
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');
        $oldTimeCreated = Timestamp::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->latest()
            ->first();
        if (!$oldTimeCreated)
        {
            return false;
        }
        if (empty($oldTimeCreated->work_out))
        {
            $oldBreakCreated = BreakTime::where('timestamp_id', $oldTimeCreated->id)
                ->whereDate('created_at', $today)
                ->latest()
                ->first();
            return (!$oldBreakCreated || !empty($oldBreakCreated->break_out));
        }
        else
        {
            return false;
        }
    }

    private function judgmentBreakOut()
    {
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');
        $oldTimes = Timestamp::where('user_id', $user->id)->latest()->first();
        if ($oldTimes && !empty($oldTimes->id))
        {
            $oldBreakCreated = BreakTime::where('timestamp_id', $oldTimes->id)
                ->whereDate('created_at', $today)
                ->latest()
                ->first();
            if ($oldBreakCreated && empty($oldBreakCreated->break_out))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    public function index()
    {
        $user = Auth::user();
        $judFirst = $this->firstTime();
        $judWorkIn = $this->judgmentWorkIn();
        $judOut = $this->judgmentOut();
        $judBreakOut = $this->judgmentBreakOut();
        return view('index', compact('user', 'judFirst', 'judWorkIn', 'judOut', 'judBreakOut'));
    }

    public function workIn()
    {
        $user = Auth::user();
        $oldTimes = Timestamp::where('user_id', $user->id)->latest()->first();
        if ($oldTimes)
        {
            $today = Carbon::today()->format('Y-m-d');
            $createdTimes = $oldTimes->created_at->format('Y-m-d');
            $oldBreaks = BreakTime::where('timestamp_id', $oldTimes->id)->latest()->first();

            if ($today == $createdTimes)
            {
                return redirect('/')->with('flash_message', '本日はすでに出勤済みです');
            }
            elseif (empty($oldTimes->work_out) && empty($oldBreaks->break_out))
            {
                $oldBreaks->break_out = $oldBreaks->break_in;
                $oldBreaks->break_out;
                $oldBreaks->save();
                $oldTimes->work_out = $oldBreaks->break_in;
                $oldTimes->work_out;
                $oldTimes->save();
                Timestamp::create([
                    'user_id' => $user->id,
                    'work_in' => Carbon::now(),
                ]);
                return redirect('/')->with('flash_message', 'おはようございます！前回の退勤と休憩終了打刻されていませんので修正お願いします');
            }
            elseif (empty($oldTimes->work_out))
            {
                $oldTimes->work_out = $oldTimes->work_in;
                $oldTimes->work_out;
                $oldTimes->save();
                Timestamp::create([
                    'user_id' => $user->id,
                    'work_in' => Carbon::now(),
                ]);
                return redirect('/')->with('flash_message', 'おはようございます！前回の退勤打刻されていませんので修正お願いします');
            }
        }
        Timestamp::create([
            'user_id' => $user->id,
            'work_in' => Carbon::now(),
        ]);
        return redirect('/')->with('flash_message', 'おはようございます！');
    }

    public function workOut()
    {
        $user = Auth::user();
        $oldTimes = Timestamp::where('user_id', $user->id)->latest()->first();
        $oldBreaks = BreakTime::where('timestamp_id', $oldTimes->id)->latest()->first();
        if ($oldTimes)
        {
            $today = Carbon::today()->format('Y-m-d');
            $createdTimes = $oldTimes->created_at->format('Y-m-d');
            if ($today == $createdTimes)
            {
                if (!empty($oldBreaks->break_out) && empty($oldTimes->work_out))
                {
                    $currentTime = Carbon::now();
                    $oldTimes->work_out = $currentTime;
                    $oldTimes->work_out;
                    $oldTimes->save();
                    return redirect('/')->with('flash_message', 'お疲れさまでした！');
                }
                elseif (empty($oldBreaks->break_out))
                {
                    return redirect()->back()->with('flash_message', '休憩中です');
                }
            }
        }
        return redirect()->back()->with('flash_message', '出勤されていません');
    }

    public function attendance(Request $request)
    {
        $users = User::all();
        if (empty($request->date))
        {
            $yesterday = Carbon::yesterday();
            $today = Carbon::today();
            $tomorrow = Carbon::tomorrow();
        }
        else
        {
            $today = new Carbon($request->date);
            $yesterday = (new Carbon($request->date))->subDay();
            $tomorrow = (new Carbon($request->date))->addDay();
        }
        $todayLists = Timestamp::whereDate('created_at', $today)->paginate(5)->withQueryString();
        foreach ($todayLists as $todayList)
        {
            $workIn = Carbon::parse($todayList->work_in);
            $workOut = Carbon::parse($todayList->work_out);
            $workingHours = $workOut->diff($workIn)->format('%H:%I:%S');
            $fromTimestamp = strtotime($workingHours);
            $toTimestamp = strtotime($todayList->break_total);
            $diff = $fromTimestamp - $toTimestamp;
            $workingTime = gmdate("H:i:s", $diff);
            $todayList->working_time = $workingTime;
        }
        return view('attendance', compact('todayLists', 'users', 'today', 'yesterday', 'tomorrow'));
    }

    public function admin()
    {
        $users = User::paginate(5);
        return view('admin', compact('users'));
    }

    public function user(User $id)
    {
        $users = User::all();
        $userDataLists = Timestamp::where('user_id', $id->id)->latest()->get();
        foreach ($userDataLists as $userDataList)
        {
            $workIn = Carbon::parse($userDataList->work_in);
            $workOut = Carbon::parse($userDataList->work_out);
            $workingHours = $workOut->diff($workIn)->format('%H:%I:%S');
            $fromTimestamp = strtotime($workingHours);
            $toTimestamp = strtotime($userDataList->break_total);
            $diff = $fromTimestamp - $toTimestamp;
            $workingTime = gmdate("H:i:s", $diff);
            $userDataList->working_time = $workingTime;
        }
        return view('user', compact('users', 'userDataLists'));
    }
}
