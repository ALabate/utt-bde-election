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

class AdminController extends Controller
{
    function __construct() {
        // The user has to be connected
        if(!Session::has('login')) {
            return Redirect::route('home')->send();
        }

        // Check for rights
        if(Session::get('login') != config('election.referer.login')) {
            if(\Request::route()->getName() != 'admin_panel'
                || !in_array(Session::get('login'), config('election.viewer'))) {
                return Redirect::route('home')->send();
            }
        }
    }

    /**
     * Propose each list and buttons to vote
     */
    public function panel(){
        $lists =  ListM::all()->toArray();
        $sumScore =  ListM::sum('score');
        $countVote =  User::count();

        return view('admin.panel', [
            'sumScore' => $sumScore,
            'countVote' => $countVote,
            'lists' => $lists,
            'isReferer' => Session::get('login') == config('election.referer.login')
            ]);
    }

    /**
     * Form to create a new list
     */
    public function create(){
        return view('admin.new');
    }
    /**
     * Subimt of form to create a new list
     */
    public function new_submit(Request $request) {

        if(!$request->has('name')
            || !$request->has('description')
            || !$request->has('members')
            || !$request->has('promises')) {
            return Redirect::route('admin_new')->send();
        }

        $list = new ListM;
        $list->name = $request->get('name');
        $list->description = $request->get('description');
        $list->members = $request->get('members');
        $list->promises = $request->get('promises');
        $list->save();

        return Redirect::route('admin_panel')->send();
    }

    /**
     * Form to edit a new list
     */
    public function edit($id){
        $list = ListM::find($id);
        return view('admin.edit', [ 'list' => $list ]);
    }
    /**
     * Subimt of form to edit a new list
     */
    public function edit_submit($id, Request $request) {

        if(!$request->has('name')
            || !$request->has('description')
            || !$request->has('members')
            || !$request->has('promises')) {
            return Redirect::route('admin_edit')->send();
        }

        $list = ListM::find($id);
        $list->name = $request->get('name');
        $list->description = $request->get('description');
        $list->members = $request->get('members');
        $list->promises = $request->get('promises');
        $list->save();

        return Redirect::route('admin_panel')->send();
    }

    /**
     * Form to confirm delete of a list
     */
    public function delete_confirm($id){
        $list = ListM::find($id);
        return view('admin.delete', [ 'list' => $list ]);
    }
    /**
     * delete a list
     */
    public function delete($id) {

        $list = ListM::find($id);
        $list->delete();

        return Redirect::route('admin_panel')->send();
    }

    /**
     * Form to confirm reset of the site
     */
    public function reset_confirm(){
        return view('admin.reset');
    }
    /**
     * reset of the site
     */
    public function reset() {

        ListM::truncate();
        User::truncate();

        return Redirect::route('admin_panel')->send();
    }
}
