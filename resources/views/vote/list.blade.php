@extends('layouts.election')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
	        <p>Tu peux maintenant voter pour la liste que tu préfère. <br/><strong>Attention, il ne reste plus que {{ $endTime }} afin la fin des votes !</strong></p>
	        <p>Note : Les listes sont affichés dans un ordre aléatoire afin d'éviter une inégalité causé par la flemme d'utiliser la molette ;)</p>
	        
        </div>
    </div>

    @foreach ($lists as $i => $list)
    @if (!empty($list['name']))
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Liste <strong>{{ $list['name'] }}</strong></div>
                <div class="panel-body">
                	{!! nl2br(e($list['description'])) !!}

                	<h4>Ce que la liste promet</h4>
                	<a data-toggle="collapse" href="#promise{{ $list['id'] }}">Afficher/Masquer</a>
                	<p id="promise{{ $list['id'] }}" class="collapse">{!! nl2br(e($list['promises'])) !!}</p>

                	<h4>Liste des membres</h4>
                	<a data-toggle="collapse" href="#members{{ $list['id'] }}">Afficher/Masquer</a>
                	<p id="members{{ $list['id'] }}" class="collapse">{!! nl2br(e($list['members'])) !!}</p>

					<a class="btn btn-primary" style="float:right;margin:5px;" href="{{ url('/vote/'.$list['id']) }}">Voter pour la liste <br/><strong>{{ $list['name'] }}</strong></a>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Vote blanc</div>
                <div class="panel-body">
                	<p>Si tu considère que les propositions de listes ne te conviennent pas, ou pour tout autre raison, tu peux voter blanc.</p>
                	<p>Les votes blanc sont tout de même comptés et permettent de savoir si ce que proposent les listes répond à la demande des étudiants.
                	Néanmoins ils n'auront pas d'influence sur le résultats.</p>

					<a class="btn btn-primary" style="float:right;margin:5px;" href="{{ url('/vote/0') }}">Voter blanc</a>
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
