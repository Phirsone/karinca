<?php
# PHP mailer cagirma
use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\SMTP;

session_start();



if (isset($_POST["reset-request-submit"])) {

    $selector = bin2hex(random_bytes(8));

    $token = random_bytes(32);

    
    # Sifre yenileme linki olustur
    $url = "http://emirenes.site/create-new-password.php?selector=".$selector."&validator=". bin2hex($token);


    # Linkin gecersiz olacagi zaman
    $expires = date("U") + 900;

    
    # Veritabanini cagir
    require "vt.inc.php";


    # Kullanici eposta
    $userEmail = $_POST["email"];


    # Veritabanindan sifresini degistiren kullanicinin yenileme linkini silen SQL sorgusu
    $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?;";
    # stmt prepare hazirlama
    $stmt = mysqli_stmt_init($baglan);
    # SQL sorgusu ve veritabani baglanti kontrol
    if (!mysqli_stmt_prepare($stmt,$sql)) {

        echo "Hata1-1!";

        exit();

    }

    else{
        # Kullanici e-postasini stmt degiskenine bagla
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        # stmt calistir
        mysqli_stmt_execute($stmt);

    }


    # Sifre yenileme icin gerekli verileri veritabanina aktarma
    $sql="INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?);";
    # stmt prepare hazirlama
    $stmt = mysqli_stmt_init($baglan);
    # SQL sorgusu ve veritabani baglanti kontrol
    if (!mysqli_stmt_prepare($stmt,$sql)) {

        echo "Hata1-2!";

        exit();

    }

    else{
        # Tokeni hashleyen fonksiyon
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        # stmt degiskenine gerekli verileri bagla
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        # stmt calistir
        mysqli_stmt_execute($stmt);

    }



    mysqli_stmt_close($stmt);

    mysqli_close($baglan);


    # Email icerik degiskenleri
    $to = $userEmail;

    $subject="Reset Your Password";

    $message='Sifre yenileme linkiniz: ';

    $message.='<a href="'. $url .'">'.$url.'</a>';

    

    $headers="From: Emir <destek@emirenes.site>\r\n";

    $headers.="Reply-To: destek@emirenes.site\r\n";

    $headers .= "Content-type: text/html; charset=UTF-8\r\n";







// Gerekli dosyalar?? include ediyoruz

require '../PHPMailer/PHPMailer.php';

require '../PHPMailer/Exception.php';

require '../PHPMailer/SMTP.php';



$mail = new PHPMailer(true);



try {

    //SMTP Sunucu Ayarlar??

    $mail->SMTPDebug = 0;										// DEBUG Kapal??: 0, DEBUG A????k: 2 // Detayl?? bilgi i??in: https://github.com/PHPMailer/PHPMailer/wiki/SMTP-Debugging

    $mail->isSMTP();											// SMTP g??nderimi kullan

    $mail->Host       = 'server.siberdizayn.net.tr';					// Email sunucu adresi. Genellikle mail.domainadi.com olarak kullanilir. Bu adresi hizmet saglayiciniza sorabilirsiniz

    $mail->SMTPAuth   = true;									// SMTP kullanici dogrulama kullan

    $mail->Username   = 'destek@emirenes.site';				// SMTP sunucuda tanimli email adresi

    $mail->Password   = '3dfg04bv10er241GBD';							// SMTP email sifresi

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;			// SSL icin `PHPMailer::ENCRYPTION_SMTPS` kullanin. SSL olmadan 587 portundan g??nderim icin `PHPMailer::ENCRYPTION_STARTTLS` kullanin

    $mail->Port       = 587;									// Eger yukaridaki deger `PHPMailer::ENCRYPTION_SMTPS` ise portu 465 olarak guncelleyin. Yoksa 587 olarak birakin

    $mail->setFrom('destek@emirenes.site', 'Emir Enes'); // Gonderen bilgileri yukaridaki $mail->Username ile ayn?? deger olmali



    //Alici Ayarlar??

    //$mail->addAddress('eeneskara@hotmail.com', 'Enes Kara'); // Al??c?? bilgileri

    $mail->addAddress($userEmail);					// ??kinci al??c?? bilgileri

    //$mail->addReplyTo('YANITADRESI@domainadi.com');			// Al??c??'n??n emaili yan??tlad??????nda farkl?? adrese g??ndermesini istiyorsaniz aktif edin

    //$mail->addCC('CC@domainadi.com');

    //$mail->addBCC('BCC@domainadi.com');



    // Mail Ekleri

    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Attachment ekleme

    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Opsiyonel isim degistirerek Attachment ekleme



    // ????erik

    $mail->isHTML(true); // G??nderimi HTML t??rde olsun istiyorsaniz TRUE ayarlayin. D??z yaz?? (Plain Text) icin FALSE kullanin

	$mail->CharSet = 'utf-8';

    $mail->Subject = $subject;

    $mail->Body    = $message;



    $mail->send();

    header("location: ../reset-password.php?reset=success");

} catch (Exception $e) {

    echo "Ops! Email iletilemedi. Hata: {$mail->ErrorInfo}";

}

    

}

else{

    header("location: ../index.php");

} 