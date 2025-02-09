<?
session_start();
include "../inc/functions.php";
conectar();
$patient=sanitize($_POST['patient']);
$asleep=sanitize($_POST['asleep']);
$hours=sanitize($_POST['hours']);
if(set_patient_asleep($patient,$asleep) ){ echo 1;}else{echo 0;}
set_patient_sleep_hours($patient,$hours);

desconectar();
?>