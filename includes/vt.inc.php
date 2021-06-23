<?php

# Degiskenler

$serverAdi = "localhost";

$vtAdi = "root";

$vtSifre = "";

$vtIsmi = "karinca";


# Veritabani baglan
$baglan = mysqli_connect($serverAdi, $vtAdi, $vtSifre, $vtIsmi);


# Baglanti hatasi olursa
if (!$baglan) {

    die("Connection failed: " . mysqli_connect_error());

}