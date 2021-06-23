<!DOCTYPE html>

<html lang="tr" dir="ltr">

<head>

	<meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Şifre Değiştir</title>

	<link rel="stylesheet" type="text/css" href="css/mainStyle.css">

	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">

	<link rel="shortcut icon" type="image/jpg" href="../img/logo.png"/>

</head>





<body>

	

	<div class="profile-box">

		<div style="margin-bottom:10vh;"></div>

		<div class="profile-middle">
			<!-- E-posta yollama form -->
			<form action="includes/reset-request.inc.php" method="POST">

				<img src="profilyuklenenler/avatar.svg">

				<h2>Doğrulama Linki Yollayın</h2>

				<h5>E-Posta</h5>
				<!-- E-posta -->
				<input type="text" name="email">

				<div class="profile-lower">
				<!-- Geri buton-->
				<button class="custom-file-delete" onclick="location.href ='index.php'">Geri</button>
				<!-- Yolla buton-->
				<button class="custom-file-upload" type="submit" name="reset-request-submit">Yolla</button>

				</div>

            	

            </form>

            <?php
			# reset kontrol
            if (isset($_GET["reset"])) {
				# Basarili bildirim
                if ($_GET["reset"] == "success") {

                    echo "<p>E-posta başarı ile yollandı!&nbsp&nbsp</p>";

                    echo "<a href='../index.php' style='text-decoration: none; color: #22FF22;'> Geri Dön</a>";

                }

            }

        

            ?>

			

        </div>

    </div>

</body>

</html>