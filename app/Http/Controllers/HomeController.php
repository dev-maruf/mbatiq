<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function changeState(Request $request)
    {
        // return $request->state;
        $user = \App\User::find(\Auth::user()->id);
        $user->update([
            'machine' => $request->state
        ]);
        return $user['machine'];
        // return "oke";
    }
}
