<script>
    $("#sukces").ready(function() {
        
       $("#sukces").hide(4920);
        
        
    });
    
</script>
<div style="overflow-y: scroll;  height:200;">
@for($i = 0;$i < count($ostatni);$i++)
<span class="normalna2">Dawka  = {{$ostatni[$i][0]}}<Br>
Data od {{$ostatni[$i][2]}} - {{$ostatni[$i][1]}}<br>
Ilość dni {{$ilosc_dni[$i]}}</span>
<br><br>
@endfor
</div>