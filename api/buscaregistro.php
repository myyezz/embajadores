<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$imei = $_GET["imei"];
$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from comision where imei=$imei";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   $id              = $row["id"];
   $idembajador     = $row["idembajador"];
   $fecha           = $row["fecha"];
   $comisionganada  = $row["comisionganada"];
   $comisiondolares = $row["comisiondolares"];
   $pagada          = $row["pagada"];
   $idtienda1       = $row["idtienda1"];
   $idtienda2       = $row["idtienda2"];
   $idgrupo1        = $row["idgrupo1"];
   $idgrupo2        = $row["idgrupo2"];
   $iddistribuidor1 = $row["iddistribuidor1"];
   $iddistribuidor2 = $row["iddistribuidor2"];
   $status          = $row["status"];
   $aprobacion      = $row["aprobacion"];
   $notacredito     = $row["notacredito"];
   $fechapago       = $row["fechapago"];

   $fila = array(
      "id"              => $id,
      "idembajador"     => $idembajador,
      "fecha"           => $fecha,
      "comisionganada"  => $comisionganada,
      "comisiondolares" => $comisiondolares,
      "pagada"          => $pagada,
      "idtienda1"       => $idtienda1,
      "idtienda2"       => $idtienda2,
      "idgrupo1"        => $idgrupo1,
      "idgrupo2"        => $idgrupo2,
      "iddistribuidor1" => $iddistribuidor1,
      "iddistribuidor2" => $iddistribuidor2,
      "status"          => $status,
      "aprobacion"      => $aprobacion,
      "notacredito"     => $notacredito,
      "fechapago"       => $fechapago
   ); 
   $lista[] = json_encode($fila);
   $exito   = 'SI';
   $mensaje = 'Registro exitoso';
}
if (count($lista)>0) {
   $exito   = 'SI';
   $mensaje = 'busqueda exitosa';
} else {
   $mensaje = 'Lista vacía';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

echo $respuesta;
?>