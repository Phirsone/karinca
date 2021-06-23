<?php

    session_start();

?>

<!DOCTYPE html>

<html lang="tr">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/loginStyle.css">

    <link rel="shortcut icon" type="image/jpg" href="../img/logo.png"/>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>



    <title>Üyelik</title>

</head>

<body>

    <header> 

        <a href="#" class="logo" style="background-image: url('img/logo.png');"></a>

        <nav>

            

            <li><a href="index.php" >Anasayfa</a></li>

            <li><a href="karinca.php">Galeri</a></li>

            <?php
                # Session baslamis ise header icerigini degistir
                if(isset($_SESSION["username"])){

                echo '<li><a href="profil.php">Profilim</a></li>';

                echo '<li><a href="includes/cikis.inc.php">Çıkış Yap</a></li>';

                }

                else{

                echo '<li><a href="giris.php" class="chs">Giriş Yap</a></li>';

                }

            ?>

        </nav>

    </header>




        <!-- Kayit ve Giris ekrani -->
    <div class="sign">

        <div class="container">

            <div class="blueBg">

                <div class="box signin">

                    <h2>Zaten hesabın var mı?</h2>

                    <button class="signinBtn">Giriş</button>

                </div>



                <div class="box signup">

                    <h2>Hesabın yok mu?</h2>

                    <button class="signupBtn">Kayıt</button>

                </div>

            </div>

            <div class="formBox">

            <img class="ant" src="img/anttransparent.png" alt="" width="50" height="30">

                <div class="form signinForm">
                <!-- Giris formu-->
                    <form action="includes/giris.inc.php" method="POST">

                        <h3>Giriş</h3>

                        <input type="text" placeholder="İsim / E-posta" name="username">

                        <input type="password" placeholder="Şifre" name="password">

                        <input type="submit" value="Giriş" name="submit">

                        <a href="reset-password.php" class="forgot">Şifremi Unuttum</a>

                    </form>

                    <br>

                    <?php
                    # Giris geri bildirim
                    if(isset($_GET["newpwd"])) {

                        if($_GET["newpwd"] == "passwordupdated") {

                            echo "<script> alertify.success('Şifre değiştirildi!');</script>";
                        }

                    }

                    if(isset($_GET["error"])) {
                        # Giris bos alan
                        if($_GET["error"] == "emptyinputlogin") {

                            echo "Lütfen boş alan bırakmayın!";
                            echo "<script> alertify.error('Hata!');</script>";


                        }
                        # Hatali sifre
                        else if($_GET["error"] == "wronglogin") {

                            echo "<p>Kullanıcı adı ya da şifre hatalı!</p>";
                            echo "<script> alertify.error('Hata!');</script>";
                        }  

                    }

			

			            ?>

                </div>

                <div class="form signupForm">
                     <!-- Kayit formu-->
                    <form action="includes/kayit.inc.php" method="POST">

                        <h3>Kayıt</h3>
                        <!-- Kullanici adi-->
                        <input type="text" placeholder="İsim" name="username">
                        <!-- Eposta -->
                        <input type="email" placeholder="Email" name="email">
                        <!-- Sifre-->
                        <input type="password" placeholder="Şifre" name="password">
                        <!-- Sifre Tekrar-->
                        <input type="password" placeholder="Şifre Tekrar" name="passwordrep">
                        <!-- Kayit formu buton-->
                        <input type="submit" value="Kayıt" name="submit">



                    </form>

                    <br>

                    <?php
                        # Kayit geri bildirim
                        if(isset($_GET["error"])) {
                            # Kayit bos alan
                            if($_GET["error"] == "emptyinputsignup") {
                                # Hata mesaji
                                echo "Lütfen boş alan bırakmayın!";
                                # Javascript geri bildirim mesaji popup
                                echo "<script>const formBox = document.querySelector('.formBox');

                                const body = document.querySelector('body');

                                formBox.classList.add('active');

                                body.classList.add('active');

                                alertify.error('Hata!');

                                </script>";

                            }
                            # Kayit sifre zayif
                            else if($_GET["error"] == "weakpass") {

                                echo "<p>Lütfen 6 basamak ya da daha uzun bir şifre giriniz! </p> ";

                                echo "<script>const formBox = document.querySelector('.formBox');

                                const body = document.querySelector('body');

                                formBox.classList.add('active');

                                body.classList.add('active');

                                alertify.error('Hata!');

                                </script>";

                            }
                            # Kullanici adi karakter hatasi
                            else if($_GET["error"] == "invalidusername") {

                                echo "<p>Lütfen kullanıcı isminizde harf ve rakam harici karakter kullanmayınız!</p>";

                                echo "<script>const formBox = document.querySelector('.formBox');

                                const body = document.querySelector('body');

                                formBox.classList.add('active');

                                body.classList.add('active');

                                alertify.error('Hata!');

                                </script>";

                            }
                            # Kullanici adi kullaniliyor
                            else if ($_GET["error"] == "usernametaken") {

                                echo "<p>Kullanıcı adı zaten kullanılıyor!</p>";

                                echo "<script>const formBox = document.querySelector('.formBox');

                                const body = document.querySelector('body');

                                formBox.classList.add('active');

                                body.classList.add('active');

                                alertify.error('Hata!');

                                </script>";

                            }
                            # Eposta hatali
                            else if ($_GET["error"] == "invalidemail") {

                                echo "<p>E-posta geçerli değil!</p>";

                                echo "<script>const formBox = document.querySelector('.formBox');

                                const body = document.querySelector('body');

                                formBox.classList.add('active');

                                body.classList.add('active');

                                alertify.error('Hata!');

                                </script>";

                            }
                            # Sifreler eslesmiyor
                            else if ($_GET["error"] == "passmatchfail") {

                                echo "<p>Yazdığınız şifrelerin aynı olmasına dikkat edin!</p>";

                                echo "<script>const formBox = document.querySelector('.formBox');

                                const body = document.querySelector('body');

                                formBox.classList.add('active');

                                body.classList.add('active');

                                alertify.error('Hata!');

                                </script>";

                            }
                            # Hata yok
                            else if ($_GET["error"] == "none") {

                                echo "<script>

                                alertify.success('Kayıt Başarılı!');

                                </script>";

                            }

                            

                        }

			

			            ?>

                </div>            

            </div>

        </div>

    </div>



    <script>
        // CSS class degistiren javascript kodu
        const signinBtn = document.querySelector('.signinBtn');

        const signupBtn = document.querySelector('.signupBtn');

        const formBox = document.querySelector('.formBox');

        const body = document.querySelector('body');


        // Class'in sonuna 'active' ekleyen satir
        signupBtn.onclick=function(){

            formBox.classList.add('active');

            body.classList.add('active');

        }
        // Class'in sonuna 'active' silen satir
        signinBtn.onclick=function(){

            formBox.classList.remove('active');

            body.classList.remove('active');

        }

    </script>

</body>

</html>