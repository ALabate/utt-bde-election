<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use config;
use DateTime;
use DateTimeZone;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class LoginController extends Controller
{
    /**
     * First page that the user see, it explain what this site is for
     */
    public function home(){
        // We have to be between start and end of the vote
        $now = new DateTime('now', new DateTimeZone('Europe/Paris'));
        if($now < config('election.start')) {
            $startTime = config('election.start')->diff(new DateTime(), true)->format('%d jour(s), %h heure(s) et %i minute(s)');
            return view('home', [ 'startTime' => $startTime ]);
        }
        else if($now > config('election.end')){
            return view('home');
        }
        else {
            $endTime = config('election.end')->diff(new DateTime(), false)->format('%d jour(s), %h heure(s) et %i minute(s)');
            return view('home', [ 'endTime' => $endTime ]);
        }
    }


    /**
     * Redirect user to EtuUTT to log in and get his personal informations
     */
    public function redirect(){
        return redirect(
            config('election.etuutt.baseuri')
            . '/api/oauth/authorize?client_id='
            . config('election.etuutt.appid')
            . '&scopes=public&response_type=code');
    }


    /**
    * The user is redirected to this page after EtuUTT
    * with the authorization_code needed to get informations
    */
    public function auth(Request $request)
    {

        // Check if we have our authorization_code
        if(!$request->has('authorization_code'))
        {
            return abort(403);
        }
        $authCode = $request->input('authorization_code');

        // Create http client to interface with EtuUTT API
        $client = new Client([
           'base_url' => config('election.etuutt.baseuri'),
           'defaults' => [
              'auth' => [
                 config('election.etuutt.appid'),
                 config('election.etuutt.appsecret')
              ]
           ]
        ]);

        // Try to get authorization to get informations from EtuUTT
        try
        {
            $response = $client->post('/api/oauth/token', [
               'body' => [
                   'grant_type'         => 'authorization_code',
                   'authorization_code' => $authCode
               ]]);
        }
        catch(ClientException $e)
        {
            // An error 400 from the server is usual when the authorization_code
            // has expired. Redirect the user to the OAuth gateway to be sure
            // to regenerate a new authorization_code for him :-)
            if ($e->getResponse() != null && $e->getResponse()->getStatusCode() === 400)
            {
               return redirect()->route('login_redirect');
            }
            return abort(502, 'Impossible de récupérer les informations de connexion de EtuUTT');
        }

        // Try to decode authorization informations
        $json = json_decode($response->getBody()->getContents(), true);
        if ($json === null || empty($json['response']['access_token']))
        {
            return abort(502, 'Impossible de lire les informations de connexion de EtuUTT');
        }

        // Try to get informations from user
        try
        {
            $response = $client->get('/api/public/user/account?access_token=' . $json['response']['access_token']);
        }
        catch(GuzzleException $e)
        {
            return abort(502, 'Impossible de récupérer les informations utilisateur de EtuUTT');
        }

        // Try to decode user informations
        $json = json_decode($response->getBody()->getContents(), true);
        if ($json === null || empty($json['response']['data']))
        {
            return abort(502, 'Impossible de lire les informations utilisateur de EtuUTT');
        }

        // Check if the user is in cotisant list
        if(!in_array($json['response']['data']['studentId'], config('election.cotisants.id'))
            && !in_array($json['response']['data']['login'], config('election.cotisants.login'))) {
            return redirect()->route('login_cannot');
        }

        // Login
        Session::put('login', $json['response']['data']['login']);
        Session::put('fullname', $json['response']['data']['fullName']);

        // Redirect to vote
        return redirect()->route('vote_index');
    }

    /**
    * The user is logged out and then redirected to home
    */
    public function logout(Request $request)
    {
        Session::flush();
        return view('login.logout');
    }

    /**
     * Errot that explain why you cannot vote
     */
    public function cannot(){
        return view('login.cannot');
    }
}
