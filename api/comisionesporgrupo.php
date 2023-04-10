<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$idgrupo = $_GET["idgrupo"];
$desde = (isset($_GET["desde"]) && $_GET["desde"]=="") ? date('Y-m-d') : $_GET["desde"];
$hasta = (isset($_GET["hasta"]) && $_GET["hasta"]=="") ? date('Y-m-d') : $_GET["hasta"];

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from comision where idgrupo2=$idgrupo and (fecha>='$desde' and fecha<='$hasta') and status<>'rechazada' order by pagada desc, fecha, imei";
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result)) {
   $fila = array(
      "imei" => $row["imei"],
      "fecha" => $row["fecha"],
      "aprobacion" => $row["aprobacion"],
      "comisionganada" => intval($row["comisionganada"]),
      "comisiondolares" => floatval($row["comisiondolares"]),
      "pagada" => $row["pagada"]
   ); 
   $lista[] = json_encode($fila);
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