<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$idembajador = trim($_GET["idembajador"]);
$imei        = trim($_GET["imei"]);
$idtienda    = trim($_GET["idtienda"]);

$query = "select * from tienda where id=$idtienda and status='activo'";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   $idgrupo = $row["idgrupo"];
   $iddistribuidor = $row["iddistribuidor"];
} else {
   $idgrupo = 0;
   $iddistribuidor = 0;
}

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select imei.*, modelo.nombre, modelo.comision from imei left outer join modelo on imei.idmodelo=modelo.id where imei='$imei' and modelo.status='activo'";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   if ($idgrupo!=0) {
      if ($idgrupo==$row["idgrupo"]) {
         if ($row["vendido"]=='NO') {
            if ($iddistribuidor==$row["iddistribuidor"]) {
               $status = 'confirmada';
            } else {
               $status = 'en revision';
            }
            $fila  = '{';
            $fila .=  '"imei":"'.$row["imei"].'"';
            $fila .=  ',"idmodelo":"'.$row["idmodelo"].'"';
            $fila .=  ',"nombremodelo":"'.$row["nombre"].'"';
            $fila .=  ',"comision":'.$row["comision"];
            $fila .=  ',"status":"'.$status.'"';
            $fila .= '}';
            $lista[] = $fila;
            $exito   = 'SI';
            $mensaje = 'Búsqueda exitosa';
         } else {
            $mensaje = 'IMEI ya fue vendido';
         }
      } else {
         if ($row["vendido"]=='NO') {
            $status = 'en revision';

            $fila  = '{';
            $fila .=  '"imei":"'.$row["imei"].'"';
            $fila .=  ',"idmodelo":"'.$row["idmodelo"].'"';
            $fila .=  ',"nombremodelo":"'.$row["nombre"].'"';
            $fila .=  ',"comision":'.$row["comision"];
            $fila .=  ',"status":"'.$status.'"';
            $fila .= '}';
            $lista[] = $fila;
            $exito   = 'SI';
            $mensaje = 'IMEI no pertenece a esa tienda';
         } else {
            $mensaje = 'IMEI ya fue vendido';
         }
      }
   } else {
      if ($iddistribuidor==$row["iddistribuidor"]) {
         if ($row["vendido"]=='NO') {
            $status = 'confirmada';

            $fila  = '{';
            $fila .=  '"imei":"'.$row["imei"].'"';
            $fila .=  ',"idmodelo":"'.$row["idmodelo"].'"';
            $fila .=  ',"nombremodelo":"'.$row["nombre"].'"';
            $fila .=  ',"comision":'.$row["comision"];
            $fila .=  ',"status":"'.$status.'"';
            $fila .= '}';
            $lista[] = $fila;
            $exito   = 'SI';
            $mensaje = 'Búsqueda exitosa';
         } else {
            $mensaje = 'IMEI ya fue vendido';
         }
      } else {
         if ($row["vendido"]=='NO') {
            $status = 'en revision';

            $fila  = '{';
            $fila .=  '"imei":"'.$row["imei"].'"';
            $fila .=  ',"idmodelo":"'.$row["idmodelo"].'"';
            $fila .=  ',"nombremodelo":"'.$row["nombre"].'"';
            $fila .=  ',"comision":'.$row["comision"];
            $fila .=  ',"status":"'.$status.'"';
            $fila .= '}';
            $lista[] = $fila;
            $exito   = 'SI';
            $mensaje = 'IMEI no pertenece a esa tienda';
         } else {
            $mensaje = 'IMEI ya fue vendido';
         }
      }
   }
} else {
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

   $fecha      = date("Y-m-d");
   $status     = 'no participa';
   $aprobacion = '0000-00-00';

   $query = "insert into imeinoparticipante (idembajador, imei, fecha, idtienda2, idgrupo2, iddistribuidor2, status, aprobacion) values ($idembajador, '$imei', '$fecha', $idtienda2, $idgrupo2, $iddistribuidor2, '$status', '$aprobacion')";
   $result = mysqli_query($link, $query);

   $mensaje = 'Este IMEI no está participando en el programa';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

echo $respuesta;
?>