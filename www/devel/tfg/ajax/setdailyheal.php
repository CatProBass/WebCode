<?
session_start();
include "../inc/functions.php";
conectar();
$patient=sanitize($_POST['patient']);
$heal=sanitize($_POST['id']);

if(set_patient_daily_heal($patient,$heal)){ echo 1;}else{echo 0;}


desconectar();
?>