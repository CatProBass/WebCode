<?
session_start();
include "inc/functions.php";
 

?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
<title>TFG</title>
</head>

<body>
 <? include "navbar.php";?>
    <div id="headerwrap"> <? include "paciente.php";?>
		<div class="container">
		  <div class="container">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" id="inputUser" class="form-control" placeholder="Usuario" required autofocus>
                <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="1" id="remember"> Recordar
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="button">Acceder</button>
                
            </form><!-- /form -->
            <div class="alertalogin">
            <div class="alert alert-danger centered" role="alert">
 
</div>
            </div>
            <a href="#" class="forgot-password"><input name="enviado" type="hidden" value="1">
           ¿Olvidó su contraseña?
            </a>
        </div><!-- /card-container -->
    </div><!-- /container -->
	</div><!-- /headerwrap -->
    
     <? include "javascript.php";?>        <? include "footer.php";?><script> 
	 
	 $(".btn-signin").click(trylogin);
  loadProfile();</script>
</body>
</html>