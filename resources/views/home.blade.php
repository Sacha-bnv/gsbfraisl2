@extends('layouts.master')
@section('content')
@if (Session::get('id') == '0' || Session::get('id') == null) 
<div>
    <h2 class="bvn">Bienvenue sur le site intranet du laboratoire GSB.</h2>
    <h3 class="bvn">Vous devez vous connecter pour accéder aux services de ce site et vous déconnecter à chaque fin de session. </h3>
</div>
@else
<div>
    <h4>Votre région: {{Session::get('region')}}</h4>
    <h4>Votre secteur: {{Session::get('secteur')}}</h4>
</div>
@endif
@stop
