<body>
<script src="{{asset('./jquery.js')}}"></script>
   <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
        <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
        
<link href="{{ asset('./style.css') }}" rel="stylesheet"> 
<link href="{{ asset('./bootstrap-3/css/bootstrap.min.css') }}" rel="stylesheet"> 
<title>DZIENNIECZEK Nastrojow @yield('title')</title>

</bodY>
<div id="center">

  <div id="menu">
    <div class="row">
      <div class="col-md-12"><div align=center><span class=menu2>DZIENNIECZEK NASTROJOW</span></div></div>
    </div>

  </div>
  <div id="center2">
  
  &nbsp;
  </div>
  <div id="page">

    <div id=menu3><div align=center>MENU</div></div>
    <div class=menu4>
    @if ( !Auth::check()  )
    <div class=menu3><a class=menu href={{ url('/rejestracja') }}>Zarejestruj się </a></div>
    <div class=menu3><a class=menu href={{ url('/zaloguj') }}>Zaloguj się </a></div>
    @endif
    @if (Auth::check() )
    <div class=menu3><a class=menu href={{ url('/wyloguj') }}>Wyloguj {{Auth::User()->login}} </a></div>
    <div class=menu3><a class=menu href={{ url('/glowna') }}>Głowna strona </a></div>
    <div class=menu3><a class=menu href={{ url('/wyszukaj') }}>Wyszukaj </a></div>
    <div class=menu3><a class=menu href={{ url('/nowy') }}>Dodaj nowy produkt</a></div>
    <div class=menu3><a class=menu href={{ url('/edytuj_produkt') }}>Mydyfikuj produkty</a></div>
    @endif
    
    </div>

    @yield('content')
  </div>

</div>
<script src="{{asset('./funkcje.js')}}"></script>

