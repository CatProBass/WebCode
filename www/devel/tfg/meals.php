<?
session_start();
include "inc/functions.php";
conectar();
$idpaciente=1;
$meals=json_decode(getmealtypes());
$intakes=json_decode(getmealintakes());
$wintakes=json_decode(getwaterintakes());
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
					<h1>Ingesta</h1><h3><?= fechaCastellano(date("d-m-Y")); ?></h3>
   <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills nav-stacked">
               <? foreach($meals as $meal){
               
             $mealintake=json_decode(get_patient_meal_intake($idpaciente,$meal->id));  
		 
               ?>
                <li    <?  if($mealintake->id!=""){?>class="lleno"<?}?>><a href="javascript:void(0)" data-rel="<?=$meal->id;?>"> <?  if($mealintake->id!=""){?><span class="glyphicon glyphicon-ok" ></span><?}?> <?=$meal->name;?></a></li><div class="material" id="material<?=$meal->id;?>"><?=$meal->description;?>
                <?  if($mealintake->id==""){?>
             <div class="form-check">
                <p><label for="intake<?=$meal->id;?>">Validar cantidad de la ingesta</label></p>
               <? 
			   $i=1;
			   foreach($intakes as $intake) {?><div class="form-group">
                <input class="form-check-input" type="radio" name="intake<?=$meal->id;?>" id="intake<?=$i;?>" value="<?=$intake->id;?>">
  <label class="form-check-label" for="intake<?=$i;?>">
<?=$intake->name;?>
  </label></div><?
  $i++;}?>
           <div class="form-group">  <button type="button" data-id="<?=$meal->id;?>" class="btn btn-primary b_sendmealintake">Enviar</button> </div>  </div>   <? }else{ ?>
         <span class="glyphicon glyphicon-ok activo" ></span> <strong> <? echo($mealintake->name);?></strong>
           
           <? }?></div><?}?>
    
            <!-- ingesta agua/-->
            <?
              $waterintake=json_decode(get_patient_water_intake($idpaciente));  
			 // print_r($waterintake);
			?>
                      <li    <?  if($waterintake->id!=""){?>class="lleno"<?}?>>  <a href="javascript:void(0)" data-rel="water"><?  if($waterintake->id!=""){?><span class="glyphicon glyphicon-ok" ></span><?}?> Agua</a></li><div class="material" id="materialwater"> 
                <?  if($waterintake->id==""){?>
             <div class="form-check">
                <p><label for="intakewater">Validar cantidad de la ingesta</label></p>
               <? 
			   $i=1;
			   foreach($wintakes as $intake) {?><div class="form-group">
                <input class="form-check-input" type="radio" name="intakewater" id="intakewater" value="<?=$intake->id;?>">
  <label class="form-check-label" for="intakewater">
<?=$intake->name;?>
  </label></div><?
  $i++;}?>
           <div class="form-group">  <button type="button" data-id="water" class="btn btn-primary b_sendmealintake">Enviar</button> </div>  </div>   <? }else{ ?>
         <span class="glyphicon glyphicon-ok activo" ></span> <strong> <? echo($waterintake->name);?></strong>
           
           <? }?></div>
            
            <!--//ingesta agua/-->
            
            
            </ul>
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
    <? include "footer.php";?><script>
	 
 $(".nav-pills li a").click(function(e){
	 $(".material:visible").slideToggle();
$("#material"+$(e.currentTarget).attr("data-rel")).slideToggle();
 
	 })
	 $(".b_sendmealintake").click(function(e){
		 var idmeal=$(e.currentTarget).attr("data-id");
		 console.log(idmeal);
		 if(idmeal=="water"){
			 sendwaterintake(<?=$idpaciente;?>,$("input[name='intake"+idmeal+"']:checked").val());
			 }else{
		sendmealintake(<?=$idpaciente;?>,idmeal,$("input[name='intake"+idmeal+"']:checked").val());}
		 })
	 
	 
	
 
     </script>
</body>
</html>