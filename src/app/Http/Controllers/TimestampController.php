<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Timestamp;
use Carbon\Carbon;

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

    public function start(Request $request)
    {

        $user = Auth::user();
        $oldstart = Timestamp::where('user_id', $user->id)->latest('created_at')->first();
        if ($oldstart && $oldstart->created_at)
        {
            $timestamp = now()->format('Y-m-d');
            $createdDate = $oldstart->created_at->format('Y-m-d');

            if ($timestamp == $createdDate)
            {
                return redirect()->back()->with('error', '重複しています');
            }
        }
        $time = Timestamp::create([
            'user_id' => $user->id,
            'start' => Carbon::now(),
        ]);
        return redirect('/');
    }
}
