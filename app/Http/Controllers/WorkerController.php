<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    public function index() {
        $user = Auth::user();
        $items = Worker::all();
        $param = ['items' => $items, 'user' => $user];
        return view('work', $param);
    }
}
