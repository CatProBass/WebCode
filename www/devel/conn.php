<?

define('DB_NAME', 'catalunydc907');
define('DB_USER', 'catalunydc907');
define('DB_PASSWORD', 'QmfyV7KHtNXk');
define('DB_HOST', 'catalunydc907.mysql.db:3306');
  function conectar(){global	$db;$db= new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)or die("Error de conexión");	}
 function cerrar(){global $db; $db->close();}
define ("cipher","929a320308c");
$key=cipher;
  function encrypt($toEncrypt)
{
    global $key;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    return bin2hex($iv . mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $toEncrypt, MCRYPT_MODE_CBC, $iv));
}

function decrypt($toDecrypt)
{
    global $key;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
    $toDecrypt = hex2bin($toDecrypt);
    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, substr($toDecrypt, $iv_size), MCRYPT_MODE_CBC, substr($toDecrypt, 0, $iv_size)));
}

 



?>