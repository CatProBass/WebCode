<?
session_start();
include "inc/functions.php";
conectar();
$idpaciente=1;

$sleephours=json_decode(get_sleep_hours());
$patientasleep=json_decode(get_patient_asleep($idpaciente));
$patientsh=json_decode(get_patient_sleep_hours($idpaciente));
 

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

<body><div class="loading">Loading&#8230;</div>
 <? include "navbar.php";?>
    <div id="headerwrap"> <? include "paciente.php";?>
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<h1>Sueño</h1><h4><?= fechaCastellano(date("d-m-Y")); ?></h4>
   <div class="row">
        <div class="col-md-12">
            <form id="sleep">
            	<div class="form-group">
           
            	<h3>¿Se ha mantenido despierto durante el día? </h3>
           <? if($patientasleep->id!=""){?> 
           	<span class="glyphicon glyphicon-ok activo"></span>	<strong><?if($patientasleep->asleep==0){?> No<?}else{?>Sí<?}?></strong>	<?}else{?><input type="radio" value="0" name="asleep" > No</label>	
            		<div class="clearfix"></div>	<label>
            	
            	<input type="radio" value="1" name="asleep"> Sí</label>	
            	<?}?>
            	</div>
            	<div class="form-group">
            
            	<h3>Horas de sueño nocturnas</h3>
            	<? if($patientsh->id!=""){?><div class="form-group">
					<span class="glyphicon glyphicon-ok activo"></span> <strong><?=$patientsh->name;?></strong></div>
            	<?}else{?><? foreach($sleephours as $slh){?>
            	<label>		<input type="radio" value="<?=$slh->id;?>" name="hours" > <?=$slh->name;?></label>	
            	<div class="clearfix"></div>
            <?}}?>
            	</div>
            <? if($patientsh->id==""){?>	 <div class="form-group">  <button type="button" class="btn btn-primary b_sendsleep">Enviar</button> </div>  <?}?>
            	
			 
            </form>
        </div>
       
    </div>
</div>
                 	
				</div><!-- /col-lg-6 -->
				<div class="col-lg-6">
			 
				</div><!-- /col-lg-6 -->
				
			</div><!-- /row -->
		</div><!-- /container -->
	</div><!-- /headerwrap -->
    <audio  src="audio/blop.mp3" id="blop">
 
     <? include "javascript.php";?>
    <? include "footer.php";?>

     <script>

	 $(".b_sendsleep").click(function(e){
//habria que validar esto
		sendsleep(<?=$idpaciente;?>,$("input[name='asleep']:checked").val(),$("input[name='hours']:checked").val());
		 })
		
	 
	 
	
 
     </script>
</body>
</html>