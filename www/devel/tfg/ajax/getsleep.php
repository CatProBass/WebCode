<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
 
$sleephours=json_decode(get_sleep_hours());
$patientasleep=json_decode(get_patient_asleep($idpaciente));
$patientsh=json_decode(get_patient_sleep_hours($idpaciente));
?>

<div class="row">
				<div class="col-lg-6">
					<h1><span class="headersleep"></span>Sueño</h1><h3 class="day"><?= fechaCastellano(date("d-m-Y")); ?></h3><div class="clearfix"></div>
   <div class="row">
        <div class="col-md-12">
            <form id="sleep">
            	<div class="form-group">
           
            	<h3>¿Se ha mantenido despierto durante el día? </h3>
           <? if($patientasleep->id!=""){?> 
           	<span class="glyphicon glyphicon-ok activo"></span>	<strong><?if($patientasleep->asleep==0){?> No<?}else{?>Sí<?}?></strong>	<?}else{?><label><input type="radio" value="0" name="asleep" > <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> No</span></label>	
            		<div class="clearfix"></div>	<label>
            	
            	<input type="radio" value="1" name="asleep"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Sí</span></label>	
            	<?}?>
            	</div>
            	<div class="form-group">
            
            	<h3>Horas de sueño nocturnas</h3>
            	<? if($patientsh->id!=""){?><div class="form-group">
					<span class="glyphicon glyphicon-ok activo"></span> <strong><?=$patientsh->name;?></strong></div>
            	<?}else{?><? foreach($sleephours as $slh){?>
					<label>		<input type="radio" value="<?=$slh->id;?>" name="hours" ><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span>  <?=$slh->name;?></span></label>	
            	<div class="clearfix"></div>
            <?}}?>
            	</div>
            <? if($patientsh->id==""){?>	 <div class="form-group">  <button type="button" class="btn btn-primary b_sendsleep">Enviar</button> </div>  <?}?>
            	
			 
            </form>
        </div>
       
    </div>
</div>
                 	
				</div> 