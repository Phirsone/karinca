<?php



if (isset($_POST["reset-password-submit"])) {

    
    # Parametreler
   $selector = $_POST["selector"];

   $validator=$_POST["validator"];

   $password=$_POST["pwd"];

   $passwordRepeat=$_POST["pwd-repeat"];


    # Sifre bos mu
   if (empty($password) || empty($passwordRepeat)) {

       header("location: ../create-new-password.php?selector=".$selector."&validator=".$validator."&newpwd=empty");

       exit();

   }
   # Sifre 6 basamaktan uzun mu
   else if(strlen($password) < 6 || strlen($passwordRepeat) < 6){

       header("location: ../create-new-password.php?selector=".$selector."&validator=".$validator."&newpwd=pwdweak");

       exit();

   }
   # Sifreler ayni mi
   else if ($password != $passwordRepeat){

        header("location: ../create-new-password.php?selector=".$selector."&validator=".$validator."&newpwd=pwdnotsame");

        exit();

   }

   
   # Anlik zaman
   $currentDate = date("U");



   require 'vt.inc.php';


   # Sifre yenileme linkini kontrol eden SQL sorgusu 
   $sql = "SELECT * FROM  pwdreset WHERE pwdResetSelector=? AND pwdResetExpires >= ? ";



   $stmt = mysqli_stmt_init($baglan);
   # SQL ve veritabani kontrol
    if (!mysqli_stmt_prepare($stmt,$sql)) {

        echo "Hata2-1!";

        exit();

    }

    else{
        # Selector ve anlik zamani stmt'de bagla
        mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
        
        mysqli_stmt_execute($stmt);
        # SQL sorgu sonuclarını degiskene atama
        $result = mysqli_stmt_get_result($stmt);
        # Row degiskenine ilisik olanlari atama
        if (!$row = mysqli_fetch_assoc($result)) {

            echo "Hata2-2";

            exit();

        }

        else{
            # Tokeni hex'i binary'e ceviren fonksiyon
            $tokenBin = hex2bin($validator);
            # Token kontrol fonksiyon
            $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);


            # Token yanlis ise hata mesaji ve fonksiyondan cikis
            if ($tokenCheck === false) {

                echo "Hata2-3.";

                exit();

            }
            # Token dogru ise 
            else if($tokenCheck === true){
                # Veritabanindan e-posta'yi degiskene tanimla
                $tokenEmail = $row['pwdResetEmail'];
                # Kullanici tablosundan kullanici e-postasini al
                $sql = "SELECT * FROM kullanici WHERE kullaniciEposta=?;";

                $stmt = mysqli_stmt_init($baglan);
                # SQl sorgusu, veritabani kontrol hatali
                if (!mysqli_stmt_prepare($stmt,$sql)) {

                    echo "Hata2-4!";

                    exit();

                }
                # SQL sorgusu, veritabani dogru
                else{
                    # E-postayi stmt degiskenine bagla 
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    # stmt calistir
                    mysqli_stmt_execute($stmt);
                    # stmt sonuclarini degiskene atama
                    $result = mysqli_stmt_get_result($stmt);
                    # result ile ilisikleri row'a atama kontrol
                    if (!$row = mysqli_fetch_assoc($result)) {

                        echo "Hata2-5";

                        exit();

                    }
                    # Ilisik atama sorunsuz ise
                    else{
                        # Kullanici tablosundan dogru e-postaya sahip kullanicinin sifresini guncelleyecek olan SQL sorgusu
                        $sql = "UPDATE kullanici SET kullaniciSifre=? WHERE kullaniciEposta=?";


                        # Prepare icin stmt'yi hazirlama
                        $stmt = mysqli_stmt_init($baglan);
                        # SQL sorgusu, veritabani kontrol hatali
                        if (!mysqli_stmt_prepare($stmt,$sql)) {

                            echo "Hata2-6!";

                            exit();

                        }
                        # SQL sorgusu, veritabani dogru
                        else{
                            # Sifreyi hash'leyen fonksiyon
                            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                            # E-postayi ve sifreyi stmt degiskenine bagla
                            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                            # stmt calistir
                            mysqli_stmt_execute($stmt);

                            
                            # Veritabanindan sifre degistirenin e-postasi ile eslesen satiri silecek olan SQL sorgusu 
                            $sql="DELETE FROM pwdreset WHERE pwdResetEmail=?";
                            # Prepare icin stmt'yi hazirlama 
                            $stmt = mysqli_stmt_init($baglan);
                            # SQL sorgu, veritabani kontrol hatali
                            if (!mysqli_stmt_prepare($stmt,$sql)) {

                                echo "Hata2-7";

                                exit();

                            }
                            # SQL sorgu, veritabani dogru
                            else{

                                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);

                                mysqli_stmt_execute($stmt);
                                # Giris sayfasina yonlendir
                                header("location: ../giris.php?newpwd=passwordupdated");

                                

                            }
                        }
                    }
                }
            }
        }
    }
}

else{

    header("location: ../index.php");

}