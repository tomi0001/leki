@extends('layout.index')
@section('content')
<form action={{ url('logowanie') }} method=post>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Twoj login</span></div>
    <div class="col-md-2 col-xs-2"><input type=text id=login2 size=5  class=form-control name=name value={{Input::old('name')}}></div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Twoje hasło</span></div>
    <div class="col-md-2 col-xs-2"><input type=password id=haslo size=5  class=form-control name=haslo></div>
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
    <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-6 col-xs-6"><div align=center><button  class="btn btn-primary">Zaloguj się</button></div></div>
    
</div>
@endsection
