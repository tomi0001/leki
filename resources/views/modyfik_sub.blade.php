           
      <form action="{{ url("edytuj_sub") }}" method=get>
            <div class="row">
                <div class="col-md-4 col-xs-4">
                    <span class="normalna2">Modyfikuj Substancje w tej grupie</span><span class="normalna3">(Jeżeli ta substancja nie nalezy do grupy niz nie zaznaczaj)</span>
                </div>
                <div class="col-md-7 col-xs-7">
                    @for($i=0;$i < count($grupy);$i++)
                       @if ($grupy[$i]["bool"] == true)
                            <input type="checkbox" name="substancja2[]" value="{{$grupy[$i]["id"]}}" checked/><span class="normalna3">{{$grupy[$i]["nazwa"]}}</span><br />                       
                       @else
                            <input type="checkbox" name="substancja2[]" value="{{$grupy[$i]["id"]}}" /><span class="normalna3">{{$grupy[$i]["nazwa"]}}</span><br />
                       @endif
                    @endfor
                </div>
                
                
            </div>

                <input type="hidden" name="id" value="{{ Input::get('id_sub')}}">

                
 
                
                  <div class="row">
                    <div class="col-md-4 col-xs-4">
                        <span class="normalna2">nazwa</span><span class="normalna3"></span>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <input type="text" name="nowa_nazwa" id="nowa_nazwa" class="form-control" value='{{$nazwa}}'>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-4">
                        <span class="normalna2">Równoważnik</span><span class="normalna3">(W przpadku benzodiazepiny)</span>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <input type="text" name="rownowaznik" id="rownowaznik" class="form-control" value="{{$rownowaznik}}">
                    </div>


                </div>
                 <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div align="center"><button class="btn btn-success">Edytuj</button></div>
                    </div>
                    


                </div>

</form>
<div id="modyfikuj_sub2"></div>
<div id="checkbox_sub">
   

    
</div>
          