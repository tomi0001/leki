@extends('layout.index')
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '552776771770520',
      xfbml      : true,
      version    : 'v2.12'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
@section('content')
<form action={{ url('zarejestruj') }} method=post>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Twoj login</span></div>
    <div class="col-md-2 col-xs-2"><input type=text id=login2 size=5  class=form-control name=login value={{Input::old('login')}}></div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Twoje has  ło</span></div>
    <div class="col-md-2 col-xs-2"><input type=password id=haslo size=5  class=form-control name=haslo></div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Wpisz jeszcze Twoje hasł  o</span></div>
    <div class="col-md-2 col-xs-2"><input type=password id=haslo2 size=5  class=form-control name=haslo2></div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Twoj email</span></div>
    <div class="col-md-2 col-xs-2"><input type=text id=email size=5  class=form-control name=email  value={{Input::old('email')}}></div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Początek dnia</span></div>
    <div class="col-md-2 col-xs-2"><input type=text id=email size=5  class=form-control name=dzien value={{Input::old('dzien')}}></div>
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
    <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-6 col-xs-6"><div align=center><button  class="btn btn-primary">Zarejestroj</button></div></div>
    <a href="{{ url('/aut/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-3 col-xs-3">
    <div align=center>
 <?php $messages = $errors->all(':message') ?>
      <?php foreach ($messages as $msg): ?>
         <span class=blad><?= $msg ?> <br></span>
      <?php endforeach; ?>
      <span class=blad>{{Session::get('ile')}}</span>
</form>

    </div>
    </div>
@endsection

