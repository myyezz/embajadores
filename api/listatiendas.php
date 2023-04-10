<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$grupos = isset($_GET["grupo"]) ? true : false ;

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

if ($grupos) {
   $query = "select tienda.*, grupo.nombre as nombregrupo from tienda left outer join grupo on tienda.idgrupo=grupo.id order by nombregrupo, nombre";
} else {
   $query = "select tienda.*, grupo.nombre as nombregrupo from tienda left outer join grupo on tienda.idgrupo=grupo.id order by nombre";
}
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result)) {
   $iddistribuidor = $row["iddistribuidor"];

   if ($iddistribuidor>0) {
      $quer2 = "select * from distribuidor where id=$iddistribuidor";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) {
         $nombredistribuidor = $ro2["nombre"];
      } else {
         $nombredistribuidor = "";
      }
   } else {
      $nombredistribuidor = 'Techland LLC';
   }

   $fila = array(
      "id" => $row["id"],
      "nombre" => $row["nombre"],
      "idejecutivo" => $row["idejecutivo"],
      "celular" => $row["celular"],
      "email" => $row["email"],
      "direccion" => $row["direccion"],
      "contacto" => $row["contacto"],
      "celularcontacto" => $row["celularcontacto"],
      "idgrupo" => $row["idgrupo"],
      "nombregrupo" => $row["nombregrupo"],
      "iddistribuidor" => $row["iddistribuidor"],
      "nombredistribuidor" => $nombredistribuidor,
      "status" => $row["status"]
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