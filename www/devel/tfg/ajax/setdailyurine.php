<?
session_start();
include "../inc/functions.php";
conectar();
$patient=sanitize($_POST['patient']);
$times=sanitize($_POST['times']);
$colour=sanitize($_POST['colour']);
$appearance=sanitize($_POST['appearance']);

if(set_patient_daily_urine($patient,$times, $colour, $appearance)){ echo 1;}else{echo 0;}


desconectar();
?>