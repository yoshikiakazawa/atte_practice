<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Timestamp;
use App\Models\BreakTime;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminRequest;

class AdminController extends Controller
{
    public function login_get()
    {
        return view('admin_login');
    }

    public function login_post(AdminRequest $request)
    {
        $credentials = $request->only(['userid', 'password']);

        if (Auth::guard('admins')->attempt($credentials))
        {
            return redirect()->route('admin_index');
        }

        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin_login_get');
    }
    public function admin()
    {
        $users = User::paginate(5);
        return view('admin', compact('users'));
    }
    public function user(Request $request, User $id)
    {
        if (empty($request->date))
        {
            $thisMonth = Carbon::now();
            $lastMonth = $thisMonth->copy()->subMonth();
            $nextMonth = $thisMonth->copy()->addMonth();
        }
        else
        {
            $thisMonth = Carbon::parse($request->date);
            $lastMonth = $thisMonth->copy()->subMonth();
            $nextMonth = $thisMonth->copy()->addMonth();
        }
        $thisMonthLists = Timestamp::where('user_id', $id->id)
            ->whereYear('created_at', $thisMonth->year)
            ->whereMonth('created_at', $thisMonth->month)
            ->latest()->paginate(5)->withQueryString();
        $thisMonthBreakLists = [];
        foreach ($thisMonthLists as $thisMonthList)
        {
            $breakLists = BreakTime::where('timestamp_id', $thisMonthList->id)
                ->whereYear('created_at', $thisMonth->year)
                ->whereMonth('created_at', $thisMonth->month)
                ->get();
            $thisMonthBreakLists[$thisMonthList->id] = $breakLists;
        }
        foreach ($thisMonthLists as $thisMonthList)
        {
            $workIn = Carbon::parse($thisMonthList->work_in);
            $workOut = Carbon::parse($thisMonthList->work_out);
            $workingHours = $workOut->diff($workIn)->format('%H:%I:%S');
            $fromTimestamp = strtotime($workingHours);
            $toTimestamp = strtotime($thisMonthList->break_total);
            $diff = $fromTimestamp - $toTimestamp;
            $workingTime = gmdate("H:i:s", $diff);
            $thisMonthList->working_time = $workingTime;
        }
        return view('admin_user', compact('id', 'thisMonthLists', 'thisMonth', 'lastMonth', 'nextMonth', 'thisMonthBreakLists'));
    }

    public function updateTime(Request $request)
    {
        $form = $request->all();
        $oldTime = Timestamp::find($request->id);
        if ($form['work_in'] != $oldTime->work_in && $form['work_out'] != $oldTime->work_out)
        {
            $oldTime->update([
                'work_in' => $form['work_in'],
                'work_out' => $form['work_out'],
            ]);
            return redirect()->back()->with('flash_message', '出勤時間と退勤時間を修正しました');
        }
        elseif ($form['work_in'] != $oldTime->work_in)
        {
            $oldTime->update([
                'work_in' => $form['work_in'],
            ]);
            return redirect()->back()->with('flash_message', '出勤時間を修正しました');
        }
        elseif ($form['work_out'] != $oldTime->work_out)
        {
            $oldTime->update([
                'work_out' => $form['work_out'],
            ]);
            return redirect()->back()->with('flash_message', '退勤時間を修正しました');
        }
        return redirect()->back()->with('flash_message', '変更されていません');
    }
    public function updateBreak(Request $request)
    {
        $form = $request->all();
        $oldBreak = BreakTime::find($request->id);
        $oldTime = Timestamp::find($request->timestamp_id);
        if ($form['break_in'] != $oldBreak->break_in && $form['break_out'] != $oldBreak->break_out)
        {
            $oldBreak->update([
                'break_in' => $form['break_in'],
                'break_out' => $form['break_out'],
            ]);
            $breakLists = BreakTime::where('timestamp_id', $form['timestamp_id'])->get();
            $totalBreakTimeInSeconds = 0;
            foreach ($breakLists as $breakList)
            {
                $breakIn = Carbon::parse($breakList->break_in);
                $breakOut = Carbon::parse($breakList->break_out);
                $breakTimeInSeconds = $breakOut->diffInSeconds($breakIn);
                $totalBreakTimeInSeconds += $breakTimeInSeconds;
            }
            $oldTime->break_total = gmdate('H:i:s', $totalBreakTimeInSeconds);
            $oldTime->save();
            return redirect()->back()->with('flash_message', '休憩開始時間と休憩終了時間を修正しました');
        }
        elseif ($form['break_in'] != $oldBreak->break_in)
        {
            $oldBreak->update([
                'break_in' => $form['break_in'],
            ]);
            $breakLists = BreakTime::where('timestamp_id', $form['timestamp_id'])->get();
            $totalBreakTimeInSeconds = 0;
            foreach ($breakLists as $breakList)
            {
                $breakIn = Carbon::parse($breakList->break_in);
                $breakOut = Carbon::parse($breakList->break_out);
                $breakTimeInSeconds = $breakOut->diffInSeconds($breakIn);
                $totalBreakTimeInSeconds += $breakTimeInSeconds;
            }
            $oldTime->break_total = gmdate('H:i:s', $totalBreakTimeInSeconds);
            $oldTime->save();
            return redirect()->back()->with('flash_message', '休憩開始時間を修正しました');
        }
        elseif ($form['break_out'] != $oldBreak->break_out)
        {
            $oldBreak->update([
                'break_out' => $form['break_out'],
            ]);
            $breakLists = BreakTime::where('timestamp_id', $form['timestamp_id'])->get();
            $totalBreakTimeInSeconds = 0;
            foreach ($breakLists as $breakList)
            {
                $breakIn = Carbon::parse($breakList->break_in);
                $breakOut = Carbon::parse($breakList->break_out);
                $breakTimeInSeconds = $breakOut->diffInSeconds($breakIn);
                $totalBreakTimeInSeconds += $breakTimeInSeconds;
            }
            $oldTime->break_total = gmdate('H:i:s', $totalBreakTimeInSeconds);
            $oldTime->save();
            return redirect()->back()->with('flash_message', '休憩終了時間を修正しました');
        }
        return redirect()->back()->with('flash_message', '変更されていません');
    }
}
