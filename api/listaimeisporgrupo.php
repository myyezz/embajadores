<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$idgrupo = $_GET["idgrupo"];

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from imei where idgrupo=$idgrupo order by imei";
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result)) {
   $idmodelo = $row["idmodelo"];
   $idtienda = $row["idtienda"];

   $quer2 = "select * from modelo where id='$idmodelo'";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) { $nombre_modelo = $ro2["nombre"]; } else { $nombre_modelo = ""; }

   $quer2 = "select * from tienda where id=$idtienda";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) { $nombre_tienda = $ro2["nombre"]; } else { $nombre_tienda = ""; }

   $fila = array(
      "imei" => $row["imei"],
      "idmodelo" => $row["idmodelo"],
      "nombre_modelo" => $nombre_modelo,
      "idtienda" => intval($row["idtienda"]),
      "nombre_tienda" => $nombre_tienda,
      "vendido" => $row["vendido"]
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