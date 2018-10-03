

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
   //$("#srednia" + i).toogle();
   //if ($("#srednia" + i).is(":visible")  ){
        $("#srednia" + i).load(url + "/" + id);  
        $("#srednia" + i).toggle();  
   //}
   //else {
     //  $("#srednia" + i).hide();
   //} 
    
    
}

function ukryj_pola_tekstowe() {
    
    
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
function usun_wpis(url,i,id) {
     var bool = confirm("Czy na pewno usunąć");
     if (bool == true) {
        $("#lek"+i).load(url + "/" + id);
        //$("#lek"+i).hide(700);
     }
     //else alert("zle");
    
    
    
}

function modyfikuj_grupe(url) {
    //alert(nazwa);
    if ($("#grupy").val() == "") alert("wybierz grupę");
    else {
        $("#modyfikuj_grupa").show();
        
        $("#modyfikuj_grupa").load(url + "?" + "id_grupy=" + $("#grupy").val());  
        //$("#modyfikuj_grupa").text(url);
    }   
 
    
}
function przelicz(url,rownowaznik) {
    $("#rownowaznik2").load(url + "?id=" + $("#rownowaznik").val() + "&rownowaznik=" + rownowaznik);
    
}

function ukryj_divy(count) {
  
  for (var i=0;i <= count;i++) {
    $("#opis_"+i).hide();
    $("#pokaz_opis__"+i).hide();
    $("#edit_post_"+i).hide();
    $("#dodaj_opis_"+i).hide();
    $("#srednia"+i).hide();
    //$("#pokaz_opis_"+i).hide();
  }
  
}

function modyfikuj_substancje(url) {
    if ($("#substancje").val() == "") alert("wybierz substancję");
    else {
        $("#modyfikuj_sub").show();
        $("#modyfikuj_sub").load(url + "?" + "id_sub=" + $("#substancje").val());       
    }
}

function modyfikuj_produkty(url) {
    if ($("#produkty").val() == "") alert("wybierz produkt");
    else {
        $("#modyfikuj_pro").show();
        $("#modyfikuj_pro").load(url + "?" + "id_pro=" + $("#produkty").val());
    }
}


function modyfikuj_substancje2(url) {
    //$("#modyfikuj_sub").show();
    //alert(url + "?" + "id_sub=" + $("#substancje").val());
   // $("#modyfikuj_sub2").load(url + "?" + "id_sub=" + $("#substancje").val());
   //var tablica = dd($("#substancje2").val());
    //alert(tablica);
    
}

function ukryj_divy3() {
    
    $("#modyfikuj_grupa").hide();
    $("#modyfikuj_sub").hide();
    
    
}
function ukryj_divy2() {
    //alert("dowb");
  //$('#gru').disabled(true);
   //gru.disabled = false;
   //if ($("#gru") == "" and $("#pro") == "" and $("#sub") == "") {
   //$("#gru").prop('disabled', true);
     //  }
   if ($("#gru") != "") {
       //$("#sub").prop('disabled', true);
       //$("#pro").prop('disabled', true);
    }
  
}

$('#pro').on('keydown', function () {
    if ($('#pro').val() != "") {
        $("#sub").prop('disabled', true);
        //alert($('#pro').val());
        $("#gru").prop('disabled', true);
        //$("#sub").prop('disabled', true);
        
    }
    else {
        $("#sub").prop('disabled', false);
        $("#gru").prop('disabled', false);
    }
});
$('#sub').on('keydown', function () {
    if ($('#sub').val() != "") {
        $("#pro").prop('disabled', true);
        //alert($('#pro').val());
        $("#gru").prop('disabled', true);
        //$("#sub").prop('disabled', true);
        
    }
    else {
        $("#pro").prop('disabled', false);
        $("#gru").prop('disabled', false);
    }
});
$('#gru').on('keydown', function () {
    if ($('#gru').val() != "") {
        $("#sub").prop('disabled', true);
        //alert($('#pro').val());
        $("#pro").prop('disabled', true);
        //$("#sub").prop('disabled', true);
        
    }
    else {
        $("#sub").prop('disabled', false);
        $("#pro").prop('disabled', false);
    }
});

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