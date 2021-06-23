<?php
# Session basla
session_start();
# Veritabani cagir
require_once 'includes/vt.inc.php';

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">

    <link rel="shortcut icon" type="image/jpg" href="img/logo.png">

    <title>Karınca Ekle</title>

</head>

<body>

    <header> 

        <a href="#" class="logo" style="background-image: url('img/logo.png');"></a>

        <nav>            

            <li><a href="index.php">Anasayfa</a></li>

            <li><a href="karinca.php" >Galeri</a></li>



                    <?php
                        # Session baslamis ise header icerigini degistir
                        if(isset($_SESSION["username"])){

                        echo '<li><a href="ekle.php" class="chs">Karınca Ekle</a></li>';

                        echo '<li><a href="profil.php" >Profilim</a></li>';

                        echo '<li><a href="includes/cikis.inc.php">Çıkış Yap</a></li>';

                        }

                        else{

                        header("location: ../index.php");

                        }

                    ?>

        </nav>

    </header>



        <div class="profile-box">



            <div class="profile-upper">



            </div>         

            <div class="profile-middle">

            <form action="karincayukle.php" method="POST" enctype="multipart/form-data">

                <label for="file-upload" class="custom-file-upload">

                        Resim Seç

                </label>

                <input id="file-upload" type="file" name="file">

                <br>

                <br>

                <label for="">Başlık</label>
                <!-- Baslik -->       
                <input type="text" name="title" maxlength="20">
    
                <label for="">Açıklama</label>
                <!-- Aciklama -->
                <input type="text" name="comment" maxlength="120" height="40px">

                <br>
                <!-- From buton -->
                <button class="custom-file-upload" type="submit" name="submit">Yükle</button>

            </form>

            <?php
                    # Hata kontrol
                    if (isset($_GET["upload"])) {
                        # Bos alan
                        if ($_GET["upload"] == "empty") {

                            echo "<p style='margin-top:25px; color: #FFFF22;'>Boş alan bırakmayın!</p>";

                        }

                    }

                ?>

            </div>





        </div>

</body>

</html>