@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'creerAffectation']) !!}  
<div class="col-md-12 well well-md">
    <center>            
        @foreach($lesInfos as $uneInfo)
            <h1>{{ $uneInfo->prenom }} {{ $uneInfo->nom }} - {{ $uneInfo->tra_reg }} ({{ $uneInfo->tra_role }})</h1>
        @endforeach
    </center>
    <div class="form-horizontal">    
        <div class="form-group">
            <div style="text-align: center">
                <label>Région : </label>            
                <select name="region">
                    @foreach($lesRegions as $uneRegion)
                        <option>{{ $uneRegion->reg_id }} {{ $uneRegion->reg_nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div style="text-align: center">
                <label>Rôle : </label>            
                <select name="role">
                    <option>{{ $uneInfo->tra_role }}</option>
                    @if ($uneInfo->tra_role == 'Délégué')
                        <option>Visiteur</option>
                    @endif
                    @if ($uneInfo->tra_role == 'Visiteur')
                        <option>Délégué</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group">
            <div style="text-align: center">
                <button type="submit" class="btn btn-default btn-primary">Modifier</button>
            </div>
        </div>
    @if (session('erreur'))
        <div class="alert alert-danger">
         {{ session('erreur') }}
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">
         {{ session('status') }}
        </div>
    @endif
    </div>
</div>
{!! Form::close() !!}
@stop