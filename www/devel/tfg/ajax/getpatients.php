<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
$patients=json_decode(getpatients($user->id));
 foreach($patients as $patient){?><div class="patientrow">
<div class="col-sm-12 col-xs-12 tital " >Nombre Paciente:</div>
<div class="col-sm-12 patientname"><?=$patient->name;?> <?=$patient->surname;?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-12 col-xs-12 tital " >Fecha de nacimiento:</div><div class="col-sm-12"><?=date("d-M-Y",strtotime($patient->birthdate));?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-12 col-xs-12 tital " >Patología:</div><div class="col-sm-12"><?=$patient->pathologyname;?></div><div class="clearfix"></div>
</div>
<?}?>