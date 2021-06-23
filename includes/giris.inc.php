<?php

    if (isset($_POST["submit"])) {

        # Degiskenler
        $username = $_POST["username"];

        $password = $_POST["password"];


        # Veritabanı ve fonksiyonları cagır

        require_once 'vt.inc.php';

        require_once 'fonksiyon.inc.php';


        # Bos girdi var mi
        if(bosGirdiGiris($username, $password) !== false) {

            header("location: ../giris.php?error=emptyinputlogin");

            exit();

        }


        # Session basla
        kullaniciGiris($baglan, $username, $password);

    }

    else{

        header("location: ../giris.php");

    }