<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Work;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;


use function Ramsey\Uuid\v1;

class WorkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $items = User::all();
        $param = ['items' => $items, 'user' => $user];
        return view('work', $param);
    }
    public function workIn()
    {
        // **必要なルール**
        // ・同じ日に2回出勤が押せない(もし打刻されていたらhomeに戻る設定)
        $user = Auth::user();
        $oldtimein = Work::where('user_id', $user->id)->latest()->first(); //一番最新のレコードを取得

        $oldDay = '';

        //退勤前に出勤を2度押せない制御
        if ($oldtimein) {
            $oldTimePunchIn = new Carbon($oldtimein->work_start);
            $oldDay = $oldTimePunchIn->startOfDay(); //最後に登録したpunchInの時刻を00:00:00で代入
        }
        $today = Carbon::today(); //当日の日時を00:00:00で代入

        if (($oldDay == $today) && (empty($oldtimein->work_end))) {
            return redirect()->back()->with('message', '出勤打刻済みです');
        }
        //$user = Auth::user();
        //$dateStamp = Work::where('user_id', $user->id)->latest()->first();
        Work::create([
        'user_id' => $user->id,
        'work_start' => Carbon::now(),
        'date' => Carbon::now()
        ]);
        return redirect('/')->with('message', '本日もよろしくお願いします。');
    }
    public function workOut() {
        $user = Auth::user();
        $timeOut = Work::where('user_id', $user->id)->latest()->first();

        //string → datetime型
        $now = new Carbon();
        $punchIn = new Carbon($timeOut->work_start);
        $breakIn = new Carbon($timeOut->rest_start);
        $breakOut = new Carbon($timeOut->rest_end);
        if ($timeOut) {
            if (empty($timeOut->work_end)) {
                if ($timeOut->rest_start && !$timeOut->rest_end) {
                    return redirect()->back()->with('message', '休憩終了が打刻されていません');
                } else {
                    $timeOut->update([
                        'work_end' => Carbon::now(),
                        'date' => Carbon::now(),
                    ]);
                    return redirect()->back()->with('message', 'お疲れ様でした');
                }
            } else {
                $today = new Carbon();
                $day = $today->day;
                $oldPunchOut = new Carbon();
                $oldPunchOutDay = $oldPunchOut->day;
                if ($day == $oldPunchOutDay) {
                    return redirect()->back()->with('message', '退勤済みです');
                } else {
                    return redirect()->back()->with('message', '出勤打刻をしてください');
                }
            }
        } else {
            return redirect()->back()->with('message', '出勤打刻がされていません');
        }
    }
    public function restIn() {
        $user = Auth::user();
        $oldtimein = Work::where('user_id', $user->id)->latest()->first();
        if ($oldtimein->work_start && !$oldtimein->work_end) {
            Rest::create([
                'work_id' => $user->id,
                'rest_start' => Carbon::now(),
            ]);
            return redirect()->back()->with('message', '休憩お願いします。');
        }
    }
    public function restOut() {
        $work = Auth::user();
        $oldtimein = Rest::where('work_id', $work->id)->latest()->first();
        if ($oldtimein->rest_start && !$oldtimein->rest_end) {
            $oldtimein->update([
                'rest_end' => Carbon::now(),
            ]);
        }
        $oldtimein = Rest::where('work_id', $work->id)->latest()->first();
        $restStart = new Carbon($oldtimein->rest_start);
        $restEnd = new Carbon($oldtimein->rest_end);
        $restTime = $restStart->diffInSeconds($restEnd);
        // dd($restTime);
        // $restTimeGet = gmdate("H:i:s", $restTime);
        $oldtimein->update([
            'rest_time' => $restTime
        ]);
        return redirect()->back()->with('message', '休憩終わりです。頑張りましょう。');
    }
    public function show() {
        $works = Work::Paginate(5);
        $users = User::all();
        //$rests = Rest::all();
        //$work = Work::all();
        $rests = Rest::select('work_id', DB::raw('SUM(rest_time) as rest_time'))->groupBy('id')->get();
        //$date = $work->date;
        //$stamps = Work::join('users', 'users.id', 'user_id')
        //クエリに対してleftJoinSubでサブクエリをjoin
        //必ずしも休憩時間があるわけではないないのでleftJoinSubを採用
        //->leftJoinSub($rests, 'rests', function ($join) {
            //$join->on('work.id', '=', 'rests.work_id');
        //})
            //->where('date', $date)
            //->orderBy('works.updated_at', 'asc')
            //->paginate(5);

        //return view('attendance')->with('works', $works);
        //$user = Auth::user();
        //$timeOut = Work::where('user_id', $user->id);
        //$time = Work::where('user_id',$user->id);

        //string → datetime型
        $now = new Carbon();
        //$from = new Carbon($timeOut->work_start);
        //$to = new Carbon($timeOut->work_end);
        //$breakOut = new Carbon($timeOut->rest_end);

        // 日時からタイムスタンプを作成
        //$fromSec = strtotime($from);
        //$toSec   = strtotime($to);

        // 秒数の差分を求める
        //$differences = $toSec - $fromSec;

        // フォーマットする
        //$results = gmdate("H:i:s", $differences);

        return view('attendance', [
            'works' => $works,
            'rests'   => $rests,
            'users' => $users,
        ]);
    }
}
