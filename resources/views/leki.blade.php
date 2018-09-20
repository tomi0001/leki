<body onload="ukryj_divy({{count($produkty)}})">
@for ($i=0;$i< count($produkty);$i++)
<div class="row">
    <div class="col-md-4">
        
    </div>
  <div class="row">
    <div class="col-md-5">
    

`       <div class="{{$produkty[$i]['color']}}">
          <div align="center">
              <div class="data{{$produkty[$i]['color']}}">{{$i+1}}</div>
            <span class="psycho">Wziąłes lek o nazwie {{$produkty[$i]['nazwa']}}</span><span class="pogrubiona">({{$produkty[$i]['nazwa_substancji']}})</span><br>


            <span class="psycho">Data wzięcia {{$produkty[$i]['data']}}<br>
                Wydałeś na to {{$produkty[$i]['cena']}}<br>
                Dawka    {{$produkty[$i]['porcja']}}
            </span>
            <br>
                @if ($produkty[$i]['przekierowanie'] == "")
                <button class="btn btn-danger" disabled>Nie było opisu</button>
                @else
                <button class="btn btn-success" onclick=pokaz_opis('{{ url('pokaz_opis')}}',{{$produkty[$i]['id']}},{{$i}})>Pokaz opis</button>
                @endif
                <button class="btn btn-success" onclick=dodaj_opis('{{$i}}')>Dodaj opis</button><br>
                <button class="btn btn-success" onclick=oblicz_srednia('{{ url('oblicz_srednia')}}','{{$produkty[$i]['id']}}',{{$i}})>Oblicz średnią</button><br>
                <div id="srednia{{$i}}"></div>
                <div id="pokaz_opis__{{$i}}"></div>
             
                <div id="dodaj_opis_{{$i}}"
                     <form method="get">
                         <textarea id="opis{{$i}}"></textarea><br>
                         <button onclick=dodaj_opis3('{{ url('dodaj_opis') }}',{{$i}},{{$produkty[$i]['id']}}) class="btn btn-success">Dodaj opis</button>                  
                     </form>
                     <div id="dodaj_opis2_{{$i}}"></div> 
                </div>    
                    
                
          </div>
        </div>
    </div>`
  </div>
        <div class="col-md-3">
        
    </div>
</div>
@endfor
<br>
<form action="{{ url('dodaj_nowy_wpis')}}" method="get">
  <div class="row">
        <div class="col-md-3">

        </div>
      <div class="row">
        <div class="col-md-6">
            <div class="lek3">
              <div align="center" class='tytul'>
                 DODAJ NOWY WPIS
              </div>
                <div class="row">
                    <div class="col-md-1">

                    </div>
                  <div class="row">
                    <div class="col-md-4">

                        <span class="normalna2">Nazwa substancji</span>
                    </div>
                    <div class="col-md-4">
                        <select id="produkt" class="form-control">
                            @for($i=0;$i < count($produkty2);$i++) 
                            <option value="{{$produkty2[$i]['id']}}">{{$produkty2[$i]['nazwa']}}</option>

                            @endfor
                        </select>

                    </div>
                  </div>

                </div>

                <div class="row">
                    <div class="col-md-1">

                    </div>
                  <div class="row">
                    <div class="col-md-4">

                        <span class="normalna2">Dawka substancji</span>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="dawka" size =10 class="form-control">

                    </div>
                  </div>

                </div>
                <div class="row">
                    <div class="col-md-1">

                    </div>
                  <div class="row">
                    <div class="col-md-4">

                        <span class="normalna2">Opis spożycia</span>
                    </div>
                    <div class="col-md-4">
                        <textarea id="opis" cols="20" rows="3" class="form-control"></textarea>
                    </div>
                  </div>

                </div>
                <div class="row">
                    <div class="col-md-1">

                    </div>
                  <div class="row">
                    <div class="col-md-4">

                        <span class="normalna2">Data wzięcia</span>
                    </div>
                    <div class="col-md-4">
                        <input type="date" id="data" class="form-control">
                    </div>
                  </div>

                </div>
                <div class="row">
                    <div class="col-md-1">

                    </div>
                  <div class="row">
                    <div class="col-md-4">

                
                    </div>
                    <div class="col-md-4">
                        <input type="time" id="czas" class="form-control">
                    </div>
                  </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div align ="center"><input type=button  class="btn btn-success" onclick=dodaj_wpis('{{ url('dodaj_wpis')}}') value="Dodaj wpis"></div>
                    </div>
                  

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div align ="center" id="dodaj_wpis"></div>
                    </div>
                  

                </div>
            </div>
   </div>
 </div>        
</div> 
    <br>
    
  <div class="row">
        <div class="col-md-3">

        </div>
      <div class="row">
        <div class="col-md-6">
            <div class="lek3">
              <div align="center" class='tytul'>
                LISTA SUBSTANCJI BRANA DANEGO DNIA
              </div>
                 @for ($i = 0;$i < count($suma_substancji);$i++)
                 <div align="center">
                    {{$suma_substancji[$i]['nazwa']}}
                    {{$suma_substancji[$i]['porcja']}} 
                    {{$suma_substancji[$i]['rodzaj']}}
                    <br>
                 </div>
                    
                 @endfor
            </div>
        </div>
          
      </div>
      
  </div>
  
</form>