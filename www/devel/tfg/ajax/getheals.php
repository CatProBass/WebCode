<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
$idpaciente=1;
$heals=json_decode(getheals($idpaciente));
 

?>
<div class="row">
				<div class="csol-lg-6">
					<h1><span class="headerheals"></span>Material de la cura </h1><h3><?/*fechaCastellano(date("d-m-Y"));*/?></h3><div class="clearfix"></div>
   <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills nav-stacked">
               <?foreach($heals as $heal){?>
                <li><a href="javascript:void(0)" data-rel="<?=$heal->id;?>"><?=$heal->name;?></a></li><div class="material" id="material<?=$heal->id;?>">
             
                <p><label><input   data-toggle="toggle" type="checkbox" value="<?=$heal->id;?>"  data-on="Cura realizada" data-off="Cura pendiente" data-onstyle="success" data-offstyle="danger"  data-width="200px" > </label></p><?=$heal->description;?>
                </div>
       <?}?>
            
            </ul>
        </div>
       
    </div>
</div>
                 	
				</div><script>
				  <? foreach($heals as $heal){
		  $patientheal=json_decode(get_patient_daily_heal($idpaciente,$heal->id));
		 
 if( $patientheal->id==""){?> 
 	$('#material<?=$heal->id;?> input').bootstrapToggle('off',{width:'100%'});
	  <?}else{?> $('#material<?=$heal->id;?> input').bootstrapToggle('on');<?}}?>
	  
	  </script>