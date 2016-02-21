@extends('layouts.election')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Bienvenue sur le site des élections BDE UTT</div>
                <div class="panel-body">
                    <p>Ce site te permet de voter pour l'équipe que tu as envie de voir gérer le BDE
                    et les différents évènements et activités des deux prochains semestres.</p>


                    @if (isset($endTime))
                        <p><strong>Attention, il ne reste plus que {{ $endTime }} afin la fin des votes !</strong></p>

                        <p>Le vote est anonyme, cependant afin de vérifier que seul les cotisants BDE UTT votent et
                        afin d'éviter à une même personne de voter plusieurs fois, le site nécessite une connexion.</p>
                        <p>Après la connexion, le site étudiant demandera de donner l'autorisation à "Élection BDE UTT" (ce site)
                        d'accéder à tes informations <strong>publiques</strong> (Ton nom et ton numéro étudiant).
                        C'est tout à fait normal et c'est nécessaire pour pouvoir voter sur ce site.</p>


                        @if (Session::has('login'))
                            <a class="btn btn-primary" style="float:right;margin:5px;" href="{{ url('/vote') }}">Voter</a>
                        @else
                            <a class="btn btn-primary" style="float:right;margin:5px;" href="{{ url('/login') }}">Se connecter</a>
                        @endif
                    @elseif (isset($startTime))
                        <p><strong>Les élections ouvrent dans {{ $startTime }} !</strong></p>
                    @else
                        <p><strong>Désolé, les élections sont fermées.</strong></p>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
