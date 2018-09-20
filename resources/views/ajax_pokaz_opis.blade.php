@for ($i=0;$i < count($opis);$i++)
<br>       
<div class="opis_poka">{{$opis[$i]['opis']}} <br>
    <b>{{$opis[$i]['data']}}</b></div>

    
@endfor
 