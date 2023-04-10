<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$imei     = trim($_POST["imei"]);

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

// $query = "select imei.*, modelo.nombre, modelo.comision from imei left outer join modelo on imei.idmodelo=modelo.id where imei='$imei'";
$query = "select * from imei where imei='$imei'";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   $idmodelo       = $row["idmodelo"];
   $idtienda       = $row["idtienda"];
   $idgrupo        = $row["idgrupo"];
   $iddistribuidor = $row["iddistribuidor"];
   $vendido        = $row["vendido"];
   $error = 'no';

   $quer2 = "select * from tienda where id=$idtienda";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $nombretienda = $ro2["nombre"];
   } else {
      $nombretienda = "";
      // $error = 'tienda';
   }

   $quer2 = "select * from grupo where id=$idgrupo";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $nombregrupo = $ro2["nombre"];
   } else {
      $nombregrupo = "";
      $error = 'grupo';
   }

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

   $quer2 = "select * from modelo where id='$idmodelo'";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $nombremodelo = $ro2["nombre"];
      $comision     = $ro2["comision"];
   } else {
      $nombremodelo = "";
      $comision     = 0;
      $error = 'modelo';
   }

   if ($error=='no') {
      $fila  = '{';
      $fila .=  '"imei":"'.$row["imei"].'"';
      $fila .=  ',"idmodelo":"'.$row["idmodelo"].'"';
      $fila .=  ',"nombremodelo":"'.$nombremodelo.'"';
      $fila .=  ',"comision":'.$comision;
      $fila .=  ',"vendido":"'.$row["vendido"].'"';
      $fila .=  ',"idtienda":'.$row["idtienda"];
      $fila .=  ',"nombretienda":"'.$nombretienda.'"';
      $fila .=  ',"idgrupo":'.$row["idgrupo"];
      $fila .=  ',"nombregrupo":"'.$nombregrupo.'"';
      $fila .=  ',"iddistribuidor":'.$row["iddistribuidor"];
      $fila .=  ',"nombredistribuidor":"'.$nombredistribuidor.'"';
      $fila .= '}';
      $lista[] = $fila;
      $exito   = 'SI';
      $mensaje = 'Búsqueda exitosa';
   } else {
      $exito   = 'NO';
      switch ($error) {
         case 'tienda':
            $mensaje = 'Tienda no registrada';
         break;
         case 'grupo':
            $mensaje = 'Grupo empresarial no registrado';
         break;
         case 'modelo':
            $mensaje = 'Modelo no registrado';
         break;
      }
   }
} else {
   $mensaje = 'IMEI no existe';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

echo $respuesta;
?>