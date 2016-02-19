@extends('layouts.election')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Erreur</div>
                <div class="panel-body"><p>Vous avez déjà voté et il est impossible de modifier son vote !</p>
                    <a class="btn btn-primary" style="float:right;margin:5px;" href="{{ url('/logout') }}">Deconnexion</a>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <p>Pour toute question ou remarque relative aux elections BDE, veuillez contacter l'arbitre : {{ config('election.referer.email') }}</p> 
        </div>
    </div>
</div>
@endsection
