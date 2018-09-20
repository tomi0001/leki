<?php
  $baza  = new mysqli("localhost","root","a1234","leki2");
  
  $baza2 = new mysqli("localhost","root","a1234","uzywki");
  
  
  
  $zap = $baza2->query("select porcja,data,opis_spozycia,rodzaj_porcji,id_substancji,id from spozycie where data > '2018-03-16 07:29:00'");
  while ($zap2 = mysqli_fetch_array($zap) ) {
    print $zap2[0] . $zap2[1] . $zap2[2] . $zap2[3] . $zap2[4] .  "<br>" .  $zap2[5] .  "<br>";
    
    if ($zap2[2] != "") {
      $baza->query("insert into opis(data,opis,id_users) values('$zap2[1]','$zap2[2]','38')");
      $id_wpisu = $baza->query("select id from opis order by id DESC limit 1");
      while ($id_wpisu2 = mysqli_fetch_array($id_wpisu) ) {
	$baza->query("insert into przekierowanie_opis(id_spozycia,id_opisu) values('$zap2[5]','$id_wpisu2[0]')");
      }
    }
    $zap3 = $baza2->query("select cena from substancje where id = '$zap2[4]'");
    while( $zap4 =  mysqli_fetch_array($zap3)) {}
    $baza->query("insert into spozycie(id,porcja,id_users,data,id_produktu,cena) values('$zap2[5]','$zap2[0]','38','$zap2[1]','$zap2[4]','$zap4[0]')");
    
  }
  sd
  //
  
  
  
  
?>