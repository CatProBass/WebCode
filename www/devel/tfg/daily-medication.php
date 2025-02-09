<?
session_start();
include "inc/functions.php";
conectar();
$idpaciente=1;
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
<link href="css/animate.css" rel="stylesheet" type="text/css">
<title>TFG</title>
</head>

<body>
 <? include "navbar.php";?>
    <div id="headerwrap"> <? include "paciente.php";?>
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<h1>Medicación </h1><h3><?=fechaCastellano(date("d-m-Y"));?></h3>
				<?
				 $patientmedications=json_decode(getpatientmedications($idpaciente));
                $dailymedication=json_decode(getdailymedication($idpaciente));
	 // print_r(  $dailymedication);
				?> 
                
                <table width="100%" class="table medicationtable table-striped">
                
                <tr>
                <th>Hora</th>
                <? foreach($patientmedications as $med){?>
                <th><?=$med->name;?></th>
                <?}?>
                </tr>
                <? for($h=0;$h<24;$h++){
					$h=str_pad($h, 2, '0', STR_PAD_LEFT);
					?>
                <tr scope="row">
                <td><?=$h;?>:00</td>
                 <?  
				 foreach($patientmedications as $med2){?>
                <td><?
				$search=searchForIdHour($med2->id,$h.':00:00',$dailymedication);
				 if($search!=""){
	 if($search[0]=="1"){ 				
					?><i  id="dailymed<?=$search[2];?>" class="glyphicon glyphicon-ok-circle activo" onClick="setdailymedication(<?=$search[2];?>,0)"></i><?}else{?><i class="glyphicon glyphicon-ok-circle inactivo" id="dailymed<?=$search[2];?>"  onClick="setdailymedication(<?=$search[2];?>,1);playblop(this)"><?}?><?}?></td>

                <?}?>
                
                </tr>
                <?}?>
                </table>
                
                 <p>
                 
             
             </p>
                 	
				</div><!-- /col-lg-6 -->
				<div class="col-lg-6">
			 
				</div><!-- /col-lg-6 -->
				
			</div><!-- /row -->
		</div><!-- /container -->
	</div><!-- /headerwrap -->
    <audio  src="audio/blop.mp3" id="blop">
      <? include "javascript.php";?>
    <? include "footer.php";?><script>
     function playblop(e){$(e).addClass('animated tada');$("#blop").trigger("play");}
     </script>
</body>
</html>