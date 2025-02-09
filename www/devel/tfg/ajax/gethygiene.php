<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
$patienthygiene=json_decode(get_patient_hygiene($idpaciente));

?>

<div class="row">
				<div class="col-lg-6">
					<h1><span class="headerhygiene"></span>Higiene</h1><h3 class="day"><?= fechaCastellano(date("d-m-Y")); ?></h3><div class="clearfix"></div>
   <div class="row">
        <div class="col-md-12">
            <form id="sleep">
            	<div class="form-group">
           
            	<h3>Validar higiene diaria </h3>
           <? if($patienthygiene->id!=""){?> 
           	<span class="glyphicon glyphicon-ok activo"></span>	<strong>Validada</strong>	<?}else{?><input name="checked"  data-toggle="toggle" type="checkbox" value="1"  data-on="Validada" data-off="No validada" data-onstyle="success" data-offstyle="danger" >
            	<?}?>
            	</div>
                
                <div class="form-group  <? if($patienthygiene->id==""){?> hidden<?}?>" id="opcioneshigiene" >
           
            	<h3>Aplicación crema hidratante</h3>
           <? if($patienthygiene->id!=""){?> 
           	<span class="glyphicon glyphicon-ok activo"></span>	<strong><? if($patienthygiene->cream==1){?>Sí<?}else{?>No<?}?></strong>	<?
            }else{      
         ?>      <label for="cream"><input name="cream" id="cream"  type="checkbox" value="1" ><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i> <span> 
				</span>	</label>
            	<?}?>
            	</div>
                
                <div class="form-group <? if($patienthygiene->id==""){?> hidden<?}?> " id="opcioneshigiene2" >
           
            	<h3>Validar higiene diaria </h3>
           <? if($patienthygiene->id!=""){?> 
           	<span class="glyphicon glyphicon-ok activo"></span>	<strong><?=$hygienetype[$patienthygiene->type];?></strong>	<?
            }else{      
                 for($ht=0;$ht<count($hygienetype);$ht++){ ?> 
					<label for="type<?=$ht;?>"> <input type="radio" name="type"  id="type<?=$ht;?>" value="<?=$ht;?>"/>  <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span><?=$hygienetype[$ht];?></span></label><div class="clear"></div><?}?>
            	<?}?>
            	</div>
                
            	<div class="form-group">
            
            	<h3>¿Muestra alguna herida o úlcera por presión?</h3>
            	<? if($patienthygiene->id!=""){?><div class="form-group">
					<span class="glyphicon glyphicon-ok activo"></span> <?if($patienthygiene->wound==0){?> No <?}else{?>Sí<div class="clearfix"></div>
<div class="img-responsive"><img id="smallImage"  style="width:80%;height:auto; margin-top:20px;margin-left:10%;" src="<?=SITE_URL;?>img/wounds/<?=$patienthygiene->photo;?>"></div><?}?>
            	<?}else{?> 
					<label for="wound1">	<input id="wound1" type="radio" value="0" name="wound" >	  <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> No</span></label>	<div class="clearfix"></div>
						<label for="wound2">	<input  id="wound2" type="radio" value="1" name="wound" >  <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span>	 Sí</span></label>	
            	<div class="form-group fotoherida">
          <!--  <div><	<label for="file">Foto <input type="file" name="file"></label>
                 </div>         	/-->
			  <button type="button" class="btn btn-primary" onClick="capturePhoto()"><i class="glyphicon glyphicon-camera"></i> Sacar foto</button> <div class="cameraimage">
                
                </div>
                <input type="hidden" name="photo" />
            	<div class="clearfix"></div>
            <?}?>
            	</div>
            <? if($patienthygiene->id==""){?>	 <div class="form-group">  <button type="button" class="btn btn-primary b_sendhygiene">Enviar</button> </div>  <?}?>
  
              <img id="smallImage"  style="width:80%;height:auto; margin-top:20px;margin-left:10%;"/>
              </div>
            </form>
        </div>
       
    </div>
</div>
                 	
				</div> 