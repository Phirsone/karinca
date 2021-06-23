<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/jpg" href="img/logo.png">
    <title>Güncelle</title>
</head>
<body>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>
<?php
# Sil
if (isset($_POST["remove"])) {
    $id = $_POST["id"];
    # Uyari
    echo '<script>
            alertify.confirm("Resim sil", "Silmek istediğinize emin misin?",
        function(){
            window.location.href = "../karincalarim.php?delete=ongoing&remove='.$id.'";
            },
        function(){
            window.location.href = "../karincalarim.php?delete=cancel";
            });
        </script>';
    }
    # Degistir
    else if (isset($_POST["edit"])) {
        # Degiskenler
        $id = $_POST["id"];
        $title = $_POST["title"];
        $comment = $_POST["comment"];
        $img = $_POST["img"];
        # Guncellenecek olan icerigi goster
        echo '
        <div class="profile-box">
        <form action="includes/guncelle.php" method="POST">
        <div class="profile-upper">
        <div class="profile-image">
        <img src="karincayuklenenler/'.$img.'" alt="">
        </div>
        </div>
        <div class="profile-middle">
        <input type=hidden name="id" value="'.$id.'">
        <input type=hidden name="img" value="'.$img.'">
        <label for="">Başlık</label>
        <input type=text name="title" maxlength="20" value="'.$title.'">
        <label for="">Açıklama</label>
        <input type=text name="comment" maxlength="120" value="'.$comment.'">
        </div>
        <div class="profile-lower">
		<button class="custom-file-delete">Geri Dön</button>
        <button class="custom-file-edit" type="submit" name="update">Güncelle</button>
        </div>
        </form>
        </div>';
        

    }
    else{
        header("location: ../index.php");
    }
    
?>
    
</body>
</html>
