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
class Controller_ajax extends BaseController
{
    public function pokaz_opis() {
        $wspolne = new \App\Http\Controllers\wpolsne();
        $id_spozycia = Input::get("id");
        $i = 0;
        $tablica_opisow = array();
        $id_users = Auth::User()->id;
        $opis = DB::select("select id_opisu from przekierowanie_opis where id_spozycia = '$id_spozycia'");
        
        foreach ($opis as $opis2) {
            $id_opis = $opis2->id_opisu;
            $wybierz_opis = DB::select("select data,opis from opis where id = '$id_opis' and id_users = '$id_users'");
            foreach ($wybierz_opis as $wybierz_opis2) {
                $tablica_opisow[$i]['data'] = $wybierz_opis2->data;
                $tablica_opisow[$i]['opis'] = $wspolne->charset_utf_fix($wybierz_opis2->opis);
                $i++;
            }
        }
        if ($i == 0) {
            
            return View('ajax_blad')->with('opis',"Nie ma żadnego opisu");
        }
         
        return View('ajax_pokaz_opis')->with('opis',$tablica_opisow);
        
    } 
    public function modyfikuj_sub() {
        $id_users = Auth::User()->id;
        $grupy = $this->zwroc_aktywne_grupy_sub($id_users,Input::get("id_sub"),'substancje');
        $nazwa = $this->wybierz_nazwe(Input::get("id_sub"),"substancje");
        $rownowaznik = $this->zwroc_rownowaznik(Input::get("id_sub"));
        return View("modyfik_sub")->with("grupy",$grupy)->with("rownowaznik",$rownowaznik)->with("nazwa",$nazwa);
        
    }
    public function modyfikuj_pro() {
        $id_users = Auth::User()->id;
        $nazwa = $this->wybierz_nazwe(Input::get("id_pro"),"produkty");
        $grupy = $this->zwroc_aktywne_grupy_sub($id_users,Input::get("id_pro"),"produkty");
        $cena = $this->zwroc_cena_itp(Input::get("id_pro"));
        return View("modyfik_pro")->with("grupy",$grupy)->with("id_sub",Input::get("id_pro"))->with("nazwa",$nazwa)->with("cena",$cena);
    }
    private function zwroc_rownowaznik($id_sub) {
        $id_users = Auth::User()->id;
        $sub = DB::select("select rownowaznik from substancje where id = '$id_sub'");
        foreach ($sub as $sub2) {
            return $sub2->rownowaznik;
            
        }
    }
    private function zwroc_cena_itp($id_pro) {
        $id_users = Auth::User()->id;
        $pro = DB::select("select cena,za_ile,rodzaj_porcji from produkty where id = '$id_pro'");
        foreach ($pro as $pro2) {
            return [$pro2->cena,$pro2->za_ile,$pro2->rodzaj_porcji];
            
        }
   
    }
    public function modyfikuj_grupe() {
        $nazwa = $this->wybierz_nazwe(Input::get("id_grupy"),"grupy");
        $kolor = $this->ustal_jaki_kolor_ma_grupa(Input::get("id_grupy"));
        return View("modyfik_grupe")->with("kolor",$kolor)->with("nazwa",$nazwa);
        
    }
    
    private function ustal_jaki_kolor_ma_grupa($id) {
        
        $kolor = DB::select("select color from grupy where id = '$id'");
        foreach ($kolor as $kolor2) {
            return $kolor2->color;
            
        }
        
    }
    private function wybierz_nazwe($id,$co) {
        $nazwa = DB::select("select nazwa from $co where id = '$id'");
        foreach ($nazwa as $nazwa2) {
            
            return $nazwa2->nazwa;
        }
        
        
    }
    
    private function zwroc_aktywne_grupy_sub($id_users,$id_sub,$co) {
        $tablica = array();
        $z = 0;
        $jaka_grupa3 = array();
        if ($co == "substancje") {
            $jaka_grupa = DB::select("select id_grupy from przekierowanie_grup where id_substancji = '$id_sub'");
        }
        else {
            $jaka_grupa = DB::select("select id_substancji as id_grupy from przekierowanie_substancji where id_produktu = '$id_sub'");
        }
        $i = 0;
        foreach ($jaka_grupa as $jaka_grupa2) {
             $jaka_grupa3[$i] = $jaka_grupa2->id_grupy;
             $i++;
        }
        if ($co == "substancje") {
            $zwroc = DB::select("select grupy.nazwa as nazwa,grupy.id as id,przekierowanie_grup.id_substancji as id_sub from "
                . "grupy right join przekierowanie_grup on grupy.id = przekierowanie_grup.id_grupy  where grupy.id_users = '$id_users' group by przekierowanie_grup.id_grupy");
        }
        else {
            $zwroc = DB::select("select substancje.nazwa as nazwa,substancje.id as id,przekierowanie_substancji.id_produktu as id_sub from "
                . "substancje right join przekierowanie_substancji on substancje.id = przekierowanie_substancji.id_substancji  where substancje.id_users = '$id_users' group by przekierowanie_substancji.id_substancji");
            
        }
        $bool = false;
        foreach ($zwroc as $zwroc2) {
            $tablica[$z]["nazwa"] = $zwroc2->nazwa;
            $tablica[$z]["id"] = $zwroc2->id;
            $j = 0;
            $bool =false;
            while ($j < count($jaka_grupa3)) {
                if ($jaka_grupa3[$j] == $zwroc2->id){
                    $bool = true;
                }
                $j++;
            }
            if ($bool == true) {
                $tablica[$z]["bool"] = true;
            }
            else $tablica[$z]["bool"] = false;
            $z++;
        }
        return $tablica;
        
    }
    public function usun_wpis($id) {
        $id_users = Auth::User()->id;
        $sprawdz = $this->sprawdz_czy_jestes_wlascicielem($id_users,$id);
        if ($sprawdz == true) {
            
            $usun_opis = DB::select("select id_opisu from przekierowanie_opis where id_spozycia = '$id'");
            foreach ($usun_opis as $usun_opis2) {
                $this->usun_opis($usun_opis2->id_opisu,$id);
            }
            DB::delete("delete from spozycie where id = '$id'");
        }
        
    }
    private function usun_opis($id_opisu,$id_spozycia) {
        $id_users = Auth::User()->id;
        $sprawdz = $this->sprawdz_czy_jestes_wlascicielem($id_users,$id_spozycia);
        if ($sprawdz == true) {
            DB::delete("delete from opis where id = '$id_opisu'");
            DB::delete("delete from przekierowanie_opis where id_opisu = '$id_opisu'");
            
        }
        
    }
    private function sprawdz_czy_jestes_wlascicielem($id_users,$id) {
        $sprawdz = DB::select("select id from spozycie where id_users = '$id_users' and id = '$id'");
        foreach ($sprawdz as $sprawdz2){
            
            if ($sprawdz2->id != "") return true;
        }
        return false;
    }
    public function dodaj_opis() {
        
        if (Input::get('opis') == "") {
            return View('ajax_blad')->with('opis',"To pole nie może być puste");
        }
        else {
            $this->dodaj_przekierowanie_wpisu(Input::get('opis'),date("Y-m-d H:i:s"),Auth::User()->id,Input::get('id'));
            return View('ajax_sukces')->with('opis',"Wpis dpodany poprawnie");
            
        }
        
    }
    private function dodaj_przekierowanie_wpisu($opis,$data2,$id_users,$id_spozycia = "") {
        
            $wspolne = new \App\Http\Controllers\wpolsne();
            $opis = $wspolne->charset_utf_fix2($opis);
            DB::insert("insert into opis(data,opis,id_users) values ('$data2','$opis','$id_users')");
            $wybierz_opis = DB::select("select id from opis where id_users = '$id_users' order by id DESC limit 1");
            foreach ($wybierz_opis as $wybierz_opis2) {}
            $id_opisu = $wybierz_opis2->id;
            if ($id_spozycia == "") {
                $wybierz_id_spozycia = DB::select("select id from spozycie where id_users = '$id_users' order by id DESC limit 1");
                foreach ($wybierz_id_spozycia as $wybierz_id_spozycia2) {}
                $id_spozycia= $wybierz_id_spozycia2->id;
            }
            DB::insert("insert into przekierowanie_opis(id_spozycia,id_opisu) values ('$id_spozycia','$id_opisu')");
        
    }
    
    public function dodaj_wpis() {
        $id_users = Auth::User()->id;
        $wynik = $this->sprawdz_pola(Input::get('produkt'),Input::get('dawka'),Input::get('data'),Input::get('czas'),$id_users);
        $wynik2 = $this->sprawdz_czy_nie_dodawales_takiej_substancji(Input::get('produkt'));
        if ($wynik != 1) return View('ajax_blad')->with('opis',$wynik);
        if ($wynik2 == true) return View('ajax_blad')->with('opis','Już wpisałeś tą substancję w tym braniu');
        else {
            $this->dodaj_nowy_wpis(Input::get('produkt'),Input::get('dawka'),Input::get('data'),Input::get('czas'),Input::get('opis'),$id_users);
            return View('ajax_sukces')->with('opis',"Substancje dodano poprawnie");
        }
    }
    private function dodaj_nowy_wpis($produkt,$dawka,$data,$czas,$opis,$id_users) {
        $wspolne = new \App\Http\Controllers\wpolsne();
        if (!isset($data) and !isset($czas))  $data2 = date("Y-m-d H:i:s"); 
        else if (!isset($data)) $data2 = date("Y-m-d") . " " . $czas;
        else $data2 = $data . " " . $czas;
        $cena_za_ile = DB::select("select cena,za_ile from produkty where id = '$produkt'");
        foreach ($cena_za_ile as $cena_za_ile2){}
        $cena = $wspolne->oblicz_za_ile($dawka,$cena_za_ile2->za_ile,$cena_za_ile2->cena);
        DB::insert("insert into spozycie(porcja,data,id_produktu,cena,id_users) values ('$dawka','$data2','$produkt','$cena','$id_users')");
        if ($opis != "") {
               $this->dodaj_przekierowanie_wpisu($opis,$data2,$id_users);
        }
        
    }
    private function sprawdz_czy_nie_dodawales_takiej_substancji($id) {
        $data = time();
        $wybierz_substancje = DB::select("select  id_produktu,data from spozycie where id_produktu = '$id' order by data desc limit 1");
        foreach ($wybierz_substancje as $wybierz_substancje2) {
        $data2 = explode(" ",$wybierz_substancje2->data);
        $data3 = explode("-",$data2[0]);
        $data4 = explode(":",$data2[1]);
        $data5 = mktime($data4[0], $data4[1],$data4[2],$data3[1],$data3[2],$data3[0]);
        print $data5;
        if ($data - 60 < $data5 and $wybierz_substancje2->id_produktu != "") return true;
        else return false;
        }
    }
    
    
    public function przelicz() {
        $wspolne = new \App\Http\Controllers\wpolsne();
        $rowno = $wspolne->przelicz_rownowaznik(Input::get("rownowaznik"),Input::get("id"));
        print  $rowno;
        
        
        
    }
    private function sprawdz_pola($produkt,$dawka,$data,$czas,$id_users) {
        
        $produkt2 = DB::select("select id from produkty where id = '$produkt' and id_users = '$id_users'");
        foreach ($produkt2 as $produkt3) {
        if ($produkt3->id == "") return "Nie poprawna nazwa substancji";
        if (!is_numeric($dawka) ) return "pole dawka nie jest liczbą";
        if ( isset($czas)) {
            $czas2 = explode(":",$czas);
            if (count($czas2) != 2) return "nie poprawny czas";
        
        }
        if ( isset($data)) {
            $data2 = explode("-",$data);
            if (count($data2) != 3) return "nie poprawna data";
        
        }
        if (isset($data) and !isset($czas)) return "Wpisz czas";
        else return 1;
        }
    }
    
}
