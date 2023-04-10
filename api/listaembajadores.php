<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from embajador where status<>'pendiente' and status<>'rechazado' order by nombre";
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result)) {
   $idgrupo        = $row["idgrupo"];
   $iddistribuidor = $row["iddistribuidor"];

   $quer2 = "select * from grupo where id=$idgrupo";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $nombregrupo = mysqli_real_escape_string($link,$ro2["nombre"]);
   } else {
      $nombregrupo = "";
   }

   if ($iddistribuidor>0) {
      $quer2 = "select * from distribuidor where id=$iddistribuidor";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) {
         $nombredistribuidor = mysqli_real_escape_string($link,$ro2["nombre"]);
      } else {
         $nombredistribuidor = "";
      }
   } else {
      $nombredistribuidor = 'Techland LLC';
   }

   $fila = array(
      "id" => $row["id"],
      "nombre" => mysqli_real_escape_string($link,$row["nombre"]),
      "celular" => $row["celular"],
      "email" => $row["email"],
      "tallafranela" => $row["tallafranela"],
      "idtienda" => $row["idtienda"],
      "status" => $row["status"],
      "nombretienda" => mysqli_real_escape_string($link,$row["nombretienda"]),
      "idgrupo" => $row["idgrupo"],
      "nombregrupo" => $nombregrupo,
      "iddistribuidor" => $row["iddistribuidor"],
      "nombredistribuidor" => $nombredistribuidor
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