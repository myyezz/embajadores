<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$email    = trim($_POST["email"]);
$password = trim($_POST["password"]);

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from distribuidor where email='$email'";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   // if ($row["status"]=="activo") {
      $hashp = hash('sha256', $email.$password);
      if ($hashp==$row["hashp"]) {
         $iddistribuidor = $row["id"];
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
   // } else {
   //    $mensaje = 'Usuario inactivo o suspendido';
   // }
} else {
   $mensaje = 'Registro no existe';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

echo $respuesta;
?>