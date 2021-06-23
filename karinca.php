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

    <title>Karınca</title>

</head>

<body>

    <header> 

        <a href="#" class="logo" style="background-image: url('img/logo.png');"></a>

        <nav>

            

            <li><a href="index.php" >Anasayfa</a></li>

            <li><a href="karinca.php" class="chs">Galeri</a></li>

            <?php
                # Session baslamis ise header icerigini degistir
                if(isset($_SESSION["username"])){

                echo '<li><a href="karincalarim.php">Karıncalarım</a></li>';

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
                    # Veritabanindan butun resimleri ceken SQL sorgusu
                    $sql = "SELECT * FROM galeri ORDER BY galeriId DESC";

                    $stmt = mysqli_stmt_init($baglan);
                    # SQl sorgusu ve veritabani kontrol 
                    if (!mysqli_stmt_prepare($stmt, $sql)) {

                        echo "hata";

                    }

                    else{

                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);


                        # Veritabanindan sirayla butun gorselleri ceken dongu
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo '<div class="karinca-card">

                                <div style="background-image: url(../karincayuklenenler'.$row["galeriResimTamIsim"].');"></div>

                                <img src="karincayuklenenler/'.$row['galeriResimTamIsim'].'" alt="">

                                <h4>'.$row["galeriBaslik"].'</h4>

                                <h3>'.$row["galeriKullanici"].'</h3>

                                <p>'.$row["galeriYorum"].'</p>



                            </div>';

                        }

                    }

                ?>

            </div>

        </div>

    </div>



</body>

</html>