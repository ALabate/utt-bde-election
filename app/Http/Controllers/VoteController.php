<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ListM;
use App\User;


use DateTime;
use DateTimeZone;
use Session;
use Redirect;
use DB;
use config;

class VoteController extends Controller
{
    function __construct() {
        // The user has to be connected
        if(!Session::has('login')) {
            Redirect::route('home')->send();
        }

        // We have to be between start and end of the vote
        $now = new DateTime();
        if($now < config('election.start') || $now > config('election.end')) {
            Redirect::route('home')->send();
        }

        // Check if the user has voted
        if(\Request::route()->getName() != 'vote_already') {
            $count = User::where('login', Session::get('login'))->count();
            if($count > 0) {
                Redirect::route('vote_already')->send();
            }
        }
    }

    /**
     * Propose each list and buttons to vote
     */
    public function index(){
        $lists =  ListM::all()->toArray();


        $endTime = config('election.end')->diff(new DateTime(), true)->format('%d jour(s), %h heure(s) et %i minute(s)');
        shuffle($lists);

        return view('vote.list', ['lists' => $lists, 'endTime' => $endTime]);
    }

    /**
     * Ask user to confirm his vote
     */
    public function confirm($id){
        $list =  ListM::where('id', $id)->first();;

        return view('vote.confirm', ['list' => $list]);
    }

    /**
     * Put the vote in database
     */
    public function doit($id){

        $user = new User;
        $user->login = Session::get('login');
        $user->save();

        if($id != 0)
        {
            ListM::find($id)->increment('score');
        }
        else {
            $list = ListM::firstOrCreate(['name' => '']);
            $list->increment('score');
        }

        // deconnexion
        Session::flush();
        return view('vote.done');
    }

    /**
     * Errot that explain that you already voted
     */
    public function already(){
        return view('vote.already');
    }
}
