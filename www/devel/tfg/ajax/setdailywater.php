<?
session_start();
include "../inc/functions.php";
conectar();
$patient=sanitize($_POST['patient']);

$intake=sanitize($_POST['intake']);
if(set_patient_water_intake($patient,$intake)){ echo 1;}else{echo 0;}


desconectar();
?>