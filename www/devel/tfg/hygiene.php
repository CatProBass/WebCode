<?
session_start();
include "inc/functions.php";
conectar();
$idpaciente=1;

 
$patienthygiene=json_decode(get_patient_hygiene($idpaciente));
 
 

?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
 <link href="css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
<title>TFG</title>
</head>

<body><div class="loading">Loading&#8230;</div>
 <? include "navbar.php";?>
    <div id="headerwrap"> <? include "paciente.php";?>
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<h1>Higiene</h1><h3><?= fechaCastellano(date("d-m-Y")); ?></h3>
   <div class="row">
        <div class="col-md-12">
            <form id="sleep">
            	<div class="form-group">
           
            	<h3>Validar higiene diaria </h3>
           <? if($patienthygiene->id!=""){?> 
           	<span class="glyphicon glyphicon-ok activo"></span>	<strong>Validada</strong>	<?}else{?><input name="checked"  data-toggle="toggle" type="checkbox" value="1"  data-on="Validada" data-off="No validada" data-onstyle="success" data-offstyle="danger" >
            	<?}?>
            	</div>
            	<div class="form-group">
            
            	<h3>¿Muestra alguna herida o úlcera por presión?</h3>
            	<? if($patienthygiene->id!=""){?><div class="form-group">
					<span class="glyphicon glyphicon-ok activo"></span> <?if($patienthygiene->wound==0){?> No <?}else{?>Sí<div class="clearfix"></div>
<div class="img-responsive"><img src="img/wounds/1.jpg"></div><?}?>
            	<?}else{?> 
            	<label>		<input type="radio" value="0" name="wound" > No</label>	<div class="clearfix"></div>
            	<label>		<input type="radio" value="1" name="wound" > Sí</label>	
            	<div class="form-group fotoherida">
            	<label for="file">Foto <input type="file" name="file"></label></div>
            	<div class="clearfix"capturePhoto();></div>
            <?}?>
            	</div>
       <button onclick="capturePhoto();">Use Camera</button> <br>     <? if($patientsh->id==""){?>	 <div class="form-group">  <button type="button" class="btn btn-primary b_sendhygiene">Enviar</button> </div>  <?}?>
            	
			 
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
<script src="js/bootstrap-toggle.min.js"></script>
     <script>
$("input[name='wound']").click(
	
function(e){
	if($("input[name='wound']:checked").val()=="1"){
			$(".fotoherida").slideDown()
		
	}else{
	if($(".fotoherida").is(":visible")){
		$(".fotoherida").slideUp()
	}
	}
	
}
)
	 $(".b_sendhygiene").click(function(e){
//habria que validar esto
		 if(!$("input[name='checked']").prop('checked')){alerta("Debe validar la higiene")}else{
	sendhygiene(<?=$idpaciente;?>,$("input[name='checked']").val(),$("input[name='wound']:checked").val());
		} })
	 
		
	 
	 
	
 
     </script>
</body>
</html>