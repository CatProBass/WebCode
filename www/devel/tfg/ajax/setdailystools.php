<?
session_start();
include "../inc/functions.php";
conectar();
$patient=sanitize($_POST['patient']);
$times=sanitize($_POST['times']);
$consistency=sanitize($_POST['consistency']);
 $appearance=sanitize($_POST['appearance']);

if(set_patient_daily_stools($patient,$times, $appearance, $consistency)){ echo 1;}else{echo 0;}


desconectar();
?>