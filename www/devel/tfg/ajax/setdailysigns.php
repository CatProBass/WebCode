<?
session_start();
include "../inc/functions.php";
conectar();
$patient=sanitize($_POST['patient']);
$temperature=sanitize($_POST['temperature']);
$pressure=sanitize($_POST['pressure']);
$heartrate=sanitize($_POST['heartrate']);
$saturation=sanitize($_POST['saturation']);
 
if(set_patient_daily_signs($patient,$temperature,$pressure,$heartrate,$saturation)){ echo 1;}else{echo 0;}


desconectar();
?>