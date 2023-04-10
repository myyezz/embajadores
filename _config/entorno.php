<?php 
header('Access-Control-Allow-Origin: *');

unlink(dirname(__FILE__)."/entorno.cfg");

$a = fopen(dirname(__FILE__)."/entorno.cfg",'w+');
$entorno = $_GET["entorno"];
fwrite($a, $entorno);

$b = fopen(dirname(__FILE__)."/entorno.cfg","r");
$valor = fread($b,filesize(dirname(__FILE__)."/entorno.cfg"));
fclose($b);

echo $valor;
?>
