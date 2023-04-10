<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$password    = trim($_POST["password"]);
$idembajador = $_POST["idembajador"];

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from embajador where id=$idembajador";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   $nombre = $row["nombre"];
   $email = $row["email"];
   $hashp = hash('sha256', $email.$password);

   $query  = "update embajador set hashp='$hashp' where id=$idembajador";
   $result = mysqli_query($link, $query);

   $fila  = '{';
   $fila .=  '"id":'.$idembajador;
   $fila .=  ',"nombre":"'.$nombre.'"';
   $fila .=  ',"password":"'.$hashp.'"';
   $fila .= '}';
   $lista[] = $fila;
   $exito   = 'SI';
   $mensaje = 'Registro exitoso';
} else {
   $exito   = 'NO';
   $mensaje = 'Registro no existe';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

echo $respuesta;
?>