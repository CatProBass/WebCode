<?
session_start();
include "inc/functions.php";
conectar();
$idpaciente=1;
$heals=json_decode(getheals($idpaciente));
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

<body>
 <? include "navbar.php";?>
    <div id="headerwrap"> <? include "paciente.php";?>
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<h1>Material de la cura </h1><h3><?/*fechaCastellano(date("d-m-Y"));*/?></h3>
   <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills nav-stacked">
               <?foreach($heals as $heal){?>
                <li><a href="javascript:void(0)" data-rel="<?=$heal->id;?>"><?=$heal->name;?></a></li><div class="material" id="material<?=$heal->id;?>"><?=$heal->description;?>
             
                <p><label><input   data-toggle="toggle" type="checkbox" value="<?=$heal->id;?>"  data-on="Cura realizada" data-off="Cura pendiente" data-onstyle="success" data-offstyle="danger" > </label></p>
                </div>
       <?}?>
            
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
    <? include "footer.php";?><script src="js/bootstrap-toggle.min.js"></script>

     <script>
	  $('.material input').bootstrapToggle({width:200})
 $(".nav-pills li a").click(function(e){
	 $(".material:visible").slideToggle();
$("#material"+$(e.currentTarget).attr("data-rel")).slideToggle();
 
	 })
	
$(".material input").change(function(e){
	if($(e.currentTarget).prop('checked')){
	$.ajax({url:"ajax/setdailyheal.php",type:"POST",data:"patient=<?=$idpaciente;?>&id="+$(e.currentTarget).val(),success:function(r){
		if(r.replace(" ","")=="0"){
			alerta("Se produjo un error al guardar los datos");
			$(e.currentTarget).bootstrapToggle('off');
			}
		}})
	}else{
		
		$.ajax({url:"ajax/deletedailyheal.php",type:"POST",data:"patient=<?=$idpaciente;?>&id="+$(e.currentTarget).val(),success:function(r){
		if(r.replace(" ","")=="0"){
			alerta("Se produjo un error al guardar los datos");
			$(e.currentTarget).bootstrapToggle('off');
			}
			
		}})
		
		}
	}) 
	  <? foreach($heals as $heal){
		  $patientheal=json_decode(get_patient_daily_heal($idpaciente,$heal->id));
		 
 if( $patientheal->id==""){?> 
 	$('#material<?=$heal->id;?> input').bootstrapToggle('off');
	  <?}else{?> $('#material<?=$heal->id;?> input').bootstrapToggle('on');<?}}?>
     </script>
</body>
</html>