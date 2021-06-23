<!DOCTYPE html>

<html lang="tr" dir="ltr">

<head>

	<meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Şifre Değiştir</title>

	<link rel="stylesheet" type="text/css" href="style.css">

	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">

	<link rel="shortcut icon" type="image/jpg" href="img/logo.png"/>

	<script src="https://kit.fontawesome.com/a81368914c.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1">

</head>



<body background="../images/loginbg.jpg">

	

	<div>



		<div>

			<?php 
				# Degiskenler

			    $selector = $_GET["selector"];

			    $validator = $_GET["validator"];

			    

			    

			    
				# Selector ya da validator bos mu
			    if(empty($selector) || empty($validator)){

			        echo "Bir hata oluştu!";

			    }

			    else {
					# Karakterler hexadecimal kontrol
			        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){

			            ?> 

			                <div class="profile-box">
							<!-- Sifre degistir form-->
			                <form action="includes/reset-password.inc.php" method="POST" >

			                    <div class="profile-upper">

                				<img src="profilyuklenenler/avatar.svg" style="margin-top:5vh;">

                				</div>

                				 <div class="profile-middle">

                				<h2>Lütfen yeni şifrenizi belirleyiniz</h2>

                				<input type="hidden" name="selector" value="<?php echo $selector; ?>">

                                <input type="hidden" name="validator" value="<?php echo $validator; ?>">

                                <div>

                           		   <div>

                           		   		<i class="fas fa-lock"></i>

                           		   </div>

                           		   <div>

                           		   		<h5>Şifre</h5>
								<!-- Sifre -->
                                <input type="password" name="pwd">

                                </div>

                           		</div>

                           		<div>

                           		   <div> 

                           		    	<i class="fas fa-lock"></i>

                           		   </div>

                           		   <div>

                           		    	<h5>Şifre Tekrar</h5>
								<!-- Sifre tekrar-->
                                <input type="password" name="pwd-repeat" >

                                </div>

                                </div>

                        	    </div>

                        	    <div class="profile-lower">
								<!-- Sifre degistir buton -->
                                <button type="submit" class="custom-file-upload" name="reset-password-submit">Şifreni Yenile</button>
			
                                </div>
								<?php
									# Yeni sifre hata yakalama
									if(isset($_GET["newpwd"])) {
										# Bos alan
										if($_GET["newpwd"] == "empty") {
					
											echo "Lütfen boş alan bırakmayın!";
					
										}
										# Sifre 6 basamaktan kısa
										else if($_GET["newpwd"] == "pwdweak") {
					
											echo "<p>Lütfen 6 basamak ya da daha uzun bir şifre giriniz! </p> ";
					
										}
					
										
										# Sifreler ayni degil
										else if ($_GET["newpwd"] == "pwdnotsame") {
					
											echo "<p>Yazdığınız şifrelerin aynı olmasına dikkat edin!</p>";
					
										}
					
									}
								?>

                            </form>

                            </div>

                            

			            <?php

			        }

			    }

			?>

			

			

			

        </div>

    </div>

</body>

</html>