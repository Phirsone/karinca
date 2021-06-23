<!DOCTYPE html>

<html lang="tr">

<?php

if(isset($_POST["submit"])){
    # Degiskenler
    $username = $_POST["username"];

    $email = $_POST["email"];

    $password = $_POST["password"];

    $passwordrep = $_POST["passwordrep"];


    # Veritabanı ve fonksiyonları cagır

    require_once 'vt.inc.php';

    require_once 'fonksiyon.inc.php';


    # Bos alan var mi
    if(bosGirdiKayit($username, $email, $password) !== false) {

        header("location: ../giris.php?error=emptyinputsignup");

        exit();

    }
    # Kullanici adi var mi
    if(kullaniciAdiVar($baglan, $username, $email) !== false) {

        header("location: ../giris.php?error=usernametaken");

        exit();

    }
    # Kullanici adi karakter kontrol
    if(hataliKullaniciAdi($username) !== false) {

        header("location: ../giris.php?error=invalidusername");

        exit();

    

    }
    # E-posta kontrol
    if(hataliEposta($email) !== false) {

        header("location: ../giris.php?error=invalidemail");

        exit();

    }
    # Sifre guvenlik kontrol
    if (zayifSifre($password) !== false) {

        header("location: ../giris.php?error=weakpass");

        exit();

    }
    # Sifreler benzer degil
    if (eslesmeyenSifre($password, $passwordrep) !== false) {

        header("location: ../giris.php?error=passmatchfail");

        exit();

    }

    


    # Kullaniciyi kaydet
    kullaniciOlustur($baglan, $username, $email, $password);

}

else{
    
    header("location: ../giris.php");

    exit();

}

?>

</html>