<?php
    include_once 'vt.inc.php';

    # Degiskenler
    $id = $_POST["id"];

    $title = $_POST["title"];
    
    $comment = $_POST["comment"];

   
    # Gorsel guncelleyen satir
    if (isset($_POST["update"])) {
        # SQL update sorgusu
        $sql = "UPDATE galeri SET galeriBaslik='$title', galeriYorum='$comment' WHERE galeriId='$id'";
        if(!mysqli_query($baglan, $sql))
        {
            echo "Hata!";
        }
        else{
            header("location: ../karincalarim.php?update=success");
        }
    }
    else{
        header("location: ../index.php");
    }
?>