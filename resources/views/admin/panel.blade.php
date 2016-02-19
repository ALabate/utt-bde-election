@extends('layouts.election')

@section('content')
<div class="container">

    @if ($sumScore != $countVote)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">Incohérence détecté</div>
                <div class="panel-body"><p>Le nombre de personnes ayant voté est de <strong>{{ $countVote }}</strong> alors qu'il y a au total <strong>{{ $sumScore }} vote(s) comptabilisé(s)</strong>.</p>
               </div>
            </div>
        </div>
    </div>
    @endif


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Résultats actuels</div>
                <div class="panel-body">
                    <p>Il y a au total pour le moment {{ $sumScore }} vote(s) comptabilisé(s).</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Liste</th>
                                <th>Vote(s)</th>
                                @if ($sumScore > 0)
                                <th>Pourcentage</th>
                                @endif
                            </tr>
                        </thead>
                    <tbody>
                        @foreach ($lists as $i => $list)
                            @if (!empty($list['name']))
                            <tr>
                                <td>{{ $list['name'] }}</td>
                                <td>{{ $list['score'] }}</td>
                                @if ($sumScore > 0)
                                <td>{{ round(($list['score']/$sumScore)*100, 2) }} %</td>
                                @endif
                            </tr>
                            @else
                                <?php $white = $list['score'] ?>
                            @endif
                        @endforeach
                        
                        <tr>
                            <td>Votes blancs</td>
                            <td>{{ $white or 0 }}</td>
                            @if ($sumScore > 0)
                            <td>{{ round(((isset($white)?$white:0)/$sumScore)*100, 2) }} %</td>
                            @endif
                        </tr>
                    </tbody>
                    </table>
               </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if ($isReferer)
                <h2>Modification des listes proposés</h2>
                <a class="btn btn-success" style="float:right;margin-bottom:10px;" href="{{ url('/admin/new')}}">Créer une nouvelle liste</a>
            @else
                <h2>Listes proposés</h2>
            @endif
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

                    @if ($isReferer)
                    <a class="btn btn-primary" style="float:right;margin:5px;" href="{{ url('/admin/edit/'.$list['id']) }}">Modifier la liste <br/><strong>{{ $list['name'] }}</strong></a>
                    <a class="btn btn-danger" style="float:right;margin:5px;" href="{{ url('/admin/delete/'.$list['id']) }}">Supprimer liste <br/><strong>{{ $list['name'] }}</strong></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2>Configuration</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Fichier de configuration</div>
                <div class="panel-body">
                    <ul>
                        <li>Cotisants : 
                            <ul>
                                <li>Enregistrés par Numéro Etu : {{ count(config('election.cotisants.id')) }}</li>
                                <li>Enregistrés par login Etu : {{ count(config('election.cotisants.login')) }}</li>
                            </ul>
                        </li>
                        <li>Dates : 
                            <ul>
                                <li>Date actuelle : {{ (new Datetime('now', new DateTimeZone('Europe/Paris')))->format('d/m/Y H:i:s') }}</li>
                                <li>Début : {{ config('election.start')->format('d/m/Y H:i:s') }}</li>
                                <li>Fin : {{ config('election.end')->format('d/m/Y H:i:s') }}</li>
                            </ul>
                        </li>
                        <li>Arbitre : 
                            <ul>
                                <li>Identifiant : {{ config('election.referer.login') }} (<a target="_blank" href="{{ config('election.etuutt.baseuri') }}/user/{{ config('election.referer.login') }}">Profil</a>)</li>
                                <li>Email : {{ config('election.referer.email') }}</a></li>
                            </ul>
                        </li>
                        <li>Personnes pouvant voir les résultats en plus de l'arbitre : 
                            <ul>
                                 @foreach (config('election.viewer') as $login)
                                <li>{{ $login }} (<a target="_blank" href="{{ config('election.etuutt.baseuri') }}/user/{{ $login }}">Profil</a>)</li>
                                @endforeach
                            </ul>
                        </li>
                        <li>Configuration par rapport au site etu : 
                            <ul>
                                <li>Base URI : {{ config('election.etuutt.baseuri') }}</li>
                                <li>App ID : {{ config('election.etuutt.appid') }}</li>
                                <li>App secret : caché</a></li>
                            </ul>
                        </li>
                    </ul>

                    <p>Pour modifier cette configuration, modifiez le fichier <em>config/election.php</em>.</p>
               </div>
            </div>
        </div>
    </div>

    @if ($isReferer)

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">Remise à zéro du site</div>
                <div class="panel-body">
                    <p>Ce formulaire permet d'effacer toutes les listes et tous les votes. Cette action est définitive.</p>
                    <a href="{{ url('/admin/reset') }}" style="float:right;" class="btn btn-danger">Remettre à zéro tout le site</a>
               </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
