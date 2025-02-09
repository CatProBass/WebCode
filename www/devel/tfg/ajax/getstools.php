<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
$urine=json_decode(get_patient_daily_urine($idpaciente));
$stools=json_decode(get_patient_daily_stools($idpaciente));

?>

<div class="row">
				<div class="col-lg-6">
					<h1><span class="headerstools"></span>Eliminación</h1><h3 class="day"><?= fechaCastellano(date("d-m-Y")); ?></h3><div class="clearfix"></div>
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
    <div class="row expl">
    <p>A medida que la enfermedad progresa, el paciente acostumbra a experimentar incontinencia urinaria y fecal, situación bastante perturbadora para el enfermo y difícil para el cuidador. En ocasiones se debe a una causa física. Este síndrome se presenta en las últimas etapas de la enfermedad y puede interpretarse como un indicador de institucionalización. </p>
    <p>Por este motivo, conviene identificar cuando el paciente tiene la necesidad de ir al baño, ya que en muchas ocasiones ellos no pueden expresarlo. Para el paciente, este tipo de episodios acostumbran a ser bochornosos, por lo que conviene evitar culparle, enfadase o regañarle. </p>
    <p>El empleo de absorbentes debe limitarse para las fases en las que hayan fracasado los consejos anteriores. El uso prematuro de pañales o compresas puede hacer perder dignidad o autoestima. </p>

    </div>
</div>
                 	
				</div> 