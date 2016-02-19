@extends('layouts.election')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Ajout d'une liste</div>
                <div class="panel-body">
                    {!! Form::open(array('route' => 'admin_new_submit')) !!}
                        <div class="form-group">
                            <label for="name">Nom de la liste</label>
                            <input type="text" class="form-control" id="name" name="name" required="required">
                        </div>
                        <div class="form-group">
                            <label for="description">Courte description de la liste</label>
                            <textarea class="form-control" id="description" name="description" required="required" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="promises">Promesses de la liste</label>
                            <textarea class="form-control" id="promises" name="promises" required="required" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="members">Liste des membres</label>
                            <textarea class="form-control" id="members" name="members" required="required" rows="10"></textarea>
                        </div>
                        <input type="submit" class="btn btn-success" style="float:right;" value="Ajouter la liste">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
