<?
session_start();
include "../inc/functions.php";
conectar();
$patient=sanitize($_POST['patient']);
$meal=sanitize($_POST['meal']);
$intake=sanitize($_POST['intake']);
if(set_patient_meal_intake($patient,$meal,$intake)){ echo 1;}else{echo 0;}


desconectar();
?>