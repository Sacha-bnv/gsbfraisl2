@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'modificationsVisiteur']) !!}  
<div class="col-md-12 well well-md">
    <center><h1>Modifications Personnelles</h1></center>
    <div class="form-horizontal">
            @foreach($rec as $laRec)
            <div class="form-group">
                <label class="col-md-3 control-label">Adresse : </label>
                <h5> {{ $laRec->adresse  }}</h5>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Code Postal : </label>
                <h5>{{ $laRec->cp }}</h5>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Ville : </label>
                <h5>{{ $laRec->ville }}</h5>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Téléphone : </label>
                <h5>{{ $laRec->tel }}</h5>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Email : </label>
                <h5>{{ $laRec->email }}</h5>
            </div>
            @endforeach
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
            <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
            </div>
        </div>
        
    @if (session('erreur'))
        <div class="alert alert-danger">
         {{ session('erreur') }}
        </div>
    @elseif (session('status'))
    <div class="alert alert-success">
         {{ session('status') }}
        </div>
    @endif
    </div>
</div>
{!! Form::close() !!}
@stop