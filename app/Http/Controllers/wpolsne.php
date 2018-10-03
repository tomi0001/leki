<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Input;
use Auth;
use Hash;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class wpolsne extends BaseController
{
    
    public $suma_substancji;
    public $rownowaznik;
    public $rodzaj_rowno;
    public function sprawdz_czy_jest_opis($id) {
        
        $sprawdz = DB::select("select id_spozycia from przekierowanie_opis where id_spozycia = '$id'");
        foreach ($sprawdz as $sprawdz2) {
            
            if ($sprawdz2->id_spozycia != "") return true;
        }
        
        return false;
    }
    
    public function zwroc_kolor_dla_grupy($id_produktu,$bool = false) {
            $kolor3 = "";
            $id_substancji = DB::select("select id_substancji from przekierowanie_substancji where id_produktu = '$id_produktu'");
            foreach ($id_substancji as $id_substancji2) {
                $id_grupy = DB::select("select id_grupy from przekierowanie_grup where id_substancji = '$id_substancji2->id_substancji'");
                foreach ($id_grupy as $id_grupy2) {
                    $kolor = DB::select("select color from grupy where id = '$id_grupy2->id_grupy'");
                    foreach ($kolor as $kolor2) {

                        if ($kolor2->color != "" ) {
                            $kolor3 =  $kolor2->color;

                        }
                    }
                    
                }
            }
           
                            if ($bool == false) $kolor3 = "lek2" . $kolor3;
                            return $kolor3;

            if ($bool == false) $kolor3 = "lek2" . $kolor3;
            
            return  $kolor3;    

    }
    public function wybierz_kolor($id_users,$data1,$data2) {
        $dane_spozycie3 = array();
        $i = 0;
        $kolor = 0;
        $kolor2 = 0;
        $kolor3 = 0;
        $glowny_kolor = 0;
        $dane_spozycie = DB::select("select porcja,data,id_produktu,cena,spozycie.id  as id2 from spozycie  "                  
                . "where data >= '$data1' and data <= '$data2' and id_users = '$id_users' order by data");
        foreach($dane_spozycie as $dane_spozycie2) {
            
            $dane_spozycie3[$i]["color"] = $this->zwroc_kolor_dla_grupy($dane_spozycie2->id_produktu,true);
            
            if ($dane_spozycie3[$i]["color"] == 3) $kolor  = 3;
            if ($dane_spozycie3[$i]["color"] == 4) $kolor2 = 4;
            if ($dane_spozycie3[$i]["color"] == 5) $kolor3 = 5;
            $i++;
        }
        if ($i == 0) $glowny_kolor = "komorka2";
        elseif ($kolor == 3 and $kolor2 != 4 and $kolor3 != 5) $glowny_kolor = "komorka03";
        elseif ($kolor != 3 and $kolor2 == 4 and $kolor3 != 5) $glowny_kolor = "komorka04";
        elseif ($kolor != 3 and $kolor2 != 4 and $kolor3 == 5) $glowny_kolor = "komorka05";
        elseif ($kolor == 3 and $kolor2 == 4 and $kolor3 != 5) $glowny_kolor = "komorka06";
        elseif ($kolor == 3 and $kolor2 != 4 and $kolor3 == 5) $glowny_kolor = "komorka07";
        elseif ($kolor != 3 and $kolor2 == 4 and $kolor3 == 5) $glowny_kolor = "komorka08";
        elseif ($kolor == 3 and $kolor2 == 4 and $kolor3 == 5) $glowny_kolor = "komorka010";
        else $glowny_kolor = "komorka011";
        
         return $glowny_kolor;
        
        
    }
    public function wybierz_spozycie($id_users,$data1,$data2) {
        $dane_spozycie3 = array();
        $i = 0;
        $kolor = 0;
        $kolor2 = 0;
        $kolor3 = 0;
        $glowny_kolor = 0;

        $dane_spozycie = DB::select("select porcja,data,id_produktu,cena,spozycie.id  as id2 from spozycie  "                  
                . "where data >= '$data1' and data <= '$data2' and id_users = '$id_users' order by data");
        foreach($dane_spozycie as $dane_spozycie2) {
            $dane_spozycie3[$i]["porcja"] = $dane_spozycie2->porcja;
            $dane_spozycie3[$i]["przekierowanie"] = $this->sprawdz_czy_jest_opis($dane_spozycie2->id2);
            $dane_spozycie3[$i]["data"]   = $dane_spozycie2->data;
            $dane_spozycie3[$i]["cena"] =  $this->oblicz_cene($dane_spozycie2->cena);
            $tym = $this->wybierz_nazwe_produktu($dane_spozycie2->id_produktu);
            $dane_spozycie3[$i]["nazwa"] = $tym[0];
            $dane_spozycie3[$i]["nazwa_substancji"] = $tym[5];
            $dane_spozycie3[$i]["id"] = $dane_spozycie2->id2;
            $dane_spozycie3[$i]["color"] = $this->zwroc_kolor_dla_grupy($dane_spozycie2->id_produktu);
            $dane_spozycie3[$i]["rodzaj"] = $this->zwroc_rodzaj($dane_spozycie2->id_produktu);

            $i++;
        }
        return $dane_spozycie3;
    }
    
    public function zwroc_rodzaj($id_produktu) {
        $rodzaj = DB::select("select spozycie.id_produktu,produkty.rodzaj_porcji as rodzaj_porcji from spozycie join produkty on produkty.id = spozycie.id_produktu where spozycie.id_produktu = '$id_produktu'");
        foreach ($rodzaj as $rodzaj2) {
            $rodzaj3 = $rodzaj2->rodzaj_porcji;
        }
        switch($rodzaj3) {
          case '1':return  "mg";
              break;
          case '2':return  "mililitry";
              break;
          case '3':return  "ilośći";
              break;
          default:return  "mg";
              break;

      }
        
        
        
    }
    
    private function zwroc_id_substancji($id_produktu) {
        $id = DB::select("select id_substancji from przekierowanie_substancji where id_produktu = '$id_produktu'");
        
        
    }
    
    public function ustal_poczatek_dnia($styl = false) {
        $id_users = Auth::User()->id;
        $poczatek = DB::select("select poczatek_dnia from users where id = '$id_users'");
        foreach ($poczatek as $poczatek2) {
            if ($styl == false) {
                if (strlen($poczatek2->poczatek_dnia) == 1)
                   return " 0" . $poczatek2->poczatek_dnia . ":00:00";
               else 
                   return " " . $poczatek2->poczatek_dnia . ":00:00";

            }
            else {
              return $poczatek2->poczatek_dnia;


            }
        }
      }
    public function oblicz_dzien($data,$bool = false) {
        
        if ($bool == false) {
            
            return $data;
        }
        else {

            $data1 = explode(" ",$data);
            $data2 = explode("-",$data1[0]);
            $data3 = explode(":",$data1[1]);
        
            $new_data  = mktime($data3[0],$data3[1],$data3[2],$data2[1],$data2[2],$data2[0]);
            $new_data += (3600 * 24);
            $data_nowa = date("Y-m-d H:i:s",$new_data);
            return $data_nowa;
        }
        
    }
    
    private function wybierz_nazwe_produktu($id_produktu) {
        
        $nazwa = DB::select("select nazwa,id_substancji,ile_procent,rodzaj_porcji,cena,za_ile,id from produkty where id = '$id_produktu'");
        foreach ($nazwa as $nazwa2) {
            $nazwa_substancji = $this->wybierz_nazwe_substancji($nazwa2->id);

            return array($nazwa2->nazwa,$nazwa2->ile_procent,$nazwa2->rodzaj_porcji,$nazwa2->cena,$nazwa2->za_ile,$nazwa_substancji);
        }
        
        
    }
    
    private function oblicz_rownowaznik($dawka,$rownowaznik_x,$rodzaj_diazepiny) {
         return ($dawka / $rownowaznik_x) * $rodzaj_diazepiny;
        
    }
     public function oblicz_cene($liczba) {
    
      $liczba = round($liczba,2);
    
      if ( !strstr($liczba,".") ) {
	
	return $liczba . " zł";
      }
      else {
      

	$liczba2 = explode(".",$liczba);
	$liczba3 = strlen($liczba2[1]);
	if ($liczba3 == 1) {
	  $liczba2[1] .= "0";
	}
	if ( $liczba2[0][0] == 0) {
	  return $liczba2[1] . " gr";
	}
	else {
	  return $liczba2[0] . " zł i " . $liczba2[1] . " gr";
	}
      }
    
    
    
    }
    
    
    public function oblicz_za_ile($dawka,$za_ile,$cena) {
        return ($dawka / $za_ile) * $cena;

    }
    
    public function wybierz_nazwe_substancji($id_produktu) {
        $nazwa3 = "";
        $i = 0;

        $nazwa = DB::select("select id_substancji from przekierowanie_substancji where id_produktu = '$id_produktu'");
        foreach ($nazwa as $nazwa2) {
            $tym = $nazwa2->id_substancji;
            $substancja = DB::select("select nazwa from substancje where id = '$tym' ");
            foreach ($substancja as $substancja2){
                $nazwa3 .= $substancja2->nazwa . ", ";
            }
            $i++;
        }
        
        return $nazwa3;
    }
  

    
    
    public function wybierz_sume_substancji_dla_dnia($dzien,$id_users) {
        $poczatek_dnia = $this->ustal_poczatek_dnia();
        $data1 = $dzien . $poczatek_dnia;
        $dzien2 = explode("-",$dzien);
        $data2 = mktime("00","00","00",$dzien2[1],$dzien2[2],$dzien2[0]);
        $data2 += 86400;
        $data3 = date("Y-m-d",$data2) . $poczatek_dnia;
        
        $substancje =  DB::select ("select sum(spozycie.porcja)  as porcja ,produkty.rodzaj_porcji as rodzaj,spozycie.id_produktu as nazwas,"
                . "produkty.id  as id_produktu,substancje.rownowaznik as rownowaznik from spozycie  join produkty on spozycie.id_produktu "
                . "= produkty.id  left join przekierowanie_substancji on przekierowanie_substancji.id_produktu = produkty.id "
                . "join substancje on substancje.id = przekierowanie_substancji.id_substancji "
                . "where   data >= '$data1' and data <= '$data3' group by spozycie.id_produktu order by spozycie.id_produktu");
        $substancje3 = array();
        $i = 0;
        $alkohol = false;
        $rownowaznik = 0;
        foreach ($substancje as $substancje2) {
            $wybierz_nazwe_produktu = DB::select("select nazwa from produkty where id = " . $substancje2->nazwas .  "");
            foreach ($wybierz_nazwe_produktu as $wybierz_nazwe_produktu2) {}
            $substancje3[$i]['nazwa'] = $wybierz_nazwe_produktu2->nazwa;
            $substancje3[$i]['porcja'] = $substancje2->porcja;
            if ($substancje2->rownowaznik != "") {
                $rownowaznik += $this->oblicz_rownowaznik($substancje2->porcja,$substancje2->rownowaznik,10);
                
            }
            switch ($substancje2->rodzaj) {
               case 1: 
                   $substancje3[$i]['rodzaj'] = "mg";
                   break;
               case 2: 
                   $substancje3[$i]['rodzaj'] = "mililitrow";
                   $alkohol = true;
                   break;
               case 3: 
                   $substancje3[$i]['rodzaj'] = "ilości";
                   break;
               default: 
                   $substancje3[$i]['rodzaj'] = "mg";
                   break;
            }
            
            $i++;
            
        }
        if ($alkohol == true) {
            $alkohol2 = $this->oblicz_alkohol($data1,$data3);
            $substancje3[$i]["nazwa"] = "alkohol";
            $substancje3[$i]["porcja"] = $alkohol2;
            $substancje3[$i]["rodzaj"] = "mililitry";
        }
        $this->suma_substancji = $substancje3;
        $this->rownowaznik  = $rownowaznik;
        
        
    }
    
    public function przelicz_rownowaznik($porcja,$id_benzo) {
        $id_users = Auth::User()->id;
        $wybierz_rownowaznik_benzo = DB::select("select rownowaznik from substancje where id_users = '$id_users' and id = '$id_benzo'");
        foreach ($wybierz_rownowaznik_benzo as $wybierz_rownowaznik_benzo2) {
            $dawka_koncowa = $this->oblicz_rownowaznik($porcja,10,$wybierz_rownowaznik_benzo2->rownowaznik);
            return $dawka_koncowa;
            
        }
        
        
    }
    private  function oblicz_ilosc_wypitego_alkoholu($porcja,$procent) {
        return ($procent / 100) * $porcja;
        
    }
    private function oblicz_alkohol($data1,$data3) {
        $alkohol = DB::select("select spozycie.porcja as porcja,produkty.rodzaj_porcji as rodzaj_porcji,produkty.ile_procent as ile_procent from spozycie  join produkty on spozycie.id_produktu = produkty.id "
                . "where data < '$data3' and data >= '$data1' and rodzaj_porcji = '2'");
        $alkohol3 = 0;
        foreach ($alkohol as $alkohol2) {
            $dawka = $this->oblicz_ilosc_wypitego_alkoholu($alkohol2->porcja,$alkohol2->ile_procent);
            $alkohol3 += $dawka;
        }
        return $alkohol3;
    }
    
    
    private   function oblicz_procent($porcja,$ile_procent) {
    
    $wynik = $ile_procent / 100 ;
    return $wynik * $porcja;
    
  }
    
     public function charset_utf_fix($string) {
 
	$utf = array(
	 "%u0104" => "Ą",
	 "%u0106" => "Ć",
	 "%u0118" => "Ę",
	 "%u0141" => "Ł",
	 "%u0143" => "Ń",
	 "%u00D3" => "Ó",
	 "%u015A" => "Ś",
	 "%u0179" => "Ź",
	 "%u017B" => "Ż",
	 "%u0105" => "ą",
	 "%u0107" => "ć",
	 "%u0119" => "ę",
	 "%u0142" => "ł",
	 "%u0144" => "ń",
	 "%u00F3" => "ó",
	 "%u015B" => "ś",
	 "%u017A" => "ź",
	 "%u017C" => "ż",
             "&nbsp" => " "
	);
	
	return str_replace(array_keys($utf), array_values($utf), $string);
	
    }
    
    
    public function wybierz_id_produktu($nazwa) {
        
        $id = DB::select("select id from produkty where nazwa = '$nazwa'");
        foreach ($id as $id2) {
            
            if ($id2->id != "") return $id2->id;
        }
        return false;
    }
    public function wybierz_id_produktu_data($id_spozy) {
        
        $id_pro_data = DB::select("select data,id_produktu from spozycie where id = '$id_spozy'");
        foreach ($id_pro_data as $id_pro_data2) {
            if ($id_pro_data2->id_produktu != "") return array($id_pro_data2->id_produktu,$id_pro_data2->data);
            
        }
        return false;
        
    }
    public function charset_utf_fix2($string) {
 
	$utf = array(
	   "Ą" => "%u0104",
	   "Ć" => "%u0106",
	   "Ę"=>"%u0118" ,
	   "Ł"=>"%u0141",
	   "Ń"=>"%u0143",
	   "Ó"=>"%u00D3",
	   "Ś"=>"%u015A",
	   "Ź"=>"%u0179",
	   "Ż"=>"%u017B",
	   "ą"=>"%u0105",
	   "ć"=>"%u0107",
	   "ę"=>"%u0119",
	   "ł"=>"%u0142",
	   "ń"=>"%u0144",
	   "ó"=>"%u00F3",
	   "ś"=>"%u015B",
	   "ź"=>"%u017A",
	   "ż"=>"%u017C",
            " " => "&nbsp"
	);
	
	return str_replace(array_keys($utf), array_values($utf), $string);
	
    }
    public function usun_puste_wartosci($tablica) {
        $nowa_tablica = array();
        $j = 0;
        for ($i=0;$i< count($tablica);$i++) {
            if($tablica[$i]==''){
               continue;
            }
            else{
                $nowa_tablica[$j] = $tablica[$i];
                $j++;
            }
        }
        return $nowa_tablica;
    }
    
     public function wybierz_produkty($id_users)   {
         $produkty3 = array();
         $produkty = DB::select("select nazwa,id from produkty where id_users = '$id_users'");
         $i = 0;
         foreach ($produkty as $produkty2) {
             $produkty3[$i]['nazwa'] = $produkty2->nazwa;
             $produkty3[$i]['id']    = $produkty2->id;
             $i++;
         }
         
         
         return $produkty3;
    }
    
}
  



?>