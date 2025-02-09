<?
session_start();
include "../inc/functions.php";
conectar();
$patient=sanitize($_POST['patient']);
$nail=sanitize($_POST['id']);

if(set_patient_daily_nails($patient,$nail)){ echo 1;}else{echo 0;}


desconectar();
?>