<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$email    = trim($_POST["email"]);
$password = trim($_POST["password"]);

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from embajador where email='$email'";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   if ($row["status"]=="activo") {
      $hashp = hash('sha256', $email.$password);
      if ($hashp==$row["hashp"]) {
         $idembajador = $row["id"];
         $token = hash('sha256', $hashp.date('Y-m-d'));
   
         $idtienda       = $row["idtienda"];
         $idgrupo        = $row["idgrupo"];
         $iddistribuidor = $row["iddistribuidor"];
         $quer2 = "select * from tienda where id=$idtienda";
         $resul2 = mysqli_query($link, $quer2);
         if ($ro2 = mysqli_fetch_array($resul2)) {
            $nombretienda = $ro2["nombre"];
         } else {
            $nombretienda = '';
         }
   
         $quer2 = "select count(imei) as acum_unidades, sum(comisionganada) as acum_monto from comision where idembajador=$idembajador and pagada='NO'";
         $resul2 = mysqli_query($link, $quer2);
         if ($ro2 = mysqli_fetch_array($resul2)) {
            $acum_unidades = $ro2["acum_unidades"];
            if ($acum_unidades>0) {
               $acum_monto    = $ro2["acum_monto"];
            } else {
               $acum_monto    = 0;
            }
         } else {
            $acum_unidades = 0;
            $acum_monto    = 0;
         }
   
         $quer2 = "select count(imei) as acum_unidades, sum(comisionganada) as acum_monto from comision where idembajador=$idembajador and status='en revision'";
         $resul2 = mysqli_query($link, $quer2);
         if ($ro2 = mysqli_fetch_array($resul2)) {
            $acum_unidades_revision = $ro2["acum_unidades"];
            if ($acum_unidades_revision>0) {
               $acum_monto_revision = $ro2["acum_monto"];
            } else {
               $acum_monto_revision = 0;
            }
         } else {
            $acum_unidades_revision = 0;
            $acum_monto_revision    = 0;
         }
   
         $fila  = '{';
         $fila .=  '"id":'.$row["id"];
         $fila .=  ',"nombre":"'.$row["nombre"].'"';
         $fila .=  ',"celular":"'.$row["celular"].'"';;
         $fila .=  ',"email":"'.$row["email"].'"';
         $fila .=  ',"tallafranela":"'.$row["tallafranela"].'"';
         $fila .=  ',"idtienda":'.$row["idtienda"];
         $fila .=  ',"nombretienda":"'.$nombretienda.'"';
         $fila .=  ',"idgrupo":'.$row["idgrupo"];
         $fila .=  ',"iddistribuidor":'.$row["iddistribuidor"];
         $fila .=  ',"password":"'.$row["hashp"].'"';
         $fila .=  ',"token":"'.$token.'"';
         $fila .=  ',"acum_unidades":'.$acum_unidades;
         $fila .=  ',"acum_monto":'.$acum_monto;
         $fila .=  ',"acum_unidades_revision":'.$acum_unidades_revision;
         $fila .=  ',"acum_monto_revision":'.$acum_monto_revision;
         $fila .=  ',"nuevo":"'.$row["nuevo"].'"';
         $fila .= '}';
         $lista[] = $fila;
         $exito   = 'SI';
         $mensaje = 'Login exitoso';
      } else {
         $mensaje = 'Password inválido';
      }
   } else {
      $mensaje = 'Usuario inactivo o suspendido';
   }
} else {
   $mensaje = 'Registro no existe';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

echo $respuesta;
?>