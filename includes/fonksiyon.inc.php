<?php

#  Kayit ekraninda bos veri giris kontrol
function bosGirdiKayit($username, $email, $password) {
    if(empty($username) || empty($email) || empty($password)){
        $result = true;
    }
    else{
        $result = false;
    }
        return $result;
}
# Giris ekraninda bos veri giris kontrol
function bosGirdiGiris($username, $password) {
    if(empty($username) || empty($password)){
        $result = true;
    }
    else{
        $result = false;
    }
        return $result;
}
# Veritabani kullanici adi kontrol
function kullaniciAdiVar($baglan, $username, $email) {
    # Kullanici adi ve e-posta SQL sorgusu
    $sql = "SELECT * FROM kullanici WHERE kullaniciAdi = ? OR kullaniciEposta = ?;";
    # Veritabani baglantisi 
    $stmt = mysqli_stmt_init($baglan);
    # SQL sorgusu ve veritabani baglanti kontrol
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../giris.php?error=statementfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    # Kullanici adi ya da e-posta veritabanında varsa TRUE yoksa FALSE 
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}
# Kullanici adi icerisinde kullanilmasi istenmeyen karakterler
function hataliKullaniciAdi($username){
    $result = true;
    if (!preg_match("/^[a-zA-Z0-9i-İü-Üö-Öğ-Ğş-Ş ]*$/", $username)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
# E-posta hatalı mı
function hataliEposta($email) {
    $result = true;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
# Sifre 6 karakterden uzun mu
function zayifSifre($password) {
    if(strlen($password) < 6) {
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
# Girilen sifreler ayni mi
function  eslesmeyensifre($password, $passwordrep){
    $result = true;
    if ($password !== $passwordrep){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
# Kullaniciyi veritabanina kaydet
function kullaniciOlustur($baglan, $username, $email, $password) {
    # Kullanici kayit eden SQL sorgusu
    $sql = "INSERT INTO kullanici (kullaniciAdi, kullaniciEposta, kullaniciSifre) VALUES(?,?,?);";
    $stmt = mysqli_stmt_init($baglan);
    # SQL sorgusu ve veritabani baglanti kontrol
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../giris.php?error=statementfailed");
        exit();
    }
    # Sifreyi MySQL'in default tercihi ile hash'leme
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    # Veritabanindan kayit olan kullaniciyi secen SQL sorgusu
    $sql = "SELECT * FROM kullanici WHERE kullaniciAdi='$username';";
    $result = mysqli_query($baglan, $sql);
    # Kullaniciya profil fotografi icin default fotograf secimi
    if (mysqli_num_rows($result) > 0) {  
        while ($row = mysqli_fetch_assoc($result)) {
            $userid = $row['kullaniciId'];
            $sql = "INSERT INTO profil (kullaniciId, status) VALUES('$userid',1);";
            mysqli_query($baglan, $sql);
        }
    }

    header("location: ../giris.php?error=none");
    exit();
}
# Siteye giris
function kullaniciGiris($baglan, $username, $password) {
    $kullaniciAdKontrol = kullaniciAdiVar($baglan, $username, $username);
    # Kullanici adı kontrol
    if ($kullaniciAdKontrol === false) {
        header("location: ../giris.php?error=wronglogin");
        exit();
    }
    # Kullanici sifre kontrol
    $hashedPassword = $kullaniciAdKontrol["kullaniciSifre"];
    $passwordCheck = password_verify($password, $hashedPassword);

    if($passwordCheck === false){
        header("location: ../giris.php?error=wronglogin");
        exit();
    }
    # Hata yoksa session baslat
    else if($passwordCheck === true){
        session_start();
        $_SESSION["username"] = $kullaniciAdKontrol["kullaniciAdi"];
        $_SESSION["userid"] = $kullaniciAdKontrol["kullaniciId"];
        $_SESSION["email"] = $kullaniciAdKontrol["kullaniciEposta"];
        header("location: ../index.php?login=success");
        exit();
    }
}
