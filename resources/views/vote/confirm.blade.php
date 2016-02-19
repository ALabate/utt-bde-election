@extends('layouts.election')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                @if ($list != null)
                    <div class="panel-heading">Confirmation de vote pour <strong>{{ $list->name }}</strong></div>
                    <div class="panel-body">
                        <p>Tu as choisis de voter pour <strong>{{ $list->name }}</strong>. Tu ne pourras pas modifier ce choix par la suite. Veux-tu vraiment continuer ?</p>
    					<a class="btn btn-primary" style="float:right;margin:5px;" href="{{ url('/vote/'.$list->id.'/confirmed') }}">Confirmer le vote pour <strong>{{ $list->name }}</strong></a>
                        <a class="btn btn-danger" style="float:right;margin:5px;" href="{{ url('/vote/') }}">Annuler</a>
                    </div>
                @else
                    <div class="panel-heading">Confirmation de vote <strong>blanc</strong></div>
                    <div class="panel-body">
                        <p>Tu as choisis de voter <strong>blanc</strong>. Tu ne pourras pas modifier ce choix par la suite. Veux-tu vraiment continuer ?</p>
                        <a class="btn btn-primary" style="float:right;margin:5px;" href="{{ url('/vote/0/confirmed') }}">Confirmer le vote <strong>blanc</strong></a>
                        <a class="btn btn-danger" style="float:right;margin:5px;" href="{{ url('/vote/') }}">Annuler</a>
                    </div>
                @endif
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
