@extends('layouts.election')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">Confirmation de remise à zéro du site</div>
                <div class="panel-body">
                    <p>Voullez vous vraiment remettre à zéro le site ?</p>
                    <a class="btn btn-success" style="margin:5px;" href="{{ url('/admin/') }}">Annuler</a>
                    <a class="btn btn-danger" style="float:right;margin:5px;" href="{{ url('/admin/reset/confirmed') }}">Remettre à zéro le site</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
