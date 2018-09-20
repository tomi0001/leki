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
      <div class="col-md-3 col-xs-3">
	<span class=normalna2>Nazwa produktu</span>
      </div>
      <div class="col-md-5 col-xs-5">
	<input class="form-control" type=text  name=produkt>
      </div>
    </div>
  
    <div class="row">
      <div class="col-md-3 col-xs-3">
	  <span class=normalna2>Nazwa substancji</span>
      </div>
      <div class="col-md-5 col-xs-5">
	<input class="form-control"  type=text name=substancja>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-xs-3">
	  <span class=normalna2>Fraza</span>
      </div>
      <div class="col-md-5 col-xs-5">
	<input class="form-control"  type=text name=fraza>
      </div>
    </div>
    <div class="row">
	<div class="col-md-3 col-xs-3">
	  <span class=normalna2>Nazwa grupy</span>
	</div>
	<div class="col-md-5 col-xs-5">
	  <input class="form-control" type=text  name=grupa>
	</div>
     
  </div>
  <div class="row">
  <div class="col-md-3 col-xs-3">
 <span class=normalna2>Dawka od</span>
  </div>
  <div class="col-md-5 col-xs-5">
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
  <div class="col-md-3 col-xs-3">
 <span class=normalna2>W jednym dniu</span>
  </div>
  <div class="col-md-5 col-xs-5">
    <div class="row">
        <div class="col-md-8 col-xs-8">
	<span class=normalna2> </span><input type="checkbox" name=dzien>
      </div>
    
    </div>
  </div>
 </div> 
     
     
 <div class="row">
  
      
      <div class="col-md-12 col-xs-12 col-md-offset-4 col-xs-offset-4">
          <span class=normalna2></span><input type=button  class="btn btn-success" onclick=wyszukaj('czy_jest2','czy_jest') value="Wyszukaj według opisu">
      </div>
  
  </div>

 <div class="row">
  
      
      <div class="col-md-12 col-xs-12 col-md-offset-4 col-xs-offset-4">
	<span class=normalna2>Zaptanie zaawansowane </span><input type="checkbox" id=opis3>
      </div>
  
  </div>
 
  <div class="row">
    <div class="col-md-3 col-xs-3">
      <span class=normalna2>Dawka do</span>
    </div>
    <div class="col-md-5 col-xs-5">
      <div class="row">
	<div class="col-md-4 col-xs-4">
	  <input class="form-control" type=text name=dawka_do>
	</div>
      
      </div>
    </div>
 </div>
 
 
  <div class="row">
    <div class="col-md-3 col-xs-3">
      <span class=normalna2>Wyszukja według nazwy</span>
    </div>
      <div class="col-md-5 col-xs-5">
	<select class="form-control" name=wedlug>
	<option value=1>Według nazwy</option>
	<option value=2>Według opisu</option>
	</select>
      </div>
  </div>
 
  <div class="row">
    <div class="col-md-3 col-xs-3">
      <span class=normalna2>Wyszukaj Wszystkie pozycje</span>
    </div>
    <div class="col-md-5 col-xs-5">
      <select class="form-control" name=wszystkie>
      <option value=1>Wyszukja wszystkie pozycje</option>
      <option value=2>Wyszukja tylko te, które mają jakiś tekst</option>
      </select>
    </div>
  </div>
 
 
  <div class="row">
    <div class="col-md-3 col-xs-3">
      <span class=normalna2>Data od</span>
    </div>
    <div class="col-md-3 col-xs-3">
      <input type=date class="form-control" name=data_od>
    
    </div>
  </div>
 
 
 
  <div class="row">
    <div class="col-md-3 col-xs-3">
      <span class=normalna2>Data do</span>
    </div>
    <div class="col-md-3 col-xs-3">
      <input type=date class="form-control" name=data_do>
    
    </div>
 </div>
 
 
  <div class="row">
    <div class="col-md-3 col-xs-3">
      <span class=normalna2>Godzina od</span>
    </div>
    <div class="col-md-2 col-xs-2">
      <input type=text class="form-control" name=godzina_od>
    
    </div>
 </div>
 
 
 
  <div class="row">
    <div class="col-md-3 col-xs-3">
      <span class=normalna2>Godzina do</span>
    </div>
    <div class="col-md-2 col-xs-2">
      <input type=text class="form-control" name=godzina_do>
    
    </div>
  </div>
 
  <div class="row">
    <div class="col-md-3 col-xs-3">

    </div>
    <div class="col-md-2 col-xs-2">
    </div>
  
  
  </div>
  <div class="row">
    <div class="col-md-3 col-xs-3">
      <span class=normalna2>Sortuj według</span>
    </div>
    <div class="col-md-2 col-xs-2">
      <select class="form-control" name="sortuj">
      <option value="1">daty</option>
      <option value="2">dawki</option>
      <option value="3">produktu</option>
      <option value="4">godziny</option>
      
      </select>
    
    </div>
  </div>
 
  <div class="row">
    <div class="col-md-3 col-xs-3">

    </div>
    <div class="col-md-2 col-xs-2">
    </div>
  
  
  </div>
  </div>
  
  
  </div>
  
  
  
  
  <div id=czy_jest3>
    <div class=row>
      <div class="col-md-3 col-xs-3">
	<span class=normalna2>Wyszukaj według zapytanie zawansowanego</span>
      </div>
      <div class="col-md-5 col-xs-5">
	<input type=text class="form-control" name=fraza2>
      </div>
    </div>
     <div class="row">
  
      
      <div class="col-md-12 col-xs-12 col-md-offset-4 col-xs-offset-4">
	<span class=normalna2>Wyszukja według zapytanie zaawansowanego  </span><input type="checkbox" id=opis4>
      </div>
  
  </div>
  </div>
  <div class="row">
  

   </div>
  
  
  
  <div id=czy_jest2>
    <div class=row>
      <div class="col-md-3 col-xs-3">
	<span class=normalna2>Wyszukaj według frazy</span>
      </div>
      <div class="col-md-5 col-xs-5">
          <textarea  class="form-control" name=fraza1 cols='20' rows='6'></textarea>
      </div>
    </div>
     <div class="row">
  
      
      <div class="col-md-12 col-xs-12 col-md-offset-4 col-xs-offset-4">
	<span class=normalna2>Wyszukja według leków </span><input type="checkbox" id=opis2>
      </div>
  
  </div>
  </div>
  <div class="row">
  
  <div class="col-md-6 col-md-offset-6">
   <button  value=Szukaj class="btn btn-success">Szukaj</button>
   </div>
   </div>
    

 
 
</form>
    </div>
    </div>
    </div>
@endsection
