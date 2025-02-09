<?php
session_start();
include "../inc/functions.php";
conectar();
 

  $checking=false;
  $msg="error POST";

if (isset($_POST['datos'])) {
  $datos = explode("||", $_POST['datos']);
  $IdTel = $datos[0];
  $Plataforma=$datos[1];

  $sql="SELECT id FROM sgr_devices WHERE regid='".$IdTel."'";
 $q=mysql_query($sql) or die(mysql_error());
 
  if (mysql_num_rows($q)==0) {
      $checking=false;
      $msg="primera";
      $sql2="INSERT INTO sgr_devices (id,regid, name, email, plataforma, created_at) VALUES (null,'".$IdTel."', '', '','".$Plataforma."', CURRENT_TIMESTAMP)";
 $insert=mysql_query($sql2) or die(mysql_error());
      if (!$insert) {
          $checking=false;
          $msg="Error";
      }
      else {
        $checking=true;
      }

  }

  else {
    $checking=true;
    $msg="Ya estaba";

  }



}
  $json=array("valid"=>$checking, "msg" => $msg);
  echo json_encode($json);

?>

