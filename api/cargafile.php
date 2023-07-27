<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");

$data = json_decode( $_POST["registros"], true );
$hoy = date('Y-m-d H:i:s');

$registros = $data["registros"];

foreach ($registros as $registro) {
   $imeis          = $registro["imeis"];
   $idmodelo       = $registro["idmodelo"];
   $idtienda       = $registro["idtienda"];
   $idgrupo        = $registro["idgrupo"];
   $iddistribuidor = $registro["iddistribuidor"];

   $correctos = array();
   $duplicados = array();
   $invalidos = array();
   for ($i=0; $i < count($imeis); $i++) {
      $imei = $imeis[$i];
      $query = "select * from imei where imei='$imei'";
      if ($result = mysqli_query($link, $query)) {
         if ($row = mysqli_fetch_array($result)) {
            $duplicados[] = '"'.$imei.'"';
         } else {
            $correctos[] = '"'.$imei.'"';
            $quer2 = "insert into imei (imei, idmodelo, idtienda, idgrupo, iddistribuidor, vendido, fechadecarga) values ";
            $quer2 .= "('$imei', '$idmodelo', $idtienda, $idgrupo, $iddistribuidor, 'NO', '$hoy')";
            $resul2 = mysqli_query($link, $quer2);
         }
      } else {
         $invalidos[] = '"'.$imei.'"';
      }
   }
}
$respuesta  = '{"exito":"SI"';
$respuesta .= ',"mensaje":"Éxito"';
$respuesta .= ',"correctos": ['. implode(',', $correctos)    .']';
$respuesta .= ',"duplicados": ['. implode(',', $duplicados)   .']';
$respuesta .= ',"invalidos": ['. implode(',', $invalidos)    .']';
$respuesta .= '}';

echo $respuesta;
?>
