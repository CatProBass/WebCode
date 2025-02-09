<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
$meals=json_decode(getmealtypes());
$intakes=json_decode(getmealintakes());
$wintakes=json_decode(getwaterintakes());

?>
<div class="row">
				<div class="col-lg-6">
					<h1><span class="headermeals"></span>Ingesta</h1><h3 class="day"><?= fechaCastellano(date("d-m-Y")); ?></h3><div class="clearfix"></div>
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
         
  <label class="form-check-label" for="intake<?=$meal->id;?><?=$i;?>">       <input class="form-check-input" type="radio" name="intake<?=$meal->id;?>" id="intake<?=$meal->id;?><?=$i;?>" value="<?=$intake->id;?>">
	  <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span><?=$intake->name;?></span>
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
             
  <label class="form-check-label" for="intakewater<?=$intake->id;?>">   <input class="form-check-input" type="radio" name="intakewater" id="intakewater<?=$intake->id;?>" value="<?=$intake->id;?>">
	  <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span><?=$intake->name;?></span>
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
                 	
				</div>