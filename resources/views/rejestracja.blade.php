@extends('layout.index')
@section('content')
 <div class="row">
    <div class="col-md-4">
        
    </div>
  <div class="row">
    <div class="col-md-5">
    

`       <div class="lek3">
            <div align="center" class='tytul'>
                REJESTRACJA
            </div>
            <br><br>
            <form action={{ url('zarejestruj') }} method="post">
            <div class="row">
                <div class="col-md-2">
                    
                    
                </div>
                
                <div class="col-md-4">
                    
                    <span class="pogrubiona">Twój login </span>
                </div>
                <div class="col-md-4">
                    
                    <input type="text" name="login" class="form-control" >
                </div>      
                
            </div>
            <div class="row">
                <div class="col-md-2">
                    
                    
                </div>
                
                <div class="col-md-4">
                    
                    <span class="pogrubiona">Twoje Hasło </span>
                </div>    
                <div class="col-md-4">
                    
                    <input type="password" name="haslo" class="form-control"  >
                </div>      
                      
            </div>
            <div class="row">
                <div class="col-md-2">
                    
                    
                </div>
                
                <div class="col-md-4">
                    
                    <span class="pogrubiona">Wpisz jeszcze raz swoje Hasło </span>
                </div>    
                <div class="col-md-4">
                    
                    <input type="password" name="haslo2" class="form-control"  >
                </div>      
                      
            </div>
            <div class="row">
                <div class="col-md-2">
                    
                    
                </div>
                
                <div class="col-md-4">
                    
                    <span class="pogrubiona">Początek dnia </span>
                </div>    
                <div class="col-md-4">
                    
                    <input type="text" name="dzien" class="form-control"  >
                </div>      
                      
            </div>
             <div class="row">
                    

                
                <div class="col-md-12">
                    
                    <div align="center"><button  class="btn btn-success">Zarejestruj się</button></div>
                </div>    
               
                      
            </div>    
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
            <div class="row">
                
                <div class="row">
                    <div align=center>
    <div class="col-md-12 col-xs-12">
    
 <?php $messages = $errors->all(':message') ?>
      <?php foreach ($messages as $msg): ?>
         <span class=blad><?= $msg ?> <br></span>
      <?php endforeach; ?>
      <span class=blad>{{Session::get('ile')}}</span>
      <span class=blad>{{Session::get('dzien')}}</span>
</form>

    </div>
    </div>
                
            </div>
        </div>
    </div>
  </div>
</div>
@endsection


