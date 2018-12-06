@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'changerMdp']) !!}  
<div class="col-md-12 well well-md">
    <center><h1>Nouveau Visiteur</h1></center>
    <div class="form-horizontal">    
        <div class="form-group">
            <label class="col-md-3 control-label">Nom : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="nom" ng-model="nom" class="form-control" placeholder="Votre nom" pattern="[A-Za-z]{3,}" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Prénom : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="prenom" ng-model="prenom" class="form-control" placeholder="Votre prénom" pattern="[A-Za-z]{3,}" required>
            </div>
           
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Adresse : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="adresse" ng-model="adresse" class="form-control" placeholder="Votre adresse" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Code Postal : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="cp" ng-model="cp" class="form-control" placeholder="Votre code postal" pattern="[0-9]{5}" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Ville : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="ville" ng-model="ville" class="form-control" placeholder="Votre ville" pattern="[A-Za-z]{1,}" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Date d'embauche : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="dateEmbauche" ng-model="dateEmbauche" class="form-control" placeholder="Votre date d'embauche" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])"  required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Téléphone : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="tel" ng-model="tel" class="form-control" placeholder="Votre téléphone" pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Email : </label>
            <div class="col-md-6 col-md-3">
                <input type="email" name="email" ng-model="email" class="form-control" placeholder="Votre email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">ID : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="id" maxlength="4" ng-model="id" class="form-control" placeholder="Votre ID" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Rôle : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="role" ng-model="role" class="form-control" placeholder="Votre rôle" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Région d'affectation : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="regionAffectation" ng-model="regionAffectation" class="form-control" placeholder="Votre région d'affectation" required>
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
    @endif
    </div>
</div>
{!! Form::close() !!}
@stop