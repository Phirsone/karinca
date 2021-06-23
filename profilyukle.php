<?php

session_start();



include_once 'includes/vt.inc.php';



$id = $_SESSION['userid'];



if (isset($_POST['submit'])){

    $file = $_FILES['file'];



    $fileName = $_FILES['file']['name'];

    $fileTmpName = $_FILES['file']['tmp_name'];

    $fileSize = $_FILES['file']['size'];

    $fileError = $_FILES['file']['error'];

    $fileType = $_FILES['file']['type'];


    # Dosya uzantisini degistirmek
    $fileExt = explode('.', $fileName);

    $fileActualExt = strtolower(end($fileExt));


    # Izin verilen uzantilar
    $allowed = array('png' , 'jpg', 'jpeg');


    # Uzanti kontrol
    if (in_array($fileActualExt, $allowed)) {

        if ($fileError === 0) {
            # Dosya boyutu 500000 byte'in altinda mi
            if ($fileSize < 500000) {
                # Yuklenen fotografin adi degistiriliyor
                $fileNameNew = "avatar".$id.".".$fileActualExt;

                # Dosya klasore yukleniyor
                $fileDestination = 'profilyuklenenler/'.$fileNameNew;

                move_uploaded_file($fileTmpName, $fileDestination);
                # Veritabaninda default gorseli kaldiran SQL sorgusu
                $sql = "UPDATE profil SET status=0 WHERE kullaniciId='$id';";

                mysqli_query($baglan, $sql);

                header("location: ../profil.php?uploadsuccess");

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