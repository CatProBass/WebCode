<?
session_start();
$homepage=true;
include("inc/restrict.php");
include "inc/functions.php";

 header('Access-Control-Allow-Origin: *');  ?><!doctype html>

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
			<div class="row">
				<div class="col-lg-6">
					<h1>Bienvenido</h1>
				 
                 <p>
                 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla arcu leo, vehicula sed lorem lobortis, rutrum faucibus lacus. Pellentesque at lorem quis dui hendrerit facilisis vitae in purus. Nam urna est, suscipit in ex sed, la</p>
                 	
				</div><!-- /col-lg-6 -->
				<div class="col-lg-6">
			 
				</div><!-- /col-lg-6 -->
				
			</div><!-- /row -->
		</div><!-- /container -->
	</div><!-- /headerwrap -->
    
     <? include "javascript.php";?>        <? include "footer.php";?>
</body>
</html>