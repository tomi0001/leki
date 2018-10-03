@extends('layout.index')
@section('content')
<div class="row">
    <div class="col-md-4">
        
    </div>
  <div class="row">
    <div class="col-md-5">
    

`       <div class="lek3">
            <div align="center" class='tytul'>
                LOGOWANIE
            </div>
            <br><br>
            <form action={{ url('logowanie') }} method="post">
            <div class="row">
                <div class="col-md-2">
                    
                    
                </div>
                
                <div class="col-md-4">
                    
                    <span class="pogrubiona">Twój login </span>
                </div>
                <div class="col-md-4">
                    
                    <input type="text" name="name" class="form-control" >
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
                    

                
                <div class="col-md-12">
                    
                    <div align="center"><button  class="btn btn-success">Zaloguj się</button></div>
                </div>    
               
                      
            </div>    
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
            <div class="row">
                
                <div align="center"><span class="blad">{{Session::get('login_error')}}</span></div>
                <div align="center"><span class="succes3">{{Session::get('login_sukces')}}</span></div>
                
            </div>
        </div>
    </div>
  </div>
</div>
@endsection

