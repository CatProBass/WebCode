<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
$idpaciente=1;
$nails=json_decode(getnails());
$patinentnails=json_decode(get_patient_daily_nails($idpaciente));
?>
<div class="row">
				<div class="col-lg-6">
				 
   <div class="row">
        <div class="col-md-12">    <ul class="nav nav-pills nav-stacked">
    <li    <?  if($patinentnails->id!=""){?>class="lleno"<?}?>><a href="javascript:void(0)" data-rel="666">Corte de uñas</a></li><div class="material" id="material666"> 
                <?  if($patinentnails->id==""){?>
             <div class="form-check">
            
               <div class="form-group"> 
              <select name="nail" class="form-control">
              <?
             foreach($nails  as $nail){
			  ?>
              <option value="<?=$nail->id;?>"><?=$nail->name;?></option>
              <?}?>
              </select>
               </div>
             
           <div class="form-group">  <button type="button" class="btn btn-primary b_sendnails">Enviar</button> </div>  </div>   <? }else{ ?>
  
             <span class="glyphicon glyphicon-ok activo" ></span> <strong> <?=$patinentnails->name;?>
           
           <? }?></div> 
        </div>
			</ul>
    </div>
</div>
                 	
				</div> 