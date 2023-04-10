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

   $query = "insert into imei (imei, idmodelo, idtienda, idgrupo, iddistribuidor, vendido, fechadecarga) values ";

   $first = true;
   $coma = "";
   for ($i=0; $i < count($imeis); $i++) {
      if ($first) {
         $first = false;
      } else {
         $coma = ",";
      }
      $imei = $imeis[$i];
      $query .= $coma."('$imei', '$idmodelo', $idtienda, $idgrupo, $iddistribuidor, 'NO', '$hoy')";
   }
   // echo $query;
   if ($result = mysqli_query($link, $query)) {
      $respuesta  = '{"exito":"SI"';
      $respuesta .= ',"mensaje":"Éxito"';
   } else {
      $respuesta  = '{"exito":"NO"';
      $respuesta .= ',"mensaje":"Ocurrió un error en la carga"';
   }
}
$respuesta .= ',"registros": []';
$respuesta .= '}';

echo $respuesta;
?>
