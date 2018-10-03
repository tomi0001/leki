@extends('layout.index')
@section('content')


    <div class="row">
    <div class="col-md-5 col-xs-5">
    </div>
    <div class="col-md-7 col-xs-7">
 

 <div class="row">
  <div class="row">
    <div class="col-md-8">
        <div align="center"><span class="pogrubiona">Dodaj nową grupę</span></div>
        <form action="{{ url("nowa_grupa") }}" method="get">
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Nazwa grupy</span>
                </div>
                <div class="col-md-4 col-xs-4">
                    <input type="text" class="form-control" size="40" name="nazwa">
                </div>
             
                
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Color dla grupy</span><span class="normalna3">(Jeżeli nie chesz koloru pozostaw to pole puste)</span>
                </div>
                <div class="col-md-4 col-xs-4">
                    <select name="kolor" class="form-control">
                        <option value="">Brak koloru</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                
                
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div align="center"><button  class="btn btn-success">Dodaj grupę</button></div>
                </div>
               
                
                
            </div>            
            
        </form>
        
    </div>
  </div>
    
   <div class="row">
    <div class="col-md-8">
        <div align="center"><span class="pogrubiona">Dodaj nową substancję</span></div>
        <form action="{{ url("nowa_substancja") }}" method="get">
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Nazwa substancji</span>
                </div>
                <div class="col-md-4 col-xs-4">
                    <input type="text" class="form-control" size="40" name="nazwa">
                </div>
                
                
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Substancje w tej grupie</span><span class="normalna3">(Jeżeli ta substancja nie nalezy do grupy niz nie zaznaczaj)</span>
                </div>
                <div class="col-md-7 col-xs-7">
                    @for($i=0;$i < count($grupy);$i++)
                      <input type="checkbox" name="substancja[]" value="{{$grupy[$i]["id"]}}" /><span class="normalna3">{{$grupy[$i]["nazwa"]}}</span><br />
                    @endfor
                </div>
                
                
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div align="center"><button  class="btn btn-success">Dodaj Substancję</button></div>
                </div>
               
                
                
            </div>            
            
        </form>
        
    </div>
  </div>
     
 <div class="row">
    <div class="col-md-8">
        <div align="center"><span class="pogrubiona">Dodaj nowy produkt</span></div>
        <form action="{{ url("dodaj_produkt") }}" method="get">
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Nazwa produktu</span>
                </div>
                <div class="col-md-4 col-xs-4">
                    <input type="text" class="form-control" size="40" name="nazwa">
                </div>
                
                
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Ile ma procent</span><span class="normalna3">(Jeżeli jest to napój alkoholowy)</span>
                </div>
                <div class="col-md-4 col-xs-4">
                    <input type="text" class="form-control" size="40" name="procent">
                </div>
                
                
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Rodzaj porcji</span>
                </div>
                <div class="col-md-4 col-xs-4">
                    <select name="rodzaj"  class="form-control">
                        <option value="1">Mg</option>
                        <option value="2">Mililitry</option>
                        <option value="3">Ilości</option>
                    </select>
                </div>
                
                
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Cena</span>
                </div>
                <div class="col-md-4 col-xs-4">
                    <input type="text" name="cena"  class="form-control">
                </div>
                
                
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Za ile</span>
                </div>
                <div class="col-md-4 col-xs-4">
                    <input type="text" name="za_ile"  class="form-control">
                </div>
                
                
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Substancje w tym produkcie</span><span class="normalna3">(Jeżeli ten produkt nie ma żadnje substancji niz nie zaznaczaj)</span>
                </div>
                <div class="col-md-7 col-xs-7">
                    @for($i=0;$i < count($substancje);$i++)
                      <input type="checkbox" name="produkty[]" value="{{$substancje[$i]["id"]}}"  /><span class="normalna3">{{$substancje[$i]["nazwa"]}}</span><br />
                    @endfor
                </div>
                
                
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div align="center"><button  class="btn btn-success">Dodaj Produkt</button></div>
                </div>
               
                
                
            </div>            
            
        </form>
        
    </div>
  </div>
                
            </div>
            
        </div>
        
    </div>

@endsection