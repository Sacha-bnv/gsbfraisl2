@extends('layouts.master')
@section('content')
<div class="container">
    <div class="col-md-5">
        <div class="blanc">
            <h1>Liste des frais des visiteurs</h1>
        </div>
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th style="width:20%">visiteur</th> 
                    <th style="width:20%">Détails</th>  
                </tr>
            </thead>
            @foreach($visiteurs as $unvisiteur)
            <tr>   
                <td> {{ $unvisiteur->idVisiteur }} </td> 
                <td style="text-align:center;"><a href="{{ url('/saisirFraisForfait') }}">
                        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="Modifier"></span></a></td>
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

