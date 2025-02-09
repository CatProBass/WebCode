<?
if($_POST['tkn']!=""){
	include "../inc/restrict.php";
include "../inc/functions.php";
conectar();
$idpaciente=1;
echo (getuser($_POST['tkn']));
 
 
	}

?>