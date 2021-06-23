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

    <link rel="stylesheet" href="css/mainStyle.css">

    <link rel="shortcut icon" type="image/jpg" href="img/logo.png">

    <title>Profil</title>

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

                echo '<li><a href="karincalarim.php" >Karıncalarım</a></li>';

                echo '<li><a href="profil.php" class="chs">Profilim</a></li>';

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

                    <?php
                        # Kullanici butun verileri ceken SQL sorgusu
                        $sql = "SELECT * FROM kullanici";
                        # SQL sorgu sonuclarini degiskene ata
                        $result = mysqli_query($baglan, $sql);
                        # result satir 0'dan buyukse 
                        if (mysqli_num_rows($result) > 0) {
                            # result ilisiklerini row'a ata
                            $row = mysqli_fetch_assoc($result); 

                            $id = $_SESSION['userid'];
                            # Profil tablosundan giris yapan kullanicinin id'sine denk gelen satiri secen SQL sorgusu
                            $sqlImg = "SELECT * FROM profil WHERE kullaniciId='$id';";
                            # SQL sorgu sonuclarini degiskene ata
                            $resultImg = mysqli_query($baglan, $sqlImg);
                            # SQL sorgu ilişiklerini degiskene ata
                            while ($rowImg = mysqli_fetch_assoc($resultImg)) {

                                echo "<div class='profile-image'>";

                                if ($rowImg['status'] == 0) {

                                    echo "<img src='profilyuklenenler/avatar".$id.".png' alt=''>";

                                }

                                else {

                                    echo "<img src='profilyuklenenler/avatar.svg'  alt=''>";

                                }

                                echo "</div>";

                            }                             

                            

                        }

                        else{

                            echo "Sitede kayıtlı kullanıcı yok!";

                        }

                    ?>

            </div>

            

            <form action="profilyukle.php" method="POST" enctype="multipart/form-data">

                <label for="file-upload" class="custom-file-upload">

                        Resim Seç

                </label>

                <input id="file-upload" type="file" name="file">

                <button type="submit" name="submit" class="custom-file-upload">Yükle</button>

            </form>

            <div class="profile-middle">



                <label for="">İsim</label>
                <!-- Kullanici adi -->
                <input type="text" value="<?php echo $_SESSION['username']; ?>" disabled>

                <label for="">Email</label>
                <!-- E-posta -->
                <input type="text" value="<?php echo $_SESSION['email']; ?>" disabled>
                
                <label for="">Kayıt Sırası</label>
                <!-- Kayit sirasi -->
                <input type="text" value="<?php echo $_SESSION['userid']; ?>" disabled>

                <?php
                    # upload kontrol
                    if (isset($_GET["upload"])) {
                        # Basarili geri bildirim
                        if ($_GET["upload"] == "success") {

                            echo "<p style='color: #22FF33; position:fixed; left: calc(50% - 12vh)'>Resim Başarıyla Yüklendi!</p>";

                        }

                    }

                ?>

            </div>

            <div class="profile-lower">

                <a href="reset-password.php">Şifremi Unuttum</a>

                <a href="ekle.php">Karınca Ekle</a>                

            </div>

            



        </div>

</body>

</html>