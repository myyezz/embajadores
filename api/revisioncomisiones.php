<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
include_once("./lib/lib-email.php");
// include_once("./funciones.php");

$fecha  = date('Y-m-d');
$imei   = $_POST['imei'];
$status = $_POST['status'];

$query  = "update comision set status='$status', aprobacion='$fecha' where imei='$imei'";
// echo $query;
$result = mysqli_query($link, $query);

$query  = "update imei set vendido='NO' where imei='$imei'";
// echo $query;
$result = mysqli_query($link, $query);

$exito   = 'SI';
$mensaje = 'Registro exitoso';

$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= '}';

echo $respuesta;

?>