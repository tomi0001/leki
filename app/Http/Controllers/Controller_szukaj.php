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
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class Controller_szukaj extends BaseController
{

    public $dawka_od;
    public $dawka_do;
    public $wedlug;
    public $wszystkie;
    public $data_od;
    public $data_do;
    public $godzina_od;
    public $godzina_do;
    public $sortuj;
    public $dzien;
    public $fraza;
    public $strona;
    public $zapytanie;
    public $paginacja;
    private $join;
    private $porcja;
    private $produkty;
    private $where;
    private $group;
    private $having;
    private $sortuj2;
    private $limit;
    
    public function oblicz_srednia($id) {
        $wspolne = new \App\Http\Controllers\wpolsne();
        $id_pro_data = $wspolne->wybierz_id_produktu_data($id);
        $ostatni = $this->wskaz_ostatni_rekord($id_pro_data[1],$id_pro_data[0]);
        $tablica = array();
        for ($i=0;$i < count($ostatni);$i++) {
            $tablica[$i]  = $this->oblicz_roznice_w_dniach($ostatni[$i][1],$ostatni[$i][2]);
            
        }
        
        return View("ajax_pokaz_ostatni")->with("ostatni",$ostatni)->with("ilosc_dni",$tablica);
    }
    private function oblicz_roznice_w_dniach($data1,$data2) {
        
        $data11 = StrToTime($data1);
        $data22 = StrToTime($data2);
        $wynik = $data11  - $data22;
        return (int)($wynik  / 3600 / 24) + 1;
        
        
    }
    
         public function wyszukaj() {
          if (Auth::check()) {
            return View('wyszukaj');
          }
         
     }
     
    public function wyszukaj2() {
         $wspolne = new \App\Http\Controllers\wpolsne();
         $blad = false;
         $text = "";
          if (Auth::check()) {
              $this->strona = Input::get("strona");
              /*
              if (empty(Input::get("strona"))) {
                  $strona = 1;
              }
              else {
                  $strona = Input::get("strona");
                  
              }
               * */
               
               $link2 =   "&dawka_od=" . Input::get("dawka_od") . "&dawka_do=" . 
                            Input::get("dawka_do") . "&wedlug=" . Input::get("wedlug") . "&wszystkie=" . Input::get("wszystkie") . "&data_od=" . 
                            Input::get("data_od") . "&data_do=" . Input::get("data_do") . "&godzina_od=" . Input::get("godzins_od") . "&godzina_do=" . 
                            Input::get("godzina_do") . "&sortuj=" . Input::get("sortuj") . "&fraza=" . Input::get("fraza") . "&dzien=" . 
                            Input::get("dzien") .     "&dobowa=" . Input::get("dobowa") . "&strona=";
            if (Input::get('produkt') == "" and Input::get('substancja') == "" and Input::get('grupa') == "") {
                
                
                
            }
            if (Input::get('produkt') != "") {
                //Input::get('produkt') = str_replace(",","",Input::get('produkt'));
                $fraza = explode(',',Input::get('produkt'));
                $text = "";
                
                for ($i=0;$i < count($fraza);$i++) {
                    
                    $nazwa = $this->znajdz_ciag($fraza[$i],"produkty");
                    if ($nazwa[0] == true) {
                        $blad = true;
                    }
                    $text .= "," . $nazwa[1];
                }
                $text = trim($text,",");
                $link = "wyszukaj2?produkt=" . $text . "&substancja=" . Input::get("substancja")  . "&zapytanie=" . Input::get('zapytanie') . "&grupa=" . $link2;
                if ($blad == true ) {
                    
                    return View('hiperlacze')->with('text','Czy chodziło ci o  ')->with('hiperlacze',$text)->with('link',$link);
                    
                }
            }    
            elseif (Input::get('substancja') != "") {
                print "kurna";
                $fraza = explode(',',Input::get('substancja'));
                $text = "";
                for ($i=0;$i < count($fraza);$i++) {
            
                    $nazwa = $this->znajdz_ciag($fraza[$i],"substancje");
                    if ($nazwa[0] == true) {
                        $blad = true;
                    }
                    
                    $text .= "," . $nazwa[1];
                }
                $text = trim($text,",");
                $link = "wyszukaj2?produkt="  . "&substancja=$text"  . "&zapytanie=" . Input::get('zapytanie') . "&grupa="   . $link2;
                if ($blad == true ) {
                  
                    
                    return View('hiperlacze')->with('text','Czy chodziło ci o  ')->with('hiperlacze',$text)->with('link',$link);  
                }
                
            }
            elseif (Input::get('grupa') != "") {
                $fraza = explode(',',Input::get('grupa'));
                $text = "";
                for ($i=0;$i < count($fraza);$i++) {
            
                    $nazwa = $this->znajdz_ciag($fraza[$i],"grupy");
                    if ($nazwa[0] == true) {
                        $blad = true;
                    }
                    $text .= "," . $nazwa[1];
                }
                $text = trim($text,",");
                 $link = "wyszukaj2?produkt="  . "&substancja="   . "&zapytanie=" . Input::get('zapytanie') . "&grupa=" .  $text   . $link2;
                if ($blad == true ) {
                   
                    return View('hiperlacze')->with('text','Czy chodziło ci o  ')->with('hiperlacze',$text)->with('link',$link);
                    
                }
                
                
            }
            else {
                $link = "wyszukaj2?produkt=" . $text . "&substancja=" . Input::get("substancja")  . "&zapytanie=" . Input::get('zapytanie') . "&grupa=" . $link2;
                
            }
            
            
            
                $fraza2 = $wspolne->charset_utf_fix2(Input::get("fraza"));
                $produkt = explode(",",$text);
                //Input::get("dawka_od"),Input::get("dawka_do"),Input::get("wedlug"),Input::get("wszystkie"),Input::get("data_od"),
                //Input::get("data_do"),Input::get("godzina_od"),Input::get("godzina_do"),Input::get("sortuj"),Input::get('dzien'),$fraza2,Input::get("strona"),$dobowa
                $this->dawka_od = Input::get("dawka_od");
                $this->dawka_do = Input::get("dawka_do");
                $this->wedlug = Input::get("wedlug");
                $this->wszystkie = Input::get("wszystkie");
                $this->data_od = Input::get("data_od");
                $this->data_do = Input::get("data_do");
                $this->godzina_od = Input::get("godzina_od");
                $this->godzina_do = Input::get("godzina_do");
                $this->sortuj = Input::get("sortuj");
                $this->dzien = Input::get('dzien');
                //$this->fraza = $fraza2;
                
                //$this->dobowa = $dobowa;
               
                if ( !empty(Input::get('dobowa'))) $dobowa = "on";
                else $dobowa  = "";
                if(!isset($nazwa) and Input::get("fraza") != "") $wynik = $this->utworz_zapytanie($produkt,4,$fraza2,$dobowa);
                elseif (!isset($nazwa)) {
                    return View("blad")->with("opis","Nie ma żadnych wyszukań");
                    
                }
                elseif ($nazwa[1] != "" and Input::get("produkt") != "") $wynik = $this->utworz_zapytanie($produkt,1,$fraza2,$dobowa);
                elseif ($nazwa[1] != "" and Input::get("substancja") != "") $wynik = $this->utworz_zapytanie($produkt,2,$fraza2,$dobowa);
                elseif ($nazwa[1] != "" and Input::get("grupa") != "") $wynik = $this->utworz_zapytanie($produkt,3,$fraza2,$dobowa);
                else return View("blad")->with("opis","Nie ma żadnych wyszukań");
                if ($wynik == -1) return View("blad")->with("opis","Nie ma żadnych wyszukań");
                return View("wyszukaj_wynik")
                        ->with("produkty",$this->zapytanie)
                        ->with("paginacja",$this->paginacja)
                        ->with("link",$link);
          }
         
    }
    
    private function zamien_nazwe_na_id_sub($nazwa_substancji,$nawias = false) {
        if ($nawias == false) {
            $id_nazwy = "(";
        }
        else $id_nazwy = "";
        $i = 0;
        $id3 =0;
        $j = 0;
        $z = 0;
        
        $text = "";
        while ($i < count($nazwa_substancji)) {
            
            $id = DB::select("select id from substancje where nazwa = '$nazwa_substancji[$i]'");
            foreach ($id as $id2) { 
                $id3 = $id2->id;
            }
            if ($id3 != 0) {
                $wybierz_poszczegolne_id = DB::select("select id_substancji,id_produktu from przekierowanie_substancji where id_substancji = '$id3'");
                        foreach ($wybierz_poszczegolne_id as $wybierz_poszczegolne_id2) {
                            if ($z == 0) {
                               
                                $text .=  $wybierz_poszczegolne_id2->id_produktu;
                            }
                            else {
                                $text .= "," .   $wybierz_poszczegolne_id2->id_produktu;
                            }
                            $z++;
                        }
                if ($j == 0) $id_nazwy .= $text;
                elseif($i == count($nazwa_substancji)-1) $id_nazwy .=  ',' . $text ;
                else $id_nazwy .= "," .  $text;    
                $j++;
            }
            
          $i++;  
        }
        if ($nawias == false) {
            $id_nazwy .=  ")";
        }
        
        
        
        return $id_nazwy;
    }
    private function zamien_nazwe_na_id_grup($nazwa_grupy) {
        $id_nazwy = "(";
        $id3 = "";
        $id4 = "";
        $id5 = "";
        $text = "";
        $z = 0;
        $j = 0;
        
        for($i=0;$i < count($nazwa_grupy);$i++) {
            $id = DB::select("select id from grupy where nazwa = '$nazwa_grupy[$i]'");
            foreach ($id as $id2) {
                $id3 = $id2->id;
                
            }
            $przekierowanie = DB::select("select id_substancji from przekierowanie_grup where id_grupy = '$id3'");
            foreach($przekierowanie as $przekierowanie2) {
                $id4 = $przekierowanie2->id_substancji;
                            $przekierowanie3 = DB::select("select id_substancji from przekierowanie_substancji where id_substancji = '$id4'");
                    foreach ($przekierowanie3 as $przekierowanie4) {
                $id_substancji = $przekierowanie4->id_substancji;
                $nazwa_sub = DB::select("select nazwa from substancje where id = '$id_substancji'");
                foreach($nazwa_sub as $nazwa_sub2) {
                            if ($z == 0) {
                               
                                $id_nazwy .=  $this->zamien_nazwe_na_id_sub(array($nazwa_sub2->nazwa),true);
                            }
                            else {
                                $id_nazwy .= "," . $this->zamien_nazwe_na_id_sub(array($nazwa_sub2->nazwa),true);
                            }
                            $z++;
                    
                }
               
            }
                
            }

        }
        $id_nazwy .= ")";
        return $id_nazwy;
    }
    
    
        private function rysuj_hiperlacza_do_stron($ilosc_stron,$strona) {
            if (strstr($ilosc_stron,".") ){
                
               $ilosc_stron =  (int)$ilosc_stron + 1;
            }
            $bool = false;
            $bool2 = false;
            
            $tablica = array();
            $j = 0;
            for ($i = 1;$i <= $ilosc_stron;$i++) {
                if ($i == 1) {
                    $tablica[$j][0] =  $i;
                    if ($i == $strona) {
                        $tablica[$j][1] = true;
                    }
                    else {
                        $tablica[$j][1] = false;
                    }
                    
                    $j++;
                }
                elseif ($i+5 > $strona and  $i-5 < $strona) {
                    $tablica[$j][0] =  $i ;
                    if ($i == $strona) {
                        $tablica[$j][1] = true;
                    }
                    else {
                        $tablica[$j][1] = false;
                    }
                 
                    $j++;
                }
                
                elseif ($ilosc_stron == $i) {
                    $tablica[$j][0] = $i;
                    if ($i == $strona) {
                        $tablica[$j][1] = true;
                    }
                    else {
                        $tablica[$j][1] = false;
                    }
                  
                    $j++;
                }
                elseif($bool == false and $i < $strona)  {
                    $bool = true;
                    $tablica[$j][0] = "...";
                    $tablica[$j][1] = true;
                    $j++;
                }
                elseif ($bool2 == false and $i> $strona) {
                    $bool2 = true;
                    $tablica[$j][0] = "...";
                    $tablica[$j][1] = true;
                    $j++;
                }
                
            }
            return $tablica; 
        
    }
   private function ustaw_produkty($produkt,$substancja) {
       $wspolne = new \App\Http\Controllers\wpolsne();
       $produkt =  $wspolne->usun_puste_wartosci($produkt);
        
        if ($substancja ==1) {
            $this->produkty =  $this->zamian_nazwe_na_id($produkt);
        }
        else if ($substancja == 2) {    
            $this->produkty = $this->zamien_nazwe_na_id_sub($produkt);
            
        }
        else if ($substancja == 3) {
            $this->produkty = $this->zamien_nazwe_na_id_grup($produkt);
            
        }
        else {
            $this->produkty = "";
            
        }
        $id_p = str_replace('(', '', $this->produkty);
        $id_p = str_replace(')', '', $id_p);
        $id_p2 = count($produkt);
        if ($substancja != 4) {
            $this->produkty = array_unique(explode(",",$id_p));
            $this->produkty = implode(",",$this->produkty);
            $this->produkty = "(" . $this->produkty . ")";
            $this->produkty = "id_produktu in " . $this->produkty;
        }
        else {
            $this->produkty = "";
        }
        return $id_p2;
       
   }
   
   private function ustaw_where($substancja,$id_users,$dobowa,$fraza) {
        if ($substancja != 4) {
            $this->where = " and spozycie.id_users = '$id_users' ";
        }
        else {
            $this->where = " spozycie.id_users = '$id_users' ";
        }
        if ($this->dawka_od != "" or $this->dawka_do != "" or $this->data_od != "" or $this->data_do != "" or $this->godzina_od != "" or $this->godzina_do != "") {
            if ($dobowa != "on" and ($this->dawka_od == "" or $this->dawka_od == "")) {
                    if ($this->dawka_od != "") $this->where .= " and porcja >= '$this->dawka_od' ";
                    if ($this->dawka_do != "") $this->where .= " and porcja <= '$this->dawka_do' ";
               }
            if ($this->data_od != "")  $this->where .= " and spozycie.data >= '$this->data_od' ";
            if ($this->data_do != "")  $this->where .= " and spozycie.data <= '$this->data_do' ";
            if ($this->godzina_od != "")  $this->where .= " and hour(spozycie.data) >= '$this->godzina_od' ";
            if ($this->godzina_do != "")  $this->where .= " and hour(spozycie.data) <= '$this->godzina_do' "; 
        }
        if ($fraza != "" ) {
            $this->where .= " and opis.opis like '%$fraza%'";    
        }
       
   }
   
   private function ustaw_having($dobowa,$id_p2) {
        if ($this->dzien == "on") {
            $this->having = " HAVING COUNT(DISTINCT id_produktu) = '$id_p2'";
            
        }
       
         if ($this->dawka_od != "" or $this->dawka_do != "" or $this->data_od != "" or $this->data_do != "" or $this->godzina_od != "" or $this->godzina_do != "") {
        
            if ($dobowa == "on" and ($this->dawka_od != "" or $this->dawka_od != "")) {
               if ($this->dawka_od != "" and $this->dzien != "on")  $this->having .= " having sum(porcja) >= '$this->dawka_od' ";
               
               if ($this->dawka_do != "" and $this->dawka_od == ""  and $this->dzien != "on")  $this->having .= " having sum(porcja) <= '$this->dawka_do' "; 
               else if ($this->dawka_do != ""  and $this->dzien != "on") $this->having .= " and sum(porcja) <= '$this->dawka_do' "; 
               else {
                    if ($this->dawka_od != "" )  $this->having .= " and sum(porcja) >= '$this->dawka_od' ";
               
                    if ($this->dawka_do != "" and $this->dawka_od == "")  $this->having .= " and sum(porcja) <= '$this->dawka_do' "; 
                    else if ($this->dawka_do != "") $this->having .= " and sum(porcja) <= '$this->dawka_do' ";  
                   
               }
           }
 
           
     
        }
       
       
   }
    private function utworz_zapytanie($produkt,$substancja,$fraza,$dobowa = "") {
        $wspolne = new \App\Http\Controllers\wpolsne();
        $id_users = Auth::User()->id;
        $this->having = "";
        $this->join = "";
        $produkt =  $wspolne->usun_puste_wartosci($produkt);
        $id_p2 = $this->ustaw_produkty($produkt,$substancja);
        $this->ustaw_where($substancja,$id_users,$dobowa,$fraza);
       
        if ($fraza != "" or $dobowa == "on") {
            
             $this->group = " group by dat ";
        }
        if ($dobowa == "on") {   
            $this->porcja = "  sum(porcja) as porcja ";

        }
        if ($this->dzien == "on") {
            $this->porcja = " porcja ";
            $this->group = " group by dat";
            
        }
        else {
            $this->porcja = " porcja ";
        }
        
        $this->ustaw_having($dobowa,$id_p2);

        if ($this->wszystkie == 2 and $fraza == "") {
            $this->join = "   join przekierowanie_opis on  spozycie.id =  przekierowanie_opis.id_spozycia   ";
            $this->group .= "   group by przekierowanie_opis.id_spozycia ";
        }
        else if ($fraza != "" ) {
            $this->join = " join przekierowanie_opis on spozycie.id = przekierowanie_opis.id_spozycia  join opis on opis.id = przekierowanie_opis.id_opisu  ";
            $this->group .= " , przekierowanie_opis.id_spozycia ";
            
        }
       
        if ($this->sortuj == 1) $this->sortuj = " order by data_ DESC";
        if ($this->sortuj == 2) $this->sortuj = " order by porcja";
        if ($this->sortuj == 3) $this->sortuj = " order by id_produktu";
        if ($this->sortuj == 4) $this->sortuj = " order by hour(data_) ";
        $zapytanie = DB::select("select $this->porcja,   ( DATE(IF(HOUR(spozycie.DATA) >= 5, spozycie.DATA,Date_add(spozycie.DATA, INTERVAL - 1 DAY) )) )  AS dat ,spozycie.data as data_,produkty.nazwa as nazwa,substancje.nazwa as nazwa_sub"
                . ",id_produktu,spozycie.cena as cena from spozycie join produkty on spozycie.id_produktu = produkty.id  "
                . "left join substancje on produkty.id_substancji = substancje.id "
                . " $this->join where $this->produkty $this->where $this->group $this->having $this->sortuj");
        $ilosc_stron = count($zapytanie);
        if ($ilosc_stron == 0) {
            return -1;
        }
        if (!empty($this->strona) ) {
            $this->limit = ($this->strona - 1) * 10 . "," .  20;
            $this->paginacja= $this->rysuj_hiperlacza_do_stron(($ilosc_stron / 10),$this->strona);
        }
        else {
            $this->limit = " 0,10";
            $this->paginacja = $this->rysuj_hiperlacza_do_stron(($ilosc_stron / 10),1);
        }
       
      
        $this->wykonaj_zapytanie( $this->produkty,$this->dzien);

    }
        private function zamian_nazwe_na_id($nazwa) {
        $id_nazwy = "(";
        $i = 0;
        $id3 =0;
        $j = 0;
        while ($i < count($nazwa)) {
            $id = DB::select("select id from produkty where nazwa = '$nazwa[$i]'");
            foreach ($id as $id2) { 
                $id3 = $id2->id;
            }
            if ($id3 != 0) {
                if ($j == 0) $id_nazwy .= $id3;
                elseif($i == count($nazwa)-1) $id_nazwy .=  ',' . $id3 ;
                else $id_nazwy .= "," .  $id3;    
                $j++;
            }
          $i++;  
        }
        $id_nazwy .=  ")";
        return $id_nazwy;
    }

      
    
      private function znajdz_ciag($fraza,$tabela) {

        $znajdz = DB::select("select nazwa,id from $tabela where nazwa = '$fraza'");
        foreach ($znajdz as $znajdz2) {

        }
        if (!isset($znajdz2) ) {
            
            $znajdz3 = DB::select("select nazwa,id from $tabela");
            $i = 0;
            foreach ($znajdz3 as $znajdz4) {
                $wynik = $this->znajdz_podobienstwo_miedzy_dwoma_znakami($fraza,$znajdz4->nazwa);
                if ($wynik > 0.5) {
                    print "dobrze";
                    return [true,$znajdz4->nazwa];
                }
                $i++;
            }
            if ($i == count($znajdz3) ) return [false,false];
        }
        return [false,$znajdz2->nazwa];
        
        
    }

     
           
    private function oblicz_czas($data) {
                        $wspolne = new \App\Http\Controllers\wpolsne();
                        $dat = $wspolne->ustal_poczatek_dnia(5);
                        $data2 = explode(" ",$data);
                        $data3 = explode("-",$data2[0]);
                        $godzina = explode(":",$data2[1]);
                        if ( $godzina[0] <= 5) {
                            $czas = mktime( $godzina[0] , $godzina[1] , $godzina[2] , $data3[1] , $data3[2] , $data3[0]);
                            $czas -= (3600 * 24);
                            $data = date("Y-m-d H:i:s",$czas);
                            $data2 = explode(" ",$data);
                            $data3 = explode("-",$data2[0]);
                        }
                        $tablica["rok"] = $data3[0];
                        $tablica["miesiac"] = $data3[1];
                        $tablica["dzien"] = $data3[2];
                        return $tablica;
    }
    
     private function znajdz_podobienstwo_miedzy_dwoma_znakami($text1,$text2) {
  
        $ile_1 = strlen($text1);
        $ile_2 = strlen($text2);

        if ($ile_1 > $ile_2) $ile = $ile_1;
        else $ile = $ile_2;
        $prawidlowa = 0;
        for ($i=0;$i< $ile;$i++) {

            if (isset($text1[$i]) and isset($text2[$i]) and $text1[$i] != $text2[$i] ) $prawidlowa--;
            else if (isset($text1[$i]) and isset($text2[$i]) and  $text1[$i] == $text2[$i]) $prawidlowa++;
        }
            $wynik = ($ile_1 + $ile_2) / 2;
        return $prawidlowa / $wynik;
      }
    
    private function wykonaj_zapytanie($produkty ,$dzien) {
        $wspolne = new \App\Http\Controllers\wpolsne();
        $tablica = array();
        $i = 0;
        $zapytanie = DB::select("select $this->porcja,   ( DATE(IF(HOUR(spozycie.DATA) >= 5, spozycie.DATA,Date_add(spozycie.DATA, INTERVAL - 1 DAY) )) )  AS dat ,spozycie.data as data_,produkty.nazwa as nazwa,substancje.nazwa as nazwa_sub,id_produktu,"
                . "spozycie.id as id,spozycie.cena as cena"
                . " from spozycie join produkty on spozycie.id_produktu = produkty.id  left join substancje on produkty.id_substancji = substancje.id "
                . " $this->join where  $this->produkty $this->where $this->group $this->having $this->sortuj limit $this->limit");
        foreach ($zapytanie as $zapytanie2) {
                if ($dzien == "on") {
                    $data = explode(" ",$zapytanie2->data_);
                    $data2 = explode("-",$data[0]);
                    $zapytanie3 = DB::select("select $this->porcja,spozycie.data as data_,produkty.nazwa as nazwa,"
                            . "substancje.nazwa as nazwa_sub,id_produktu,spozycie.id as id,spozycie.cena as cena "
                            . "from spozycie join produkty on spozycie.id_produktu = produkty.id left join "
                            . "substancje on produkty.id_substancji = substancje.id     $this->join where $this->produkty and year(spozycie.data) = '$data2[0]' "
                            . "and month(spozycie.data) = '$data2[1]' and day(spozycie.data) = '$data2[2]'  $this->sortuj");
                    foreach ($zapytanie3 as $zapytanie4) {
                        $tablica[$i]["porcja"] = $zapytanie4->porcja;
                        $tablica[$i]["id"] = $zapytanie4->id;
                        $tablica[$i]["przekierowanie"] = $wspolne->sprawdz_czy_jest_opis($zapytanie4->id);
                        $tablica[$i]["data"] = $zapytanie4->data_;
                        $nowa_data = $this->oblicz_czas($tablica[$i]["data"]);
                        $tablica[$i]["rok"] = $nowa_data["rok"];
                        $tablica[$i]["miesiac"] = $nowa_data["miesiac"];
                        $tablica[$i]["dzien"] = $nowa_data["dzien"];
                        $tablica[$i]['color'] = $wspolne->zwroc_kolor_dla_grupy($zapytanie4->id_produktu);
                        
                        $tablica[$i]["nazwa"] = $zapytanie4->nazwa;
                        $tablica[$i]["nazwa_sub"] = $wspolne->wybierz_nazwe_substancji($zapytanie4->id_produktu);
                        $tablica[$i]["cena"] = $wspolne->oblicz_cene($zapytanie4->cena);
                        $i++;
                    }
                }
                else {
                    $tablica[$i]["porcja"] = $zapytanie2->porcja;
                    $tablica[$i]["data"] = $zapytanie2->data_;
                    $tablica[$i]['color'] = $wspolne->zwroc_kolor_dla_grupy($zapytanie2->id_produktu);
                    
                    $nowa_data = $this->oblicz_czas($tablica[$i]["data"]);
                    $tablica[$i]["rok"] = $nowa_data["rok"];
                    $tablica[$i]["miesiac"] = $nowa_data["miesiac"];
                    $tablica[$i]["dzien"] = $nowa_data["dzien"];
                    $tablica[$i]["id"] = $zapytanie2->id;
                    $tablica[$i]["nazwa"] = $zapytanie2->nazwa;
                    $tablica[$i]["nazwa_sub"] = $wspolne->wybierz_nazwe_substancji($zapytanie2->id_produktu);
                    $tablica[$i]["cena"] =$wspolne->oblicz_cene($zapytanie2->cena);
                    $tablica[$i]["przekierowanie"] = $wspolne->sprawdz_czy_jest_opis($zapytanie2->id);
                    $i++;
                    
                }

        }
        $this->zapytanie =  $tablica;
        
    }
    
    private function wskaz_ostatni_rekord($data,$id_produktu) {
        $id_users = Auth::User()->id;
        $i = 0;
        $rekord = DB::select("SELECT ( DATE(IF(HOUR(spozycie.DATA) >= 5, spozycie.DATA,Date_add(spozycie.DATA, INTERVAL - 1 DAY) )) )  "
                . "AS dat, spozycie.id_users, SUM(spozycie.porcja) AS spozycie,data FROM   spozycie  where id_produktu = '$id_produktu' and data <= '$data'  and id_users = '$id_users' GROUP  BY dat ORDER  BY dat desc");
        $tablica = array();
        $j = 0;
        $z = 0;
        foreach ($rekord as $rekord2) {
            $data1[$i] = explode(" ",$rekord2->data);
            $dawka[$i] = $rekord2->spozycie;
            $data = explode("-",$data1[$i][0]);
            $data2 = explode(":",$data1[$i][1]);
            $czas[$i] = mktime($data2[0],$data2[1],$data2[2],$data[1],$data[2],$data[0]);
            if ($i == 0) {
                $tablica[$j][0] = $dawka[$i];
                $tablica[$j][1] = $data1[$i][0];
                $tablica[$j][2] = $data1[$i][0];
              
            }
            elseif ($i != 0 and (($czas[$i-1]  - 176400) >  $czas[$i]))   {
                $tablica[$j][2] = $data1[$i-1][0];               
                $j++;               
                break;
            }
            elseif ($i != 0 and $dawka[$i] != $dawka[$i-1]) {
                $tablica[$j][2] = $data1[$i-1][0];
                $j++;
                $tablica[$j][0] = $dawka[$i];
                $tablica[$j][1] = $data1[$i][0];
                $tablica[$j][2] = $data1[$i][0];
                
            }
            elseif ($i == count($rekord)-1) {
                $tablica[$j][0] = $dawka[$i];
                $tablica[$j][2] = $data1[$i][0];
        
            }
            
        
            $i++;
        }
        
        return $tablica;
    }
    
    
    
    
    
    
    
    
    
    
}
