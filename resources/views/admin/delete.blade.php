@extends('layouts.election')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">Confirmation de suppression</div>
                <div class="panel-body">
                    <p>Voullez vous vraiment supprimer la liste <strong>{{ $list->name }}</strong> ?</p>

                    @if ($list->score > 0 )
                        <p><strong>Attention ! Cette liste possède des voix, si vous la supprimez, vous allez créer une incohérence dans les résultats</strong>. En effet il y aura plus de personnes ayant voté que de points attribués. <strong>Cela rend l'election invalide.</strong></p>
                    @endif
                    <a class="btn btn-success" style="margin:5px;" href="{{ url('/admin/') }}">Annuler</a>
                    <a class="btn btn-danger" style="float:right;margin:5px;" href="{{ url('/admin/delete/'.$list['id'].'/confirmed') }}">Supprimer la liste <br/><strong>{{ $list->name }}</strong></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
