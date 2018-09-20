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
       private function ustal_poczatek_dnia($dzien) {
      
        if ($dzien == "") {
           return " 00:00:00";

        }
        else {
          return " $dzien:00:00";


        }
      
      }
    
    public function pokaz_wykres_czestosci_brania_substancji($rok,$miesiac) {
        $poczatek = $this->ustal_poczatek_dnia(5);
        $wspolne = new \App\Http\Controllers\wpolsne();
        if ($miesiac == 12) {
            $miesiac2 = 1;
            $rok2 = $rok+1;
        }
        else {
            $miesiac2 = $miesiac + 1;
            $rok2 = $rok;
            
        }
        $data1 = mktime(5,0,0,$miesiac,1,$rok);
        $z = 0;
        $data2 = mktime(5,0,0,$miesiac2,1,$rok2);
        $tablica = array();
        for ($i=$data1;$i <= $data2;$i += 86400) {
            $data_data  = date("Y-m-d H:i:s",$i);
            $data_data2 = date("Y-m-d H:i:s",$i + 86400);
            $tablica[$z] = $wspolne->wybierz_kolor(Auth::User()->id,$data_data,$data_data2 );
            $z++;
        }
        return $tablica;
        
    }
    

    
        public function glowna($rok = "",$miesiac = "",$dzien = "",$akcja = "") {
            
            $wspolne = new \App\Http\Controllers\wpolsne();

            if (Auth::check()) {
            $tablica = $this->pokaz_wykres_czestosci_brania_substancji($rok,$miesiac);

            if ($dzien == ""){
            $dzien = date("d");

            }

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

            $poczatek_dnia = $this->ustal_poczatek_dnia("05");
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
                  ->with('suma_substancji',$suma_substancji)
                  ->with('tablica',$tablica);

              }
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
          //  return Redirect('blad')->with('login_error','Uzupełnij pole login i hasło');
        }
        
        if (Auth::attempt($user))
        {
            return Redirect('glowna');
        }
        else {

            //return Redirect('blad')->with('login_error','Nieprawidłowy login lub hasło');
        }
    }
    public function zaloguj() {
        
        return View("zaloguj");
        
        
        
    }
}
