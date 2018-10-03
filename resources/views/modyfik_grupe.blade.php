            
            <div class="row">
                 
                    <div class="col-md-4 col-xs-4">
                        <span class="normalna2">Color dla grupy</span><span class="normalna3">(Jeżeli nie chesz koloru pozostaw to pole puste)</span>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <select name="kolor" class="form control">
                            @if ($kolor == "")
                                <option value="" selected>Brak koloru</option>
                            @else
                                <option value="">Brak koloru</option>
                            @endif    
                            @if ($kolor == 3)
                                <option value="3" selected>3</option>
                            @else
                                <option value="3">3</option>
                            @endif
                            @if ($kolor == 4)
                                <option value="4" selected>4</option>
                            @else
                                <option value="4">4</option>
                            @endif
                            @if ($kolor == 5)
                                <option value="5" selected>5</option>
                            @else
                                <option value="5">5</option>
                            @endif
                        </select>
                    </div>


                </div>
                  <div class="row">
                    <div class="col-md-4 col-xs-4">
                        <span class="normalna2">nazwa</span><span class="normalna3"></span>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <input type="text" name="nowa_nazwa" id="nowa_nazwa" class="form-control" value='{{$nazwa}}'>
                    </div>


                </div>
               <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div align="center"><button  class="btn btn-success">Modyfikuj grupę</button></div>
                </div>
               
                
                
                </div>  
