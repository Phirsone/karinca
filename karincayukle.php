<?php
# Session basla
session_start();


# Veritabani cagir
include_once 'includes/vt.inc.php';


# Degiskenler
$id = $_SESSION['userid'];

$username = $_SESSION['username'];

# Submit kontrol
if (isset($_POST['submit'])){

    
    # Degiskenler
    $imageTitle = $_POST['title'];

    $imageDesc = $_POST['comment'];

    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];

    # Yeni dosya adi
    $fileName = strtolower(str_replace(" ", "-", $fileName));


    $fileTmpName = $_FILES['file']['tmp_name'];

    $fileSize = $_FILES['file']['size'];

    $fileError = $_FILES['file']['error'];

    $fileType = $_FILES['file']['type'];

    
    $fileExt = explode('.', $fileName);

    $fileActualExt = strtolower(end($fileExt));


    # Izin verilen dosya uzantilari
    $allowed = array('png', 'jpg', 'jpeg');


    # Uzanti kontrol
    if (in_array($fileActualExt, $allowed)) {
        # Hata
        if ($fileError === 0) {
            # Dosya boyutu kontrol
            if ($fileSize < 2000000) {
                # Yeni dosya adi
                $fileNameNew = "karinca".$id.$username.uniqid("", true).".".$fileActualExt;
                # Dosya yolu
                $fileDestination = 'karincayuklenenler/'.$fileNameNew;
                # Baslik ya da aciklama bos mu
                if (empty($imageTitle) || empty($imageDesc)) {

                    header("location: /ekle.php?upload=empty");

                    exit();

                }

                else{
                    # galeri tablosundaki butun verileri cek
                    $sql = "SELECT * FROM galeri;";
                    # stmt prepare hazirla
                    $stmt = mysqli_stmt_init($baglan);
                    # SQL sorgusu, veritabani kontrol
                    if (!mysqli_stmt_prepare($stmt, $sql)) {

                        echo "Hata!";

                    }

                    else{
                        # stmt calistir
                        mysqli_stmt_execute($stmt);
                        # stmt sonuclarini degiskene ata
                        $result = mysqli_stmt_get_result($stmt);
                        # Sonuc satir sayisi 
                        $rowCount = mysqli_num_rows($result);

                        $setImageOrder = $rowCount + 1;


                        # galeri tablosuna gerekli verileri aktaran SQL sorgusu
                        $sql = "INSERT INTO galeri (galeriBaslik, galeriYorum, galeriResimTamIsim, galeriKullanici, galeriSira) VALUES (?, ?, ?, ?, ?);";

                        
                        # SQL sorgusu, veritabani kontrol
                        if (!mysqli_stmt_prepare($stmt, $sql)) {

                            echo "Hata!";

                        }
                        
                        else{
                            # stmt'ye gerekli degiskenleri bagla
                            mysqli_stmt_bind_param($stmt, "sssss", $imageTitle, $imageDesc, $fileNameNew, $username, $setImageOrder);
                            # stmt calistir
                            mysqli_stmt_execute($stmt);

                            
                            # dosyayi tasi
                            move_uploaded_file($fileTmpName, $fileDestination);
                            # profil sayfasina yonlendir
                            header("location: ../profil.php?upload=success");

                        }



                    }

                }

            }

            else{

                echo "Yüklemeye çalıştığınız dosya çok büyük";

            }

        }

        else{

            echo "Dosyayı yüklerken bir hata oluştu!";

        }

    }

    else{

        echo "Bu uzantıda bir dosyayı yükleyemezsin!";

    }

}