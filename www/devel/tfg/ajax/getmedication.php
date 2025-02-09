<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
 $patientmedications=json_decode(getpatientmedications($idpaciente));
  $dailymedication=json_decode(getdailymedication($idpaciente));

?>

<div class="row">
				<div class="col-lg-6">
					<h1><span class="headermed"></span>Medicación </h1><h3 class="day"><?=fechaCastellano(date("d-m-Y"));?></h3><div class="clearfix"></div>
				<?
				 $patientmedications=json_decode(getpatientmedications($idpaciente));
                $dailymedication=json_decode(getdailymedication($idpaciente));
	 // print_r(  $dailymedication);
				?> 
                
                <table width="100%" class="table medicationtable table-striped">
                
                <tr>
                <th>Hora</th>
                <? foreach($patientmedications as $med){?>
                <th><?=$med->name;?></th>
                <?}?>
                </tr>
                <? for($h=0;$h<24;$h++){
					$h=str_pad($h, 2, '0', STR_PAD_LEFT);
					?>
                <tr scope="row">
                <td><?=$h;?>:00</td>
                 <?  
				 foreach($patientmedications as $med2){?>
                <td><?
				$search=searchForIdHour($med2->id,$h.':00:00',$dailymedication);
				 if($search!=""){
	 if($search[0]=="1"){ 				
					?><i  id="dailymed<?=$search[2];?>" class="glyphicon glyphicon-ok-circle activo" onClick="setdailymedication(<?=$search[2];?>,0)"></i><?}else{?><i class="glyphicon glyphicon-ok-circle inactivo" id="dailymed<?=$search[2];?>"  onClick="setdailymedication(<?=$search[2];?>,1);playblop(this)"><?}?><?}?></td>

                <?}?>
                
                </tr>
                <?}?>
                </table>
                
                 <p>
                 
             
             </p>
                 	
				</div><!-- /col-lg-6 -->
				<div class="col-lg-6">
			 
				</div><!-- /col-lg-6 -->
				
			</div>     <audio  src="audio/blop.mp3" id="blop">