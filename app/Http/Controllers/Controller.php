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
class Controller extends BaseController
{
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //dodaje nową substancje
    public function dodaj_nowy() {
        
        
        $id_users = Auth::User()->id;
        //wyświetLa grupy
        $grupy = $this->pokaz_grupy_sub($id_users,"grupy");
        $substancje = $this->pokaz_grupy_sub($id_users,"substancje");
        return View("dodaj_nowy")->with("grupy",$grupy)->with("substancje",$substancje);
        
    }
    
    public function edytuj_produkt() {
        $id_users = Auth::User()->id;
        $grupy = $this->pokaz_grupy_sub($id_users,"grupy");
        $substancje = $this->pokaz_grupy_sub($id_users,"substancje",",rownowaznik");
        $produkty = $this->pokaz_grupy_sub($id_users,"produkty",",ile_procent,za_ile,cena,rodzaj_porcji");
        return View("modyfikuj")->with("grupy",$grupy)->with("substancje",$substancje)->with("produkty",$produkty);
        
    }
    public function modyfikuj_grupe2() {
        $id_users = Auth::User()->id;
        $wynik = $this->sprawdz_nazwe(Input::get("nowa_nazwa"),"grupy",$id_users,Input::get("grupy"));
        if (Input::get("nowa_nazwa") == "") $bool = true;
        else $bool = false;
        if ($wynik == 0) $this->edytuj_grupe(Input::get("nowa_nazwa"),Input::get("kolor"),Input::get("grupy"),$bool);
        elseif ($wynik != -3 and $wynik != -1) $this->edytuj_grupe(Input::get("nowa_nazwa"),Input::get("kolor"),Input::get("grupy"),$bool);
        elseif ($wynik == -3) return View("blad")->with('opis',"Grupa ma w nazwie przecinek");
        elseif ($wynik == -1) return View("blad")->with('opis',"Już jest grupa o tej nazwie");
        else {
            $this->edytuj_grupe(Input::get("nowa_nazwa"),Input::get("kolor"),Input::get("grupy"));
        }
        return View("sukces")->with('opis','Grupa zmodyfikowana poprawnie');
        
    }
    public function edytuj_grupe($nazwa,$color,$id,$bool = true) {
        $id_users = Auth::User()->id;
        if ($bool == true) $edytuj = DB::update("update grupy set  color='$color' where id = '$id'");
        else  $edytuj = DB::update("update grupy set nazwa = '$nazwa', color='$color' where id = '$id'");
        
    }
    public function nowa_grupa() {
        $id_users = Auth::User()->id;
        $wynik = $this->sprawdz_nazwe(Input::get("nazwa"),"grupy",$id_users);
        if ($wynik == -2) return View("blad")->with('opis',"Wpisz nazwę grupy");
        elseif ($wynik == -3) return View("blad")->with('opis',"Grupa ma w nazwie przecinek");
        elseif ($wynik == -1) return View("blad")->with('opis',"Już jest grupa o tej nazwie");
        else {
            $this->dodaj_grupe(Input::get("nazwa"),Input::get("kolor"),$id_users);
        }
        
    }
    public function nowa_substancja() {
        $id_users = Auth::User()->id;
        $wynik = $this->sprawdz_nazwe(Input::get("nazwa"),"substancje",$id_users);
        if ($wynik == -2) return View("blad")->with('opis',"Wpisz nazwę substancji");
        elseif ($wynik == -1) return View("blad")->with('opis',"Już jest substancja o tej nazwie");
        elseif ($wynik == -3) return View("blad")->with('opis',"Substancja ma w nazwie przecinek");
        else {
            $this->dodaj_substancje(Input::get("nazwa"),Input::get("substancja"),$id_users);
        }
        return View("sukces")->with('opis','Substancja dodana poprawnie');
    }
    public function edytuj_sub() {
        $id_users = Auth::User()->id;
        $nazwa = Input::get("nowa_nazwa");
        $rownowaznik = Input::get("rownowaznik");
        $id = Input::get("id");
                
            $wynik = $this->sprawdz_nazwe(Input::get("nowa_nazwa"),"substancje",$id_users,Input::get("id"));
            if ($wynik == -1) return View("blad")->with('opis',"Już jest substancja o tej nazwie");
            elseif ($wynik == -2) return View("blad")->with('opis',"Wpisz nazwę");
            elseif ($wynik == -3) return View("blad")->with('opis',"Nazwa nie może zaweierac przenickja");
            else {
                DB::update("update substancje set nazwa = '$nazwa',rownowaznik = '$rownowaznik' where id = '$id'");
                $this->uaktualnij_przekierowanie(Input::get("id"),Input::get("substancja2"),"przekierowanie_grup");
            }
         return View("sukces")->with('opis','Substancja zmodyfikowana poprawnie');
    }
    
    public function edytuj_pro() {
        
        $id_users = Auth::User()->id;
        $nazwa = Input::get("nowa_nazwa");
        $cena = Input::get("cena");
        $za_ile = Input::get("za_ile");
        $rodzaj = Input::get("rodzaj");
        $id = Input::get("id");
        $wynik = $this->sprawdz_nazwe(Input::get("nowa_nazwa"),"substancje",$id_users,Input::get("id"));
        if ($wynik == -1) return View("blad")->with('opis',"Jest już nazwa o takim produkcie wpisz inną");
        elseif ($wynik == -2) return View("blad")->with('opis',"Wpisz nazwę");
        elseif ($wynik == -3) return View("blad")->with('opis',"Nazwa nie może zaweierac przenickja");
        else {
            DB::update("update produkty set nazwa = '$nazwa',cena = '$cena',za_ile = '$za_ile',rodzaj_porcji='$rodzaj' where id = '$id'");
            $this->uaktualnij_przekierowanie(Input::get("id"),Input::get("substancja2"),"przekierowanie_substancji");
            
        }
        return View("sukces")->with('opis','Produkt zmodyfikowana poprawnie');
        
    }
    
    private function uaktualnij_przekierowanie($id,$tablica,$grup_czy_sub) {
        if ($grup_czy_sub == "przekierowanie_grup" ) {
            DB::delete("delete from $grup_czy_sub where id_substancji = '$id'");
        }
        else {
            DB::delete("delete from $grup_czy_sub where id_produktu = '$id'");
            
        }
        for ($i=0;$i < count($tablica);$i++) {
            if ($grup_czy_sub == "przekierowanie_grup" ) DB::insert("insert into $grup_czy_sub (id_substancji,id_grupy) values ('$id','$tablica[$i]]')");
            elseif ($grup_czy_sub == "przekierowanie_substancji" ) DB::insert("insert into $grup_czy_sub (id_produktu,id_substancji) values ('$id','$tablica[$i]]')");
            
            
        }
        
        
        
    }
    private function uaktualnij_nazwe($id,$nowa_nazwa,$tabela,$rownowaznik) {
        DB::update("update $tabela set nazwa = '$nowa_nazwa',rownowaznik = '$rownowaznik' where id = '$id'");
 
    }
    private function dodaj_przekierowanie($id_users,$tablica,$sub_czy_pro = 1) {
            if ($sub_czy_pro == 1) {
                $id_sub = DB::select("select id from substancje where id_users = '$id_users' order by id desc limit 1");
            }
            else {
                $id_sub = DB::select("select id from produkty where id_users = '$id_users' order by id desc limit 1");
            }
            foreach ($id_sub as $id_sub2) {
                $id_sub3 = $id_sub2->id;   

            }
            for ($i=0;$i< count($tablica);$i++) {
                if ($sub_czy_pro == 1) {
                    DB::insert("insert into przekierowanie_grup(id_grupy,id_substancji) values ('$tablica[$i]','$id_sub3')");
                }
                else {
                    DB::insert("insert into przekierowanie_substancji(id_substancji,id_produktu) values ('$tablica[$i]','$id_sub3')");
                }
            }
        
    }
    private function dodaj_substancje($nazwa,$substancja,$id_users) {
        
        DB::insert("insert into substancje(nazwa,id_users) values('$nazwa','$id_users')");
        if (count($substancja) != 0) {
            $this->dodaj_przekierowanie($id_users,$substancja);
        }
    }
    private function dodaj_produkt($nazwa,$produkty,$procent,$za_ile,$cena,$rodzaj,$id_users) {
        DB::insert("insert into produkty(nazwa,id_users,ile_procent,za_ile,cena,rodzaj_porcji) values('$nazwa','$id_users','$procent','$za_ile','$cena','$rodzaj')");
        if (count($produkty) != 0) {
            $this->dodaj_przekierowanie($id_users,$produkty,2);
        }
        
    }
    public function nowy_produkt() {
         $id_users = Auth::User()->id;
         $wynik = $this->sprawdz_nazwe(Input::get("nazwa"),"produkty",$id_users);
         if ( ((Input::get("procent") < 0 or Input::get("procent") > 100 or !is_numeric(Input::get("procent"))) and Input::get("procent") != "")) return View("blad")->with('opis',"Pole procent musi być liczbą większa od 0 i mniejszą o 100");
         if ( (!(Input::get("rodzaj") == 1 or Input::get("rodzaj") == 2 or Input::get("rodzaj") == 3 ))) return View("blad")->with('opis',"Wpisz dobrze pole rodzaj");
         if ( ((  !is_numeric(Input::get("cena")) and Input::get("cena") != "" )) ) return View("blad")->with('opis',"Pole cena musi być liczbą");
         if ( ((  !is_numeric(Input::get("za_ile")) and is_numeric(Input::get("za_ile") != ""  )) )) return View("blad")->with('opis',"Pole za ile musi być liczbą");
         if ($wynik == -2) return View("blad")->with('opis',"Wpisz nazwę produktu");
         elseif ($wynik == -1) return View("blad")->with('opis',"Już jest produkt o tej nazwie");
         elseif ($wynik == -3) return View("blad")->with('opis',"produkt ma w nazwie przecinek");
         else {
            $this->dodaj_produkt(Input::get("nazwa"),Input::get("produkty"),Input::get("procent"),Input::get("za_ile"),Input::get("cena"),Input::get("rodzaj"),$id_users);
        }
        return View("sukces")->with('opis','Produkt dodana poprawnie');
    }
    private function sprawdz_nazwe($nazwa,$co,$id_users,$id = "") {
        
        if ($nazwa == "") return -2;
            $sprawdz3 = DB::select("select nazwa from $co where id != '$id' and id_users = '$id_users' and nazwa = '$nazwa'");
            foreach ($sprawdz3 as $sprawdz4){
               if ($sprawdz4->nazwa != "") return -1;
            
            }
        if (strstr($nazwa,",")) return -3;
        
        return 0;
    }
    
    private function pokaz_grupy_sub($id_users,$co,$pola = "") {
        $grupy3 = array();
        $i = 0;
        $grupy = DB::select("select nazwa,id$pola from $co where id_users = '$id_users'");
        foreach ($grupy as $grupy2) {
            $grupy3[$i]["id"] = $grupy2->id;
            $grupy3[$i]["nazwa"] = $grupy2->nazwa;
            $i++;
        }
        
        return $grupy3;
        
    }
    private function dodaj_grupe($nazwa,$kolor,$id_users) {
        DB::insert("insert into grupy(nazwa,color,id_users) values ('$nazwa','$kolor','$id_users') ");
        
    }
    public function pokaz_wykres_czestosci_brania_substancji($rok,$miesiac) {
        $wspolne = new \App\Http\Controllers\wpolsne();
        $poczatek = $wspolne->ustal_poczatek_dnia(true);
        
        if ($miesiac == 12) {
            $miesiac2 = 1;
            $rok2 = $rok+1;
        }
        else {
            $miesiac2 = $miesiac + 1;
            $rok2 = $rok;
            
        }
        $data1 = mktime($poczatek,0,0,$miesiac,1,$rok);
        $z = 0;
        $data2 = mktime($poczatek,0,0,$miesiac2,1,$rok2);
        $tablica = array();
        for ($i=$data1;$i <= $data2;$i += 86400) {
            $data_data  = date("Y-m-d H:i:s",$i);
            $data_data2 = date("Y-m-d H:i:s",$i + 86400);
            $tablica[$z] = $wspolne->wybierz_kolor(Auth::User()->id,$data_data,$data_data2 );
            $z++;
        }
        return $tablica;
        
    }
    
     public function zarejestruj() {
        if (!Auth::check()) {
            return view('rejestracja');
        }
        else {
            return Redirect('glowna');
        }
    }
    
 
    public function rejestracja() {
   
     $rules = array(
        
      'login' => 'required|min:4|unique:users',
      'haslo' => 'required|same:haslo2',
      'haslo' => 'required|min:6',
    );
      $blad = "";
  if (Input::get('dzien') != "" and is_int(Input::get("dzien"))) $blad = "Pole dzień musi być liczbą";
  else if (Input::get('dzien') != "") $dzien = Input::get("dzien");
  else $dzien = 0;
     $validation = Validator::make(Input::all(), $rules);
     if (($validation->fails()) or $blad == "Pole dzień musi być liczbą")
      {

            return Redirect('rejestracja')->withErrors($validation)->with("dzien",$blad)->withInput();
    
        
      }
      
     $user = new \App\User;
     $user->password = Hash::make(Input::get('haslo'));
     $user->login = htmlspecialchars(Input::get('login'));
     $user->poczatek_dnia = $dzien;
     if ($user->save())
     {

	     return Redirect('zaloguj')->with('login_sukces','ZArejestrowałęś się pomyślnie możesz się teraz zalogować');
     }	
    }
        //Rysuje kontroller do strony głównej
        public function glowna($rok = "",$miesiac = "",$dzien = "",$akcja = "") {
            
            $wspolne = new \App\Http\Controllers\wpolsne();

            if (Auth::check()) {
            if (empty($rok) ) $rok = date("Y");
            if (empty($miesiac)) $miesiac = date("m");
            //zwraca sumę substancji dla danego dnia
            $tablica = $this->pokaz_wykres_czestosci_brania_substancji($rok,$miesiac);

            if ($dzien == ""){
            $dzien = date("d");

            }
            $rownowazniki = $this->wybierz_rownowazniki();
            $date = $this->ustaw_date($miesiac,$akcja,$dzien,$rok);
            $miesiac2 = $this->zwroc_miesiac_text($date[0]);
                $dzien3 = 1;
                //jeżeli była akcja wstecz to do zmiennej $dzien3 przypisz poprzedni miesiac
            $dzien1 = 1;

            $dzien2 = 1;
                if ($date[4] == "wstecz") {
                  $dzien3 = $this->sprawdz_miesiac($date[0],$date[1]);
                  $dzien = $this->sprawdz_miesiac($date[0],$date[1]);
                  $dzien3 = 1;
                  $date[2] = $this->sprawdz_miesiac($date[0],$date[1]);

                }
                if ($date[4] == "dalej")  {
                  $dzien3 = 1;
                }

            $poprzedni = $this->zwroc_poprzedni_miesiac($date[0],$date[1]);
            $nastepny = $this->zwroc_nastepny_miesiac($date[0],$date[1]);
            $jaki_dzien_miesiaca = $this->sprawdz_miesiac($date[0],$date[1]);
            $data1 = mktime(0,0,0,$date[0],$date[2],$date[1]);
            $data_1 = $data1 + 86400;

            $date2 = date("Y-m-d",$data_1);

            $poczatek_dnia = $wspolne->ustal_poczatek_dnia();
            $date2 .=  $poczatek_dnia;
            $data11 = $rok.  "-" . $miesiac . "-" . $dzien  . $poczatek_dnia;

            $data1 = $wspolne->oblicz_dzien($data11);
            $data2 = $wspolne->oblicz_dzien($data11,true);
            $id_users = Auth::User()->id;
            $suma_substancji = $wspolne->wybierz_sume_substancji_dla_dnia($rok . "-" . $miesiac  . "-"  . $dzien,$id_users);
            $produkty = $wspolne->wybierz_spozycie($id_users,$data1,$data2);
            $data1 = $date[1] . "-" . $date[0] . "-" . $date[2] . $poczatek_dnia;

           $produkty2 = $wspolne->wybierz_produkty($id_users);

            $dzien_wyswietlania = $rok . "-" . $miesiac  . "-" . $dzien;
              return view('glowna')->with('miesiac',$date[0])
                  ->with('miesiac2',$miesiac2)
                  ->with('rok',$date[1])
                  ->with('jaki_dzien_miesiaca',$jaki_dzien_miesiaca)
                  ->with('dzien',$date[2])
                  ->with('dzien1',$dzien1)
                  ->with('dzien_tygodnia',$date[3])
                  ->with('dzien3',$dzien2)
                  ->with('dzien2',$dzien3)
                  ->with('dzien4',1)
                  ->with('nastepny',$nastepny)
                  ->with('poprzedni',$poprzedni)
                  ->with('dzien_wyswietlania',$dzien_wyswietlania)
                  ->with('produkty',$produkty)
                  ->with('produkty2',$produkty2)
                  ->with('suma_substancji',$wspolne->suma_substancji)
                  ->with('tablica',$tablica)
                  ->with('rownowaznik',$wspolne->rownowaznik)
                  ->with('rownowazniki',$rownowazniki);

              }
              else {
                  
                  return Redirect("zaloguj");
              }
      }
        
      
      private function wybierz_rownowazniki() {
          $id_users = Auth::User()->id;
          $tablica = array();
          $i = 0;
          $wybierz = DB::select("select nazwa,id from substancje where rownowaznik != '' and rownowaznik != '0' and id_users = '$id_users'");
          foreach ($wybierz as $wybierz2) {
              $tablica[$i][0] = $wybierz2->id;
              $tablica[$i][1] = $wybierz2->nazwa;
              $i++;
          }
          return $tablica;
      }
    

      
       private function zwroc_poprzedni_miesiac($miesiac,$rok) {
        if ($miesiac == 1) {
          $rok--;
          $miesiac = 12;
        }
        else {
          $miesiac--;
        }
        return array($rok,$miesiac);
     }

    private function zwroc_nastepny_miesiac($miesiac,$rok) {
        if ($miesiac == 12) {
          $rok++;
          $miesiac = 1;
        }
        else {
          $miesiac++;
        }
        return array($rok,$miesiac);
    }
      
    private function zwroc_miesiac_text($miesiac) {

        switch($miesiac) {
          case 1 : return "Styczeń";
          case 2 : return "Luty";
          case 3 : return "Marzec";
          case 4 : return "Kwiecień";
          case 5 : return "Maj";
          case 6 : return "Czerwiec";
          case 7 : return "Lipiec";
          case 8 : return "Sierpień";
          case 9 : return "Wrzesień";
          case 10 : return "Październik";
          case 11: return "Listopad";
          case 12 : return "Grudzień";
        

        }
    }
          private function sprawdz_miesiac($miesiac,$rok) {

            if ($miesiac == 12) {
            return 31;
            }
            else if ($miesiac == 11) {
            return 30;
            }
            else if ($miesiac == 10) {
            return 31;
            }
            else if ($miesiac == 9) {
            return 30;
            }
            else if ($miesiac == 8) {
            return 31;
            }
            else if ($miesiac == 7) {
            return 31;
            }
            else if ($miesiac == 6) {
            return 30;
            }
            else if ($miesiac == 5) {
            return 31;
            }
            else if ($miesiac == 4) {
            return 30;
            }
            else if ($miesiac == 3) {
            return 31;
            }
            else if ($miesiac == 2) {

            if ( $this->czy_przystepny($rok) == 1) {
                return 29;
            }
            else {
                return 28;
            }

            }
            else if ($miesiac == 1) {
            return 31;
            }


  }

        private function czy_przystepny($rok)
        {
             return (($rok%4 == 0 && $rok%100 != 0) || $rok%400 == 0);
        }
    
  
        private function ustaw_date($miesiac,$akcja,$dzien,$rok) {
            
 
            if (empty($miesiac) ) {
                $miesiac = date("m");
                $rok = date("Y");
            }
            
            if ( empty($dzien) and empty($akcja) ) {
                $dzien = date("d");
            }
            else {
                if ( !empty($dzien) ) {
                    $dzien = $dzien;
                }

            }

            if ( !empty($rok) or  !empty($miesiac)) {

                $dzien_tygodnia = $this->ustal_dzien_tygodnia("$rok-$miesiac-1");
            }
            else {
                $rok = date("Y");
                $miesiac = date("m");
                $dzien_tygodnia = $this->ustal_dzien_tygodnia("Y-m-1");
            }

        
            if ($dzien_tygodnia == 0) {
                $dzien_tygodnia = 7;
            }
            
            return array($miesiac,$rok,$dzien,$dzien_tygodnia,$akcja);
        }
    
       private function ustal_dzien_tygodnia($data) {
        return date("w",strtotime($data));
      }
    
      
    public function logowanie() {
    
        $haslo = Input::get('haslo');

        $user = array(
            'login' => Input::get('name'),
            'password' => Input::get('haslo')
        );
        if (Input::get('name') == "" and Input::get('haslo') == "" ) {
            return Redirect('zaloguj')->with('login_error','Uzupełnij pole login i hasło');
        }
        
        if (Auth::attempt($user))
        {
            return Redirect('glowna');
        }
        else {

            return Redirect('zaloguj')->with('login_error','Nieprawidłowy login lub hasło');
        }
    }
    public function zaloguj() {
        
        return View("zaloguj");
        
        
        
    }
    public function wyloguj(){
        
        Auth::logout();
        return Redirect('zaloguj')->with('login_sukces','Wylogowałęś się pomyslnie');
    }
}
