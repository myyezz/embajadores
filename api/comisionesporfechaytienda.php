<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$desde = $_GET["desde"];
$hasta = $_GET["hasta"];

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from comision where fecha>='$desde' and fecha<='$hasta' and status<>'rechazada' order by idgrupo2, idtienda2, pagada";
$result = mysqli_query($link, $query);
$first = true;
$idembajador = 0;
$puntos = 0;
$ganada = 0.00;
$pagada = 0.00;
$nopagada = 0.00;
while ($row = mysqli_fetch_array($result)) {
   if ($first) {
      $first = false;
      $idgrupo = $row["idgrupo2"];
      $quer2 = "select nombre from grupo where id=$idgrupo";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) { $nombregrupo = $ro2["nombre"]; } else { $nombregrupo = ''; }

      $idtienda = $row["idtienda2"];
      $quer2 = "select nombre from tienda where id=$idtienda";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
   }
   if ($idtienda != $row["idtienda2"]) {
      $fila = array(
         "id" => $idtienda,
         "nombregrupo" => $nombregrupo,
         "nombre" => $nombre,
         "puntos" => intval($puntos),
         "ganada" => floatval($ganada),
         "pagada" => floatval($pagada),
         "pendiente" => floatval($nopagada)
      );
      $lista[] = json_encode($fila);

      $puntos = 0;
      $ganada = 0.00;
      $pagada = 0.00;
      $nopagada = 0.00;

      $idgrupo = $row["idgrupo2"];
      $quer2 = "select nombre from grupo where id=$idgrupo";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) { $nombregrupo = $ro2["nombre"]; } else { $nombregrupo = ''; }

      $idtienda = $row["idtienda2"];
      $quer2 = "select nombre from tienda where id=$idtienda";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
   }
   $puntos += $row["comisionganada"];
   $ganada += $row["comisiondolares"];
   if ($row["pagada"]=='SI') { $pagada += $row["comisiondolares"]; } else { $nopagada += $row["comisiondolares"]; }
}
$fila = array(
   "id" => $idtienda,
   "nombregrupo" => $nombregrupo,
   "nombre" => $nombre,
   "puntos" => intval($puntos),
   "ganada" => floatval($ganada),
   "pagada" => floatval($pagada),
   "pendiente" => floatval($nopagada)
);
$lista[] = json_encode($fila);
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