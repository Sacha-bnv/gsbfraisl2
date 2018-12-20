@extends('layouts.master')
@section('content')
<div class="container">
    <div class="col-md-5">
        <div class="blanc">
            <h1>Suivi des frais</h1>
        </div>
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th style="width:20%">Prénom</th> 
                    <th style="width:20%">Nom</th> 
                </tr>
            </thead>
            @foreach($lesVisiteurs as $unVisiteur)
            <tr>
                <td> {{ $unVisiteur->prenom }} </td> 
                <td> {{ $unVisiteur->nom }} </td> 
                <td style="text-align:center"> <a href="{{ url('/getUnVisiteur') }}/{{ $unVisiteur->id }}"> <button type="submit" class="btn btn-default btn-primary">Sélectionner</button> </a></td> 
            </tr>
            @endforeach
        </table>
    @if (session('erreur'))
        <div class="alert alert-danger">
         {{ session('erreur') }}
        </div>
    @endif
    </div>
</div>
@stop
