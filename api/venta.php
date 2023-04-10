<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$idembajador = trim($_POST["idembajador"]);
$imei        = trim($_POST["imei"]);

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select imei.*, modelo.comision from imei left outer join modelo on imei.idmodelo=modelo.id where imei='$imei' and modelo.status='activo'";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   if ($row["vendido"]=='SI') {
      $mensaje = 'IMEI ya fue vendido';
   } else {
      $comisionganada  = $row["comision"];
      $idtienda1       = $row["idtienda"];
      $idgrupo1        = $row["idgrupo"];
      $iddistribuidor1 = $row["iddistribuidor"];

      $query = "select * from embajador where id=$idembajador and status='activo'";
      $result = mysqli_query($link, $query);
      if ($row = mysqli_fetch_array($result)) {
         $idtienda2       = $row["idtienda"];
         $idgrupo2        = $row["idgrupo"];
         $iddistribuidor2 = $row["iddistribuidor"];
      } else {
         $idtienda2       = 0;
         $idgrupo2        = 0;
         $iddistribuidor2 = 0;
      }

      $query = "select * from tienda where id=$idtienda1";
      $result = mysqli_query($link, $query);
      if ($row = mysqli_fetch_array($result)) {
         $nombretienda1   = $row["nombre"];
      } else {
         $nombretienda1   = "";
      }

      $query = "select * from grupo where id=$idgrupo1";
      $result = mysqli_query($link, $query);
      if ($row = mysqli_fetch_array($result)) {
         $nombregrupo1 = $row["nombre"];
      } else {
         $nombregrupo1 = "";
      }
   
      if ($iddistribuidor>0) {
         $query = "select * from distribuidor where id=$iddistribuidor1";
         $result = mysqli_query($link, $query);
         if ($row = mysqli_fetch_array($result)) {
            $nombredistribuidor1 = $row["nombre"];
         } else {
            $nombredistribuidor1 = "";
         }
      } else {
         $nombredistribuidor1 = 'Techland LLC';
      }

      $query = "select * from tienda where id=$idtienda2";
      $result = mysqli_query($link, $query);
      if ($row = mysqli_fetch_array($result)) {
         $nombretienda2   = $row["nombre"];
      } else {
         $nombretienda2   = "";
      }

      $query = "select * from grupo where id=$idgrupo2";
      $result = mysqli_query($link, $query);
      if ($row = mysqli_fetch_array($result)) {
         $nombregrupo2 = $row["nombre"];
      } else {
         $nombregrupo2 = "";
      }
   
      if ($iddistribuidor>0) {
         $query = "select * from distribuidor where id=$iddistribuidor2";
         $result = mysqli_query($link, $query);
         if ($row = mysqli_fetch_array($result)) {
            $nombredistribuidor2 = $row["nombre"];
         } else {
            $nombredistribuidor2 = "";
         }
      } else {
         $nombredistribuidor2 = 'Techland LLC';
      }

      $fecha = date('Y-m-d');
      $status = 'confirmada';

      $query = "update imei set vendido='SI' where imei='$imei'";
      $result = mysqli_query($link, $query);

      // if ($idtienda1==$idtienda2) {
         if ($idgrupo1==$idgrupo2) {
            if ($iddistribuidor1==$iddistribuidor2) {
               $exito   = 'SI';
               $mensaje = 'Registro exitoso';
               $aprobacion = $fecha;
            } else {
               $status = 'en revision';
               $exito   = 'SI';
               $mensaje = mysqli_real_escape_string($link,'El dato del distribuidor no coincide, se registró la venta con status "en revisión"');
               $aprobacion = '0000-00-00';
            }
         } else {
            $status = 'en revision';
            $exito   = 'SI';
            $mensaje = mysqli_real_escape_string($link,'El dato del grupo empresarial no coincide, se registró la venta con status "en revisión"');
            $aprobacion = '0000-00-00';
         }
      // } else {
      //    $status = 'en revision';
      //    $mensaje = 'El dato de la tienda no coincide, se registró la venta con status "en revisión"';
      //    $aprobacion = '0000-00-00';
      // }

      $query = "select * from _parametros";
      $result = mysqli_query($link, $query);
      if ($row = mysqli_fetch_array($result)) {
         $puntospordolar = $row["puntospordolar"];
      } else {
         $puntospordolar = 0;
      }
      $comisiondolares = $comisionganada / $puntospordolar;

      $query = "insert into comision (idembajador, imei, fecha, comisionganada, comisiondolares, pagada, idtienda1, idtienda2, idgrupo1, idgrupo2, iddistribuidor1, iddistribuidor2, status, aprobacion) values ($idembajador, '$imei', '$fecha', $comisionganada, $comisiondolares, 'NO', $idtienda1, $idtienda2, $idgrupo1, $idgrupo2, $iddistribuidor1, $iddistribuidor2, '$status', '$aprobacion')";
      $result = mysqli_query($link, $query);

      $fila  = '{';
      $fila .=  '"idembajador":'.$idembajador;
      $fila .=  ',"imei":"'.$imei.'"';
      $fila .=  ',"fecha":"'.$fecha.'"';
      $fila .=  ',"comisionganada":'.$comisionganada;
      $fila .=  ',"pagada":"NO"';

      $fila .=  ',"idtienda1":'.$idtienda1;
      $fila .=  ',"nombretienda1":"'.$nombretienda1.'"';
      $fila .=  ',"idtienda2":'.$idtienda2;
      $fila .=  ',"nombretienda2":"'.$nombretienda2.'"';

      $fila .=  ',"idgrupo1":'.$idgrupo1;
      $fila .=  ',"nombregrupo1":"'.$nomgregrupo1.'"';
      $fila .=  ',"idgrupo2":'.$idgrupo2;
      $fila .=  ',"nombregrupo2":"'.$nomgregrupo2.'"';

      $fila .=  ',"iddistribuidor1":'.$iddistribuidor1;
      $fila .=  ',"nombredistribuidor1":"'.$nombredistribuidor1.'"';
      $fila .=  ',"iddistribuidor2":'.$iddistribuidor2;
      $fila .=  ',"nombredistribuidor2":"'.$nombredistribuidor2.'"';

      $fila .=  ',"status":"'.$status.'"';
      $fila .=  ',"aprobacion":"'.$aprobacion.'"';
      $fila .= '}';
      $lista[] = $fila;
   }
} else {
   $mensaje = 'Falló el registro';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

echo $respuesta;
?>