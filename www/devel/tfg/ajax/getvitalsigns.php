<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
 
$vitalsigns=json_decode(get_patient_daily_signs($idpaciente));
?>
 
				<div class="col-lg-6">
					<h1>Constantes Vitales</h1><h3 class="day"><?= fechaCastellano(date("d-m-Y")); ?></h3>
 
				 
   <div class="row">
        <div class="col-md-12">  
                <?  if($vitalsigns->id==""){?>
                <form id="formvital">
             <div class="form-check">
            
               <div class="form-group"> 
         <label for="temperature">Temperatura</label>  <input name="temperature"  type="number" placeholder="0"  /> ºC
               </div>
                       <div class="form-group"> 
         <label for="pressure">Tensión Arterial</label>  <input name="pressure"  type="text" placeholder="000/000" /> mmHg
               </div>
                    <div class="form-group"> 
         <label for="heartrate">Ritmo cardiaco</label>  <input name="heartrate"  type="number" placeholder="000" /> ppm
               </div>
             
                     <div class="form-group"> 
         <label for="saturation">Saturación de oxígeno</label>  <input name="saturation"  type="number" placeholder="000" /> %
               </div>
             
           <div class="form-group">  <button type="button" class="btn btn-primary b_sendvs">Enviar</button> </div> 
           
                      </div>  </form> <? }else{ ?>
  <div class="vitalsign">
             <span class="glyphicon glyphicon-ok activo" ></span> <strong> Temperatura:</strong> <?=$vitalsigns->temperature;?> ºC</div>
              
                <div class="vitalsign">
             <span class="glyphicon glyphicon-ok activo" ></span> <strong> Tensión Arterial:</strong> <?=$vitalsigns->pressure;?> mmHg</div>
             
               <div class="vitalsign">
             <span class="glyphicon glyphicon-ok activo" ></span> <strong> Ritmo cardiaco:</strong> <?=$vitalsigns->heartrate;?> ppm</div>
             
               <div class="vitalsign">
             <span class="glyphicon glyphicon-ok activo" ></span> <strong> Saturación de oxígeno:</strong> <?=$vitalsigns->saturation;?> %</div>
              
                        
           <? }?></div> 
        </div>
	 
 
 