<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkroles:PRESIDENT|COORDINATOR|REGISTER_COORDINATOR|SECRETARY|STUDENT');
    }

    public function list()
    {
        $instance = \Instantiation::instance();

        $meetings = Auth::user()->meetings()->get();

        return view('meeting.mylist',
            ['instance' => $instance, 'meetings' => $meetings]);
    }
}
