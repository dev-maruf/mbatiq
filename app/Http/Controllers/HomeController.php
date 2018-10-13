<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\User;

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
        $user = \Auth::user();
        $temp = $this->getTemp($user);
        
        return view('home', compact('temp'));
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

    public function getTemp(User $user)
    {
        $color = ['info', 'success', 'warning', 'danger', 'danger'];
        
        $machine_temp = $user->temp;

        if($user->last_update == null){
            $machine_temp = 0;
        }
        else if(Carbon::createFromFormat("Y-m-d H:i:s", $user->last_update, "Asia/Jakarta")->diffInMinutes(Carbon::now()) > 5){
            $machine_temp = 0;
        }

        $indicator = ($machine_temp)/25;

        $temp = [
            'val' => $machine_temp,
            'color' => $color[$indicator]
        ];

        return $temp;
    }

    public function getTempAPI()
    {
        $user = \Auth::user();
        $temp = $this->getTemp($user);
        return $temp;
    }
}
