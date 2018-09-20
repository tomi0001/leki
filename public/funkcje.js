

function dodaj_wpis(url) {
    var dawka = $("#dawka").val();
    var produkt = $("#produkt").val();
    var data = $("#data").val();
    var czas = $("#czas").val();
    var opis = $("#opis").val();
    $("#dodaj_wpis").load(url + "?produkt=" + produkt + "&opis=" + opis + "&dawka=" + dawka + "&data=" + data + "&czas=" + czas);
    
    
}

function zniszcz() {
    //alert("d");
    $("#sukces").hide(120);   
    
    
}
$('#menu3').click(function() {
    
  $('.menu3').slideToggle();
    
});
$('.menu3').hide();


$('option').mousedown(function(e) {
    e.preventDefault();
    var originalScrollTop = $(this).parent().scrollTop();
    console.log(originalScrollTop);
    $(this).prop('selected', $(this).prop('selected') ? false : true);
    var self = this;
    $(this).parent().focus();
    setTimeout(function() {
        $(self).parent().scrollTop(originalScrollTop);
    }, 0);
    
    return false;
});

function oblicz_srednia(url,id,i) {
   
  //var produkt1 = $("#data").val();
  //var produkt2 = $("#produkt2").val();
  //var dawka = $("#dawka").val();
  //var data = $("#data").val();
  //var nazwa = $("#nazwa").val();
  //$("#srednia" + i).hide();
   $("#srednia" + i).load(url + "/" + id);  
    
    
    
}

function dodaj_lek(url) {
//   alert("dobrze");
  var produkt1 = $("#produkt1").val();
  var produkt2 = $("#produkt2").val();
  var dawka = $("#dawka").val();
  var data = $("#data").val();
  var czas = $("#czas").val();
   $("#dodaj_lek").load(url + "?produkt1=" + produkt1 + "&produkt2=" + produkt2 + "&dawka=" + dawka + "&data=" + data + "&czas=" + czas);
    
}
function dodaj_opis3(url,i,id) {
    
    
    var opis = escape($("#opis"+i).val());
    //alert(opis);
    //var id_spoz = $("#opis"+i).val();
    $("#dodaj_opis2_"+i).load(url + "?opis=" + opis + "&id=" + id);
    
    
}
function dodaj_opis(i) {
  
  //alert("w");
  $("#dodaj_opis_"+i).toggle(120);
  
}
function oblicz_srednia22(url,id,i) {
  
  var status = $("#srednia_"+i).val();
  var godzina_a = $("#godzina_a"+i).val();
  alert(status);
  var godzina_b = $("#godzina_b"+i).val();
  //alert(godzina_b);
  url2 = url + "?id=" + id + "&status=" + status +  "&godzina_a=" + godzina_a + "&godzina_b=" + godzina_b;
 window.open(url2);
  
}
function edytuj_opis(url,id,i) {
  //alert("dobrze");
 $("#edit_post_"+i).toggle();
 $("#edit_post_"+i).load(url + "?id=" + id);
 
}

function ukryj_divy(count) {
  
  for (var i=0;i <= count;i++) {
    $("#opis_"+i).hide();
    $("#pokaz_opis__"+i).hide();
    $("#edit_post_"+i).hide();
    $("#dodaj_opis_"+i).hide();
    //$("#pokaz_opis_"+i).hide();
  }
  
}
function ukryj_divy2() {
  $("#czy_jest2").hide();
  $("#czy_jest3").hide();
}

$("#opis").change(function(){
  
        if($( "input:checked" ).length>0){
	  $("#czy_jest").hide();
	  $("#czy_jest2").show();
	  $("#czy_jest3").hide();
          //  $("#czy_opis").html(" ");
        }else{
          $("#czy_jest2").hide(); 
	  $("#czy_jest").show();
	  $("#czy_jest3").hide();
        }
    });
$("#opis2").change(function(){
  
        if($( "input:checked" ).length>0){
	  $("#czy_jest2").hide();
	  
	  $("#czy_jest").show();
	  $("#czy_jest3").hide();
          //  $("#czy_opis").html(" ");
        }else{
          $("#czy_jest").hide(); 
	  $("#czy_jest2").show();
	  $("#czy_jest3").hide();
        }
    });
$("#opis3").change(function(){
  alert("dobrze");
        if($( "input:checked" ).length>0){
	  $("#czy_jest2").hide();
	  $("#czy_jest").hide();
	  $("#czy_jest3").show();
          //  $("#czy_opis").html(" ");
        }else{
          $("#czy_jest").hide(); 
	  $("#czy_jest2").show();
	  $("#czy_jest3").hide();
        }
    });
$("#opis4").change(function(){
  
        if($( "input:checked" ).length>0){
	  $("#czy_jest2").hide();
	  $("#czy_jest").show();
	  $("#czy_jest3").hide();
          //  $("#czy_opis").html(" ");
        }else{
          $("#czy_jest").hide(); 
	  $("#czy_jest2").show();
	  $("#czy_jest3").show();
        }
    });
function pokaz_opis(url,id,i) {
  //alert(url);
  //alert('dobrze');
  $("#pokaz_opis__"+i).toggle();
  $('#pokaz_opis__'+i).load(url+"?id=" + id);
  
}
function dodaj_opis2(url,id,i) {
  var id2 = $("#opis_"+i).val();
  var opis = $("#opis2_"+i).val();
  opis = escape(opis);
 $("#pokaz_opis_"+i).load(url+ "?id="+id + "&opis=" + opis);
  
  
}

function wyszukaj(id,id2) {
    //alert(id);
    $("#" + id).show();
    $("#" + id2).hide();
    
}