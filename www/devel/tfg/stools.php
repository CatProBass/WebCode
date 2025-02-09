<?
session_start();
include "inc/functions.php";
conectar();
$idpaciente=1;
$urine=json_decode(get_patient_daily_urine($idpaciente));
$stools=json_decode(get_patient_daily_stools($idpaciente));

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
					<h1>Eliminación</h1><h3><?= fechaCastellano(date("d-m-Y")); ?></h3>
   <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills nav-stacked">
              
                <li    <?  if($urine->id!=""){?>class="lleno"<?}?>><a href="javascript:void(0)" data-rel="1">Orina</a></li><div class="material" id="material1"> 
                <?  if($urine->id==""){?>
             <div class="form-check">
               <div class="form-group"> <label for="times">Número de veces</label>
               <input type="number" name="times" class="form-control">
               </div>
               <div class="form-group"> <label for="colour">Color</label>
              <select name="colour" class="form-control">
              <?
              while(list($key,$value)=each($urinecolor)){
			  ?>
              <option value="<?=$key;?>"><?=$value;?></option>
              <?}?>
              </select>
               </div>
               <div class="form-group"> <label for="appearance">Aspecto</label>
              <select name="appearance" class="form-control">
              <?
              while(list($key,$value)=each($urineappearance)){
			  ?>
              <option value="<?=$key;?>"><?=$value;?></option>
              <?}?>
              </select>
               </div>
           <div class="form-group">  <button type="button" class="btn btn-primary b_sendurine">Enviar</button> </div>  </div>   <? }else{ ?>
  <span class="glyphicon glyphicon-ok activo" ></span> <strong> Veces:</strong> <? echo($urine->times);?>  <hr>
             <span class="glyphicon glyphicon-ok activo" ></span> <strong> Apariencia:</strong> <? echo($urineappearance[$urine->appearance]);?>  <hr>
                 <span class="glyphicon glyphicon-ok activo" ></span> <strong> Color:</strong>  <? echo($urinecolor[$urine->colour]);?>
           
           <? }?></div> 
    
       <li    <?  if($stools->id!=""){?>class="lleno"<?}?>><a href="javascript:void(0)" data-rel="2">Heces</a></li><div class="material" id="material2"> 
                <?  if($stools->id==""){?>
             <div class="form-check">
               <div class="form-group"> <label for="times">Número de deposiciones</label>
               <input type="number" name="times" class="form-control">
               </div>
               <div class="form-group"> <label for="colour">Consistencia</label>
              <select name="consistency" class="form-control">
              <?
              while(list($key,$value)=each($stoolconsistency)){
			  ?>
              <option value="<?=$key;?>"><?=$value;?></option>
              <?}?>
              </select>
               </div>
               <div class="form-group"> <label for="appearance">Aspecto</label>
              <select name="appearance" class="form-control">
              <?
              while(list($key,$value)=each($stoolappearance)){
			  ?>
              <option value="<?=$key;?>"><?=$value;?></option>
              <?}?>
              </select>
               </div>
           <div class="form-group">  <button type="button" class="btn btn-primary b_sendstools">Enviar</button> </div>  </div>   <? }else{ ?>
         <span class="glyphicon glyphicon-ok activo" ></span> <strong> Veces:</strong> <? echo($stools->times);?>  <hr>
             <span class="glyphicon glyphicon-ok activo" ></span> <strong> Apariencia:</strong> <? echo($stoolappearance[$stools->appearance]);?>
               <hr>
                 <span class="glyphicon glyphicon-ok activo" ></span> <strong> Consistencia:</strong>  <? echo($stoolconsistency[$stools->consistency]);?>
           
           <? }?></div> 
    
    
            
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
    <? include "footer.php";?>

     <script>
	 
 $(".nav-pills li a").click(function(e){
	 $(".material:visible").slideToggle();
$("#material"+$(e.currentTarget).attr("data-rel")).slideToggle();
 
	 })
	 $(".b_sendurine").click(function(e){
//habria que validar esto
		sendurine(<?=$idpaciente;?>,$("#material1 input[name='times']").val(),$("#material1 select[name='colour']").val(),$("#material1 select[name='appearance']").val());
		 })
		  $(".b_sendstools").click(function(e){
//habria que validar esto
		sendstools(<?=$idpaciente;?>,$("#material2 input[name='times']").val(),$("#material2 select[name='consistency']").val(),$("#material2 select[name='appearance']").val());
		 })
	 
	 
	
 
     </script>
</body>
</html>