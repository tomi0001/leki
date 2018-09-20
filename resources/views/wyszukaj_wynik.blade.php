@extends('layout.index')
@section('content')
<body onload="ukryj_divy({{count($produkty)}})">
    <div class="row">
    <div class="col-md-4 col-xs-4">
    </div>
    <div class="col-md-8 col-xs-8">
 
        @for ($i=0;$i< count($produkty);$i++)
<div class="row">
  <div class="row">
    <div class="col-md-8">
   

`       <div class="{{$produkty[$i]['color']}}">
      @if ($i == 0) 
     <div class="data{{$produkty[$i]['color']}}">{{$produkty[$i]['rok']}}-{{$produkty[$i]['miesiac']}}-{{$produkty[$i]['dzien']}}</div>
     
     @elseif (($produkty[$i-1]['rok'] != $produkty[$i]['rok'] or $produkty[$i-1]['miesiac'] != $produkty[$i]['miesiac'] or $produkty[$i-1]['dzien'] != $produkty[$i]['dzien']))
      <div class="data{{$produkty[$i]['color']}}">{{$produkty[$i]['rok']}}-{{$produkty[$i]['miesiac']}}-{{$produkty[$i]['dzien']}}</div>
     @endif
          <div align="center">
            <span class="psycho">Wziąłes lek o nazwie {{$produkty[$i]['nazwa']}}</span><span class="pogrubiona">({{$produkty[$i]['nazwa_sub']}})</span><br>


            <span class="psycho">Data wzięcia {{$produkty[$i]['data']}}<br>
                Wydałeś na to {{$produkty[$i]['cena']}}<br>
                Dawka    {{$produkty[$i]['porcja']}}</span><br>
                @if ($produkty[$i]["przekierowanie"] != "")
                <button class="btn btn-success" onclick=pokaz_opis('{{ url('pokaz_opis')}}',{{$produkty[$i]['id']}},{{$i}})>Pokaz opis</button>
                @else
                <button class="btn btn-danger" disabled>Nie było opisu</button>
                @endif
                <a href={{ url('glowna') }}/{{$produkty[$i]['rok']}}/{{$produkty[$i]['miesiac']}}/{{$produkty[$i]['dzien']}}><button class="btn btn-success">Idź do dnia</button></a>
                <div id="pokaz_opis__{{$i}}"></div>
                
                    
                
          </div>
        </div>
    </div>`
  </div>
        <div class="col-md-3">
        
    </div>
</div>
@endfor
  
@for ($i=0;$i < count($paginacja);$i++)
    @if ($paginacja[$i][1] == false)
       <div class="strona_aktywna">
        <a href="{{$link . $paginacja[$i][0]}}" class="paginacja_hiper">{{$paginacja[$i][0]}}</a>
       </div>
    @else 
       <div class="strona_nie_aktywna">
            {{$paginacja[$i][0]}}
       </div>
    @endif
@endfor



    </div>
    </div>
@endsection



