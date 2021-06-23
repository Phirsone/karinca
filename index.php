<?php
# Session basla
session_start();
?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/mainStyle.css">
    <link rel="shortcut icon" type="image/jpg" href="img/logo.png">

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>


    <title>Anasayfa</title>
 
</head>

<body>

    <header> 

        <a href="#" class="logo" style="background-image: url('img/logo.png');"></a>

        <nav>            

            <li><a href="index.php" class="chs">Anasayfa</a></li>

            <li><a href="karinca.php" >Galeri</a></li>

            <?php
                    # Session baslamis ise header icerigini degistir
                    if(isset($_SESSION["username"])){

                    echo '<li><a href="karincalarim.php">Karıncalarım</a></li>';

                    echo '<li><a href="profil.php">Profilim</a></li>';

                    echo '<li><a href="includes/cikis.inc.php">Çıkış Yap</a></li>';
                    if (isset($_GET["login"])) {
                        if ($_GET["login"] == "success") {
                            echo '<script> alertify.success("Giriş Başarılı") </script>';
                        }
                        
                    }
                    }

                    else{

                    echo '<li><a href="giris.php">Giriş Yap</a></li>';

                    }

                ?>

        </nav>

    </header>

    <div class="content">

        <div class="box">

            <div class="box-content">

                <h1>Karıncalar</h2>
                
                <p>Türkiye'de 7789 farklı karınca türü tespit edilmiştir ve bunların 348'i yerlidir.</p>

                <p>Türkiye'de Avrupa, Orta Doğu ve Kuzey Afrika'daki bütün ülkelere kıyasla daha fazla karınca türü bulunmaktadır.</p>

                <p>Bir karınca kolonisinde işçi, drone ve kraliçe karınca bulunur.</p>

                <p>İşçi karıncalar vücut tiplerine göre minor, media ve major olarak 3'e ayrılır ancak her karınca türü 3 vücut tipine sahip işçileri üretemez.</p>

                <p>Drone karıncalar çiftleşmeden önce kanatlıdır. Çiftleştikten sonra dişi drone karıncalar kraliçe olarak kanatlarını döker ve claustral döneme geçer. Erkek drone karıncalar ise ölmeyi bekler.  </p>


               

            </div>

        </div>

    </div>

    <footer></footer>

</body>



</html>