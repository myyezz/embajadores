<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

// $idembajador = $_GET["idembajador"];
// $desde = (isset($_GET["desde"]) && $_GET["desde"]=="") ? date('Y-m-d') : $_GET["desde"];
// $hasta = (isset($_GET["hasta"]) && $_GET["hasta"]=="") ? date('Y-m-d') : $_GET["hasta"];

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from comision where status='en revision' order by imei";
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result)) {
   $imei            = $row["imei"];
   $fecha           = $row["fecha"];
   $idembajador     = $row["idembajador"];
   $idtienda1       = $row["idtienda1"];
   $idtienda2       = $row["idtienda2"];
   $idgrupo1        = $row["idgrupo1"];
   $idgrupo2        = $row["idgrupo2"];
   $iddistribuidor1 = $row["iddistribuidor1"];
   $iddistribuidor2 = $row["iddistribuidor2"];

   $quer2 = "select * from imei where imei='$imei'";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $fechadecarga = $ro2["fecadecarga"];
   } else {
      $fechadecarga = "0000-00-00";
   }

   $quer2 = "select * from tienda where id=$idtienda1";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $tiendacarga = mysqli_real_escape_string($link,$ro2["nombre"]);
   } else {
      $tiendacarga = "";
   }
   $quer2 = "select * from tienda where id=$idtienda2";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $tiendaregistro = mysqli_real_escape_string($link,$ro2["nombre"]);
   } else {
      $tiendaregistro = "";
   }

   $quer2 = "select * from grupo where id=$idgrupo1";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $grupocarga = mysqli_real_escape_string($link,$ro2["nombre"]);
   } else {
      $grupocarga = "";
   }
   $quer2 = "select * from grupo where id=$idgrupo2";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $gruporegistro = mysqli_real_escape_string($link,$ro2["nombre"]);
   } else {
      $gruporegistro = "";
   }

   if ($iddistribuidor1>0) {
      $quer2 = "select * from distribuidor where id=$iddistribuidor1";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) {
         $distribuidorcarga = mysqli_real_escape_string($link,$ro2["nombre"]);
      } else {
         $distribuidorcarga = "";
      }
   } else {
      $distribuidorcarga = 'Techland LLC';
   }
   if ($iddistribuidor2>0) {
      $quer2 = "select * from distribuidor where id=$iddistribuidor2";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) {
         $distribuidorregistro = mysqli_real_escape_string($link,$ro2["nombre"]);
      } else {
         $distribuidorregistro = "";
      }
   } else {
      $distribuidorregistro = 'Techland LLC';
   }

   $quer2 = "select * from embajador where id=$idembajador";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $nombreembajador = $ro2["nombre"];
   } else {
      $nombreembajador = "";
   }

   if ($iddistribuidor1!=$iddistribuidor2) {
      if ($idgrupo1!=$idgrupo2) {
         $diferencia = 'No coincide el grupo ni el distribuidor';
      } else {
         $diferencia = 'No coincide el distribuidor';
      }
   } else {
      if ($idgrupo1!=$idgrupo2) {
         $diferencia = 'No coincide el grupo';
      } else {
         $diferencia = 'Todos los datos coinciden';
      }
   }
   $fila = array(
      "id" => $row["id"],
      "imei" => $row["imei"],
      "embajador" => $idembajador.' - '.$nombreembajador,
      "comisionganada" => intval($row["comisionganada"]),
      "comisiondolares" => floatval($row["comisiondolares"]),
      "revision" => $diferencia,
      "tiendacarga" => $tiendacarga,
      "tiendaregistro" => $tiendaregistro,
      "grupocarga" => $grupocarga,
      "gruporegistro" => $gruporegistro,
      "distribuidorcarga" => $distribuidorcarga,
      "distribuidorregistro" => $distribuidorregistro,
      "fechacarga" => $fechadecarga,
      "fecharegistro" => $fecha
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