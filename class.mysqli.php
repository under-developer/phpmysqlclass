<?php

class sql{

    private $baglanti = NULL;

    public function baglan($sunucu,$kullanici,$sifre,$db,$port = 3306,$charset = "UTF-8"){
        $this->baglanti = mysqli_connect($sunucu,$kullanici,$sifre,$db,$port);
        if($this->baglanti){
            mysqli_set_charset($this->baglanti,$charset);
            return true;
        }else{
            return false;
        }
    }

    public function sorgu($sorgu){
        return $this->baglanti->query($sorgu);
    }

    public function suzgec($veri){
        return $this->baglanti->real_escape_string($veri);
    }

    public function assoc($sorgu){
        return $this->sorgu($sorgu)->fetch_assoc();
    }

    public function while_assoc($sorgu){
        
        $dondur = [];
        $liste = $this->sorgu($sorgu);
        $i = 0;

        while ($row = $liste->fetch_assoc()) {
            $dondur[$i] = $row;
            $i++;
        }

        return $dondur;

    }
    /**
     * $degerler = ["sql_tablo_ismi" => "gelecek_deger"];
    */
    public function ekle($degerler,$tablo,$html = false){

        $sorgu = "INSERT INTO `$tablo`(";
        
        foreach ($degerler as $key => $value) {
            $sorgu .= "`$key`,";
        }

        $sorgu = trim($sorgu," ");
        $sorgu = trim($sorgu,","); 
        $sorgu = $sorgu .= ")VALUES(";
        
        if($html === false){
            foreach ($degerler as $key => $value) {
                $value = $this->suzgec($value);
                if(is_string($value)){
                    $sorgu .= "'$value',";
                }else{
                    $sorgu .= "$value,";
                }
            }
        }else{
            foreach ($degerler as $key => $value) {
                $value = $this->suzgec($value);
                $value = htmlspecialchars($value);
                if(is_string($value)){
                    $sorgu .= "'$value',";
                }else{
                    $sorgu .= "$value,";
                }
            }
        }


        $sorgu = trim($sorgu," ");
        $sorgu = trim($sorgu,","); 
        $sorgu = $sorgu .= ")";

        return $this->sorgu($sorgu);
    }

    public function guncelle($degerler,$tablo,$sona_ekle = "",$html = false){

        $sorgu = "UPDATE `$tablo` SET";

        if($html === false){
            foreach ($degerler as $key => $value) {
                if(is_string($value)){
                    $value = $this->suzgec($value);
                    $sorgu .= " `$key` = '$value',";
                }else{            
                    $value = $this->suzgec($value);
                    $sorgu .= " `$key` = $value,";
                }
            }
            $sorgu = trim($sorgu," ");
            $sorgu = trim($sorgu,",");
            
        }else{
            foreach ($degerler as $key => $value) {
                if(is_string($value)){
                    $value = $this->suzgec($value);
                    $value = htmlspecialchars($value);
                    $sorgu .= " `$key` = '$value',";
                }else{            
                    $value = $this->suzgec($value);
                    $value = htmlspecialchars($value);
                    $sorgu .= " `$key` = $value,";
                }
            }
            $sorgu = trim($sorgu," ");
            $sorgu = trim($sorgu,",");
        }

        $sorgu = $sorgu." ".$sona_ekle;
    
        return $this->sorgu($sorgu);

    }

    public function sil($degerler,$tablo){

        $sorgu = "DELETE FROM `$tablo` WHERE";

        foreach ($degerler as $key => $value) {
            if(is_string($value)){
                $value = $this->suzgec($value);
                $sorgu .= " `$key` = '$value',";
            }else{
                $value = $this->suzgec($value);
                $sorgu .= " `$key` = $value,";
            }
        }

        $sorgu = trim($sorgu," ");
        $sorgu = trim($sorgu,",");
        
        return $this->sorgu($sorgu);

    }

    public function toplam($tablo){
        return $this->sorgu("SELECT * FROM `$tablo`")->num_rows;
    }
    /**
     * $aranacak = ["colm_name"];
     * $kelime = "Değer";
     */
    public function ara($tablo,$aranacak,$kelime,$sona_ekle = "",$while_assoc = true,$syntax_al = false){
        $sorgu = "";
        $ilk = $aranacak[0];
        $adet = count($aranacak);
        
        unset($aranacak[0]);
        if(is_int($kelime)){
            $kelime = $this->suzgec($kelime);
            $sorgu = "SELECT * FROM `$tablo` WHERE `$ilk` LIKE $kelime ";

            if($adet > 1){
                foreach ($aranacak as $val) {
                    $sorgu .= "OR `$val` LIKE $kelime ";
                }
            }

        }else{
            $kelime = $this->suzgec($kelime);
            $sorgu = "SELECT * FROM `$tablo` WHERE `$ilk` LIKE '$kelime' ";

            if($adet > 1){
                foreach ($aranacak as $val) {
                    $sorgu .= "OR `$val` LIKE '$kelime' ";
                }
            }

        }

        $sorgu = $sorgu." ".$sona_ekle;

        if($while_assoc && $syntax_al){
            $gonder["while_assoc"] = $this->while_assoc($sorgu);
            $gonder["syntax"] = $sorgu;
            return $gonder;
        }else if($while_assoc){
            return $this->while_assoc($sorgu);
        }else if($syntax_al){
            return $sorgu;
        }
        

    }
}