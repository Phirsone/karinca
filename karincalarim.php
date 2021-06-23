<?php

    session_start();

    require_once "includes/vt.inc.php"

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


    <title>Karınca</title>

</head>

<body>

    <header> 

        <a href="#" class="logo" style="background-image: url('img/logo.png');"></a>

        <nav>

            

            <li><a href="index.php" >Anasayfa</a></li>

            <li><a href="karinca.php" >Galeri</a></li>

            <?php
                # Session baslamis ise header icerigini degistir
                if(isset($_SESSION["username"])){

                echo '<li><a href="karincalarim.php" class="chs">Karıncalarım</a></li>';

                echo '<li><a href="profil.php">Profilim</a></li>';

                echo '<li><a href="includes/cikis.inc.php">Çıkış Yap</a></li>';

                }

                else{

                echo '<li><a href="giris.php">Giriş Yap</a></li>';

                }

            ?>

        </nav>

    </header>

    <div class="content">

        <div class="box">

            <div class="karinca-box-content">


                <?php
                    # Degiskenler
                    $user = $_SESSION['username'];
                    # Giris yapan kullanicinin yuklemelerini veritabanindan ceken SQL sorgusu
                    $sql = "SELECT * FROM galeri WHERE galeriKullanici = '$user' ORDER BY galeriId DESC";
                    # stmt prepare hazirla
                    $stmt = mysqli_stmt_init($baglan);
                    # SQl sorgu, veritabani kontrol
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "hata";
                    }

                    else{
                        # stmt calistir
                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);
                        # Kullanici adi 'Admin' ise
                        if ($user == "Admin") {
                            # Gelen gorselleri galeriId'ye gore siralayan SQL sorgusu
                            $sql = "SELECT * FROM galeri ORDER BY galeriId DESC";
                            # SQL sorgusu, veritabani kontrol
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "hata";
                            }
                            
                            else{
                                # stmt calistir
                                mysqli_stmt_execute($stmt);
                                # stmt sonuclarini degiskene ata
                                $result = mysqli_stmt_get_result($stmt);
                                # result ile ilisik degerleri row'a ata
                                while ($row = mysqli_fetch_assoc($result)) {
                                    
                                    echo '<div class="karinca-card">
        
                                    <form action="karincaguncelle.php" method="POST">
        
                                    <button class="custom-file-edit" type="submit" name="edit">Güncelle</button>
                                    <button class="custom-file-delete" type="submit" name="remove">Kaldır</button>
            
                                    <img src="karincayuklenenler/'.$row['galeriResimTamIsim'].'" alt="">
        
                                    <h4>'.$row["galeriBaslik"].'</h4>
        
                                    <h3>'.$row["galeriKullanici"].'</h3>
        
                                    <p>'.$row["galeriYorum"].'</p>
        
                                    <input type="hidden" name="img" value="'.$row['galeriResimTamIsim'].'">
                                    <input type="hidden" name="id" value="'.$row['galeriId'].'">
                                    <input type="hidden" name="title" value="'.$row['galeriBaslik'].'">
                                    <input type="hidden" name="comment" value="'.$row['galeriYorum'].'">
        
                                    </form>
        
                                    </div>';

        
                                }
                            }
                            
                        }
                        else{
                             # result ile ilisik degerleri row'a ata
                            while ($row = mysqli_fetch_assoc($result)) {
                                
                                echo '<div class="karinca-card">

                                <form action="karincaguncelle.php" method="POST">

                                <button class="custom-file-edit" type="submit" name="edit">Güncelle</button>
                                <button class="custom-file-delete" type="submit" name="remove">Kaldır</button>

                                <img src="karincayuklenenler/'.$row['galeriResimTamIsim'].'" alt="">

                                <h4>'.$row["galeriBaslik"].'</h4>

                                <h3>'.$row["galeriKullanici"].'</h3>

                                <p>'.$row["galeriYorum"].'</p>
                                <input type="hidden" name="img" value="'.$row['galeriResimTamIsim'].'">
                                <input type="hidden" name="id" value='.$row["galeriId"].'>
                                <input type="hidden" name="title" value="'.$row["galeriBaslik"].'">
                                <input type="hidden" name="comment" value="'.$row["galeriYorum"].'">
                                
                                </form>

                                </div>';
                            }
                        }

                    }
                    # Sil
                    if (isset($_GET["delete"])) {
                        # Delete islem kontrol
                        if ($_GET["delete"] == "ongoing") {
                            # remove degerini degiskene ata
                            $rowId = $_GET['remove'];
                            # rowId'ye veritabaninda denk gelen satiri silen SQL sorgusu
                            $sql = "DELETE FROM galeri WHERE galeriId = $rowId";
                            # stmt prepare hazirla
                            $stmt = mysqli_stmt_init($baglan);
                            # SQL sorgusu, veritabani kontrol
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "Hata!";
                            }
                            # stmt calistir
                            else{
                                mysqli_stmt_execute($stmt);
                            }
                            # karincalari.php?delete=succes sayfasina yolla
                            echo '<script>window.location.href = "../karincalarim.php?delete=success";</script>';
                            
                        } 
                        # Silme iptal bildirim
                        if ($_GET["delete"] == "cancel") {
                            
                            echo '<script> alertify.warning("Silme iptal!") </script>';
                        }
                        # Silme basarili bildirim
                        if ($_GET["delete"] == "success") {
                            echo '<script> alertify.success("Silme başarılı!") </script>';
                        }
                    }
                    # Guncelleme basarili bildirim 
                    if (isset($_GET["update"])) {
                        if ($_GET["update"] == "success") {
                            echo '<script> alertify.success("Güncellendi!") </script>';
                        }
                    }

                ?>

            </div>

        </div>

    </div>

</body>

</html>