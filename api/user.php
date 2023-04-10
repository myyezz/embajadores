<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$email    = trim($_POST["email"]);

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from embajador where email='$email'";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   if ($row["status"]=="activo") {
      $id = $row["id"];

      $fila  = '{';
      $fila .=  '"id":'.$row["id"];
      $fila .=  ',"nombre":"'.$row["nombre"].'"';
      $fila .=  ',"celular":"'.$row["celular"].'"';;
      $fila .=  ',"email":"'.$row["email"].'"';
      $fila .=  ',"tallafranela":"'.$row["tallafranela"].'"';
      $fila .=  ',"idtienda":'.$row["idtienda"];
      $fila .=  ',"nombretienda":"'.$nombretienda.'"';
      $fila .=  ',"idgrupo":'.$row["idgrupo"];
      $fila .=  ',"iddistribuidor":'.$row["iddistribuidor"];
      $fila .= '}';
      $lista[] = $fila;
      $exito   = 'SI';
      $mensaje = 'Login exitoso';
   } else {
      $mensaje = 'Usuario inactivo o suspendido';
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