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
                    <th style="width:20%">Période</th> 
                    <th style="width:20%">Voir les fiches</th>  
                </tr>
            </thead>
            @foreach($mesFrais as $unFrais)
            <tr>   
                <td> {{ $unFrais->mois }} </td> 
                <td style="text-align:center;"><a href="{{ url('/getLesFrais') }}/{{ $unFrais->mois }}">
                        <span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="Voir"></span></a></td>
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
