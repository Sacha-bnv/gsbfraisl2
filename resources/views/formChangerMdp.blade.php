@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'changerMdp']) !!}  
<div class="col-md-12 well well-md">
    <center><h1>Changer de mot de passe</h1></center>
    <div class="form-horizontal">    
        <div class="form-group">
            <label class="col-md-3 control-label">Mot de passe : </label>
            <div class="col-md-6 col-md-3">
                <input type="password" name="pwd_actuel" ng-model="pwd" class="form-control" placeholder="Votre mot de passe" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Nouveau mot de passe : </label>
            <div class="col-md-6 col-md-3">
                <input pattern="(?=^.{6}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" type="password" name="pwd_nouveau" ng-model="pwd" class="form-control" placeholder="Votre mot de passe" required>
            </div>
            <!-- pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"-->
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Confirmer mot de passe : </label>
            <div class="col-md-6 col-md-3">
                <input pattern="(?=^.{6}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" type="password" name="pwd_confirmer" ng-model="pwd" class="form-control" placeholder="Votre mot de passe" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
            </div>
        </div>
    @if (session('erreur'))
        <div class="alert alert-danger">
         {{ session('erreur') }}
        </div>
    @elseif(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    </div>
</div>
{!! Form::close() !!}
@stop