@extends('layout.index')
@section('content')
<body onload="ukryj_divy3()">

    <div class="row">
    <div class="col-md-5 col-xs-5">
    </div>
    <div class="col-md-7 col-xs-7">
 

 <div class="row">
  <div class="row">
    <div class="col-md-8">
        <div align="center"><span class="pogrubiona">Modyfikuj grupę</span></div>
        <form action="{{ url("edytuj_grupe2") }}" method="get"> 
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Nazwa grupy</span>
                    
                </div>
                <div class="col-md-6 col-xs-6">
                    <select name="grupy" id="grupy" class="form-control">
                        <option value=""></option>
                        @for ($i=0;$i < count($grupy);$i++)
                        <option value="{{$grupy[$i]["id"]}}">{{$grupy[$i]["nazwa"]}}</option>
                            
                        @endfor
                        
                    </select>
                </div>
             
                
            </div>
            <div class="row">
                <div class="col-md-4 col-xs-4">
               
                </div>
                <div class="col-md-4 col-xs-4">
                    <input type="button" onclick="modyfikuj_grupe('{{ url('edytuj_grupe')}}')" class="btn btn-success" value="zmień">
                </div>
                
                
            </div>
            <div id="modyfikuj_grupa">
            </div>

 
            
            </form>
       
        
    </div>
  </div>
    
   <div class="row">
    <div class="col-md-8">
        <div align="center"><span class="pogrubiona">Modyfikuj substancję</span></div>
        
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Nazwa substancji</span>
                    
                </div>
                <div class="col-md-6 col-xs-6">
                    <select name="substancje" id="substancje" class="form-control">
                        <option value=""></option>
                        @for ($i=0;$i < count($substancje);$i++)
                            <option value="{{$substancje[$i]["id"]}}">{{$substancje[$i]["nazwa"]}}</option>
                        @endfor
                        
                    </select>
                </div>
             
                
            </div>

            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div align="center"><button  class="btn btn-success" onclick = "modyfikuj_substancje('{{ url('modyfikuj_sub')}}')">zmień</button></div>
                </div>
                
                
                
            </div>  
        <div id="modyfikuj_sub">
            
        </div>
        

            
        
        
    </div>
  </div>
     
    <div class="row">
    <div class="col-md-8">
        <div align="center"><span class="pogrubiona">Modyfikuj produkty</span></div>
        
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Nazwa produktu</span>
                    
                </div>
                <div class="col-md-6 col-xs-6">
                    <select name="substancje" id="produkty" class="form-control">
                        <option value=""></option>
                        @for ($i=0;$i < count($produkty);$i++)
                            <option value="{{$produkty[$i]["id"]}}">{{$produkty[$i]["nazwa"]}}</option>
                        @endfor
                        
                    </select>
                </div>
             
                
            </div>


            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div align="center"><button  class="btn btn-success" onclick = "modyfikuj_produkty('{{ url('modyfikuj_pro')}}')">zmień</button></div>
                </div>
                
                
                
            </div>  
        <div id="modyfikuj_pro">
            
        </div>
        

            
        
        
    </div>
  </div>
                
            </div>
            
        </div>
        
    </div>

@endsection