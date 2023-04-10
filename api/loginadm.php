<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$password = trim($_POST["password"]);

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from _parametros";
// echo $query;

$result = mysqli_query($link, $query);
// echo mysqli_error($link);
if ($row = mysqli_fetch_array($result)) {
   $hashp = hash('sha256', $password);
   if ($hashp==$row["hashp"]) {
      $token = hash('sha256', $hashp.date('Y-m-d'));
      $fila  = '{';
      $fila .=  '"id":"admin"';
      $fila .=  ',"password":"'.$row["hashp"].'"';
      $fila .=  ',"token":"'.$token.'"';
      $fila .= '}';
      $lista[] = $fila;
      $exito   = 'SI';
      $mensaje = 'Login exitoso';
   } else {
      $mensaje = 'Password inválido';
   }
} else {
   $mensaje = 'Registro no existe';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

echo $respuesta;
?>