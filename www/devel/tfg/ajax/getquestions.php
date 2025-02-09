<?
 error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
  $questions=json_decode(getdailyquestions());
 
  $patientanswers=array();
 

?>

<div class="row">
				<div class="col-lg-6">
					<h1><span class="headerquestions"></span>Preguntas</h1><h3 class="day"><?= fechaCastellano(date("d-m-Y")); ?></h3>
   <div class="row">
        <div class="col-md-12">
            <form id="questions">
            	<div class="form-group">
           <? 
		 $ids=array();
		 		
		   foreach($questions as $q){
		 array_push($ids,$q->id);
		 
		 if(!empty(
		 json_decode(get_patient_question($idpaciente,$q->id))
		 )){
			    $patientanswers[$q->id]=json_decode(get_patient_question($idpaciente,$q->id));}
	    ?>
           
            	<h3><?=$q->question_es;?> </h3>
           <? if(!empty( $patientanswers[$q->id])){
		 
			   ?> 
      <strong>   <?=sino($patientanswers[$q->id]->response);?></strong>	<?}else{?>
         
        <label>	
			<input type="radio" value="1" name="respuesta<?=$q->id;?>" ><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Sí</span></label>	<div class="clearfix"></div>	<label><input type="radio" value="0" name="respuesta<?=$q->id;?>" > <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> No</span></label>	
       
            	<?}}?>
            	</div>
               
            <?
		 
			 if(count($patientanswers)==0){?>	 <div class="form-group">  <button type="button" class="btn btn-primary b_sendquestions">Enviar</button> </div>  <?}?>
            	
			 <input type="hidden"  id="questionids" value="<?=implode(",",$ids);?>"/>
            </form>
        </div>
       
    </div>
</div>
                 	
				</div> 