<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$id       = $_POST["id"];
$indice   = $_POST["indice"];
$nombre   = trim($_POST["nombre"]);
$comision = $_POST["comision"];
$status   = (trim($_POST["status"])=="0") ? "inactivo" : trim($_POST["status"]) ;

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

if ($indice==="New") {
   $query = "select * from modelo where nombre='$nombre' and status='activo'";
   $result = mysqli_query($link, $query);
   if ($row = mysqli_fetch_array($result)) {
      $exito   = 'NO';
      $mensaje = 'Registro ya existe';
   } else {
      $query  = "insert into modelo (id, nombre, comision, status) values ('$id','$nombre', $comision, '$status')";
      $result = mysqli_query($link, $query);

      $fila = array(
         "id" => $id,
         "nombre" => $nombre,
         "comision" => intval($comision),
         "status" => $status
      );
      $lista[] = json_encode($fila);
      $exito   = 'SI';
      $mensaje = 'Registro exitoso';
   }
} else {
   $query  = "update modelo set nombre='$nombre', comision= $comision, status='$status' where id='$id'";
   $result = mysqli_query($link, $query);

   $fila = array(
      "id" => $id,
      "nombre" => $nombre,
      "comision" => intval($comision),
      "status" => $status
   );
   $lista[] = json_encode($fila);
   $exito   = 'SI';
   $mensaje = 'Registro exitoso';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

echo $respuesta;
?>