<?

session_start();
include "../inc/functions.php";
conectar();

$getuser=(getuser($_POST['token']));
echo $getuser;

desconectar();
?>