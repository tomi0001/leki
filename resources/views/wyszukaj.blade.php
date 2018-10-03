@extends('layout.index')
@section('content')

    <div class="row">
    <div class="col-md-4 col-xs-4">
    </div>
    <div class="col-md-8 col-xs-8">
        <body onload=ukryj_divy2()>

<form method=get action={{url('wyszukaj2')}}>
 <div id=czy_jest>
    <div class="row">
      <div class="col-md-3 col-xs-4">
	<span class=normalna2>Nazwa produktu</span>
      </div>
      <div class="col-md-5 col-xs-6">
	<input class="form-control" type=text  name=produkt id="pro">
      </div>
    </div>
  
    <div class="row">
      <div class="col-md-3 col-xs-4">
	  <span class=normalna2>Nazwa substancji</span>
      </div>
      <div class="col-md-5 col-xs-6">
	<input class="form-control"  type=text name=substancja id="sub">
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-xs-4">
	  <span class=normalna2>Fraza</span>
      </div>
      <div class="col-md-5 col-xs-6">
	<input class="form-control"  type=text name=fraza>
      </div>
    </div>
    <div class="row">
	<div class="col-md-3 col-xs-4">
	  <span class=normalna2>Nazwa grupy</span>
	</div>
	<div class="col-md-5 col-xs-6">
	  <input class="form-control" type=text  name=grupa id="gru">
	</div>
     
  </div>
  <div class="row">
  <div class="col-md-3 col-xs-4">
 <span class=normalna2>Dawka od</span>
  </div>
  <div class="col-md-5 col-xs-6">
    <div class="row">
      <div class="col-md-4 col-xs-4">
	<input class="form-control" type=text name=dawka_od>
      </div>
      <div class="col-md-8 col-xs-8">
	<span class=normalna2>Dawka dobowa </span><input type="checkbox" name=dobowa>
      </div>
    </div>
  </div>
 </div>
<div class="row">
  <div class="col-md-3 col-xs-4">
 <span class=normalna2>W jednym dniu</span>
  </div>
  <div class="col-md-5 col-xs-6">
    <div class="row">
        <div class="col-md-8 col-xs-8">
	<span class=normalna2> </span><input type="checkbox" name=dzien>
      </div>
    
    </div>
  </div>
 </div> 
     
     
 

 
 
  <div class="row">
    <div class="col-md-3 col-xs-4">
      <span class=normalna2>Dawka do</span>
    </div>
    <div class="col-md-5 col-xs-6">
      <div class="row">
	<div class="col-md-4 col-xs-4">
	  <input class="form-control" type=text name=dawka_do>
	</div>
      
      </div>
    </div>
 </div>
 
 

 
  <div class="row">
    <div class="col-md-3 col-xs-4">
      <span class=normalna2>Wyszukaj Wszystkie pozycje</span>
    </div>
    <div class="col-md-5 col-xs-6">
      <select class="form-control" name=wszystkie>
      <option value=1>Wyszukja wszystkie pozycje</option>
      <option value=2>Wyszukja tylko te, które mają jakiś tekst</option>
      </select>
    </div>
  </div>
 
 
  <div class="row">
    <div class="col-md-3 col-xs-4">
      <span class=normalna2>Data od</span>
    </div>
    <div class="col-md-3 col-xs-5">
      <input type=date class="form-control" name=data_od>
    
    </div>
  </div>
 
 
 
  <div class="row">
    <div class="col-md-3 col-xs-4">
      <span class=normalna2>Data do</span>
    </div>
    <div class="col-md-3 col-xs-5">
      <input type=date class="form-control" name=data_do>
    
    </div>
 </div>
 
 
  <div class="row">
    <div class="col-md-3 col-xs-4">
      <span class=normalna2>Godzina od</span>
    </div>
    <div class="col-md-2 col-xs-3">
      <input type=text class="form-control" name=godzina_od>
    
    </div>
 </div>
 
 
 
  <div class="row">
    <div class="col-md-3 col-xs-4">
      <span class=normalna2>Godzina do</span>
    </div>
    <div class="col-md-2 col-xs-3">
      <input type=text class="form-control" name=godzina_do>
    
    </div>
  </div>
 
  <div class="row">
    <div class="col-md-3 col-xs-4">

    </div>
    <div class="col-md-2 col-xs-3">
    </div>
  
  
  </div>
  <div class="row">
    <div class="col-md-3 col-xs-4">
      <span class=normalna2>Sortuj według</span>
    </div>
    <div class="col-md-2 col-xs-3">
      <select class="form-control" name="sortuj">
      <option value="1">daty</option>
      <option value="2">dawki</option>
      <option value="3">produktu</option>
      <option value="4">godziny</option>
      
      </select>
    
    </div>
  </div>
 <div class="col-md-2 col-xs-0">
  <div class="row">
    <div class="col-md-3 col-xs-0">

    </div>
    <div class="col-md-2 col-xs-0">
    </div>
  
  
  </div>
 </div>
  </div>
  
  
  </div>
  
  
  

  
  
  
<div class="col-md-4 col-xs-0">
</div>
        
   <div class="col-md-4 col-xs-4">`
  <div class="row">
  
  <div class="col-md-6 col-md-offset-6">
   <button  value=Szukaj class="btn btn-success">Szukaj</button>
   </div>
   </div>
    

</div>
    </div>
</form>
    </div>
    </div>
    </div>
@endsection
