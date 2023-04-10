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
$fila = '{}';
$lista = array();
$listatienda = array();
$listagrupo = array();
$listadistribuidor = array();
$listatodos = array();

$query = "select * from comision where fecha>='$desde' and fecha<='$hasta' and status<>'rechazada' order by iddistribuidor2, idgrupo2, idtienda2, idembajador, pagada, imei";
$result = mysqli_query($link, $query);
$first = true;
$idembajador = 0;

$puntos = 0;
$ganada = 0.00;
$pagada = 0.00;
$nopagada = 0.00;

$puntostienda = 0;
$ganadatienda = 0.00;
$pagadatienda = 0.00;
$nopagadatienda = 0.00;

$puntosgrupo = 0;
$ganadagrupo = 0.00;
$pagadagrupo = 0.00;
$nopagadagrupo = 0.00;

$puntosdistribuidor = 0;
$ganadadistribuidor = 0.00;
$pagadadistribuidor = 0.00;
$nopagadadistribuidor = 0.00;
while ($row = mysqli_fetch_array($result)) {
   if ($first) {
      $first = false;
      $iddistribuidor2 = $row["iddistribuidor2"];
      $idgrupo2        = $row["idgrupo2"];
      $idtienda2       = $row["idtienda2"];

      $quer2 = "select nombre from embajador where id=$idembajador";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
   }

   $imeix = $row["imei"];
   $quer3 = "select imei.*, modelo.nombre from imei left outer join modelo on imei.idmodelo=modelo.id where imei.imei='$imeix'";
   $resul3 = mysqli_query($link, $quer3);
   if ($ro3 = mysqli_fetch_array($resul3)) { 
      $idmodelo      = $ro3["idmodelo"]; 
      $nombre_modelo = $ro3["nombre"]; 
   } else { 
      $idmodelo      = "";
      $nombre_modelo = "";
   }

   if ($iddistribuidor2 != $row["iddistribuidor2"]) {
      $quer2 = "select nombre from tienda where id=$idtienda2";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
      $filatienda = array(
         "id" => $idtienda2,
         "nombre" => $nombre,
         "puntos" => intval($puntostienda),
         "ganada" => floatval($ganadatienda),
         "pagada" => floatval($pagadatienda),
         "pendiente" => floatval($nopagadatienda),
         "embajadores" => $lista
      );
      $listatienda[] = $filatienda;
      $lista = array();
      ///////////////////////////////////////////////////////
      $quer2 = "select nombre from grupo where id=$idgrupo2";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
      $filagrupo = array(
         "id" => $idgrupo2,
         "nombre" => $nombre,
         "puntos" => intval($puntosgrupo),
         "ganada" => floatval($ganadagrupo),
         "pagada" => floatval($pagadagrupo),
         "pendiente" => floatval($nopagadagrupo),
         "tiendas" => $listatienda
      );
      $listagrupo[] = $filagrupo;
      $listatienda = array();
      ///////////////////////////////////////////////////////
      $quer2 = "select nombre from distribuidor where id=$iddistribuidor2";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
      $nombre = ($iddistribuidor==0) ? 'Techland LLC' : $nombre ;
      $filadistribuidor = array(
         "id" => $iddistribuidor,
         "nombre" => $nombre,
         "puntos" => intval($puntosdistribuidor),
         "ganada" => floatval($ganadadistribuidor),
         "pagada" => floatval($pagadadistribuidor),
         "pendiente" => floatval($nopagadadistribuidor),
         "grupos" => $listagrupo
      );
      $listadistribuidor[] = $filadistribuidor;
      $listadistribuidor = array();
      ///////////////////////////////////////////////////////
      $puntostienda = 0;
      $ganadatienda = 0.00;
      $pagadatienda = 0.00;
      $nopagadatienda = 0.00;

      $puntosgrupo = 0;
      $ganadagrupo = 0.00;
      $pagadagrupo = 0.00;
      $nopagadagrupo = 0.00;

      $puntosdistribuidor = 0;
      $ganadadistribuidor = 0.00;
      $pagadadistribuidor = 0.00;
      $nopagadadistribuidor = 0.00;

      $iddistribuidor2 = $row["iddistribuidor2"];
      $idgrupo2        = $row["idgrupo2"];
      $idtienda2       = $row["idtienda2"];
   }
   if ($idgrupo2 != $row["idgrupo2"]) {
      $quer2 = "select nombre from tienda where id=$idtienda2";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
      $filatienda = array(
         "id" => $idtienda2,
         "nombre" => $nombre,
         "puntos" => intval($puntostienda),
         "ganada" => floatval($ganadatienda),
         "pagada" => floatval($pagadatienda),
         "pendiente" => floatval($nopagadatienda),
         "embajadores" => $lista
      );
      $listatienda[] = $filatienda;
      $lista = array();
      ///////////////////////////////////////////////////////
      $quer2 = "select nombre from grupo where id=$idgrupo2";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
      $filagrupo = array(
         "id" => $idgrupo2,
         "nombre" => $nombre,
         "puntos" => intval($puntosgrupo),
         "ganada" => floatval($ganadagrupo),
         "pagada" => floatval($pagadagrupo),
         "pendiente" => floatval($nopagadagrupo),
         "tiendas" => $listatienda
      );
      $listagrupo[] = $filagrupo;
      $listatienda = array();
      ///////////////////////////////////////////////////////
      $puntostienda = 0;
      $ganadatienda = 0.00;
      $pagadatienda = 0.00;
      $nopagadatienda = 0.00;

      $puntosgrupo = 0;
      $ganadagrupo = 0.00;
      $pagadagrupo = 0.00;
      $nopagadagrupo = 0.00;

      $idgrupo2  = $row["idgrupo2"];
      $idtienda2 = $row["idtienda2"];
   }
   if ($idtienda2 != $row["idtienda2"]) {
      $quer2 = "select nombre from tienda where id=$idtienda2";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
      $filatienda = array(
         "id" => $idtienda2,
         "nombre" => $nombre,
         "puntos" => intval($puntostienda),
         "ganada" => floatval($ganadatienda),
         "pagada" => floatval($pagadatienda),
         "pendiente" => floatval($nopagadatienda),
         "embajadores" => $lista
      );
      $listatienda[] = $filatienda;
      $lista = array();

      $puntostienda = 0;
      $ganadatienda = 0.00;
      $pagadatienda = 0.00;
      $nopagadatienda = 0.00;

      $idtienda2 = $row["idtienda2"];
   }
   $idembajador = $row["idembajador"];
   $quer2 = "select nombre from embajador where id=$idembajador";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }

   $puntos = $row["comisionganada"];
   $ganada = $row["comisiondolares"];
   if ($row["pagada"]=='SI') { $pagada = $row["comisiondolares"]; } else { $nopagada = $row["comisiondolares"]; }

   $fila = array(
      "id" => $idembajador,
      "nombre" => $nombre,
      "imei" => $row["imei"],
      "puntos" => intval($puntos),
      "ganada" => floatval($ganada),
      "pagada" => floatval($pagada),
      "pendiente" => floatval($nopagada)
   );
   $lista[] = $fila;

   $puntostienda += $row["comisionganada"];
   $ganadatienda += $row["comisiondolares"];
   $pagadatienda += $pagada;
   $nopagadatienda += $nopagada;

   $puntosgrupo += $row["comisionganada"];
   $ganadagrupo += $row["comisiondolares"];
   $pagadagrupo += $pagada;
   $nopagadagrupo += $nopagada;

   $puntosdistribuidor += $row["comisionganada"];
   $ganadadistribuidor += $row["comisiondolares"];
   $pagadadistribuidor += $pagada;
   $nopagadadistribuidor += $nopagada;

   $puntostotales += $row["comisionganada"];
   $ganadatotales += $row["comisiondolares"];
   $pagadatotales += $pagada;
   $nopagadatotales += $nopagada;

   $pagada = 0.00;
   $nopagada = 0.00;


   $idx = $row["idembajador"];
   $quer3 = "select nombre from embajador where id=$idx";
   $resul3 = mysqli_query($link, $quer3);
   if ($ro3 = mysqli_fetch_array($resul3)) { $nombreembajador = $ro3["nombre"]; } else { $nombreembajador = ''; }

   $idx = $row["idtienda2"];
   $quer3 = "select nombre from tienda where id=$idx";
   $resul3 = mysqli_query($link, $quer3);
   if ($ro3 = mysqli_fetch_array($resul3)) { $nombretienda = $ro3["nombre"]; } else { $nombretienda = ''; }

   $idx = $row["idgrupo2"];
   $quer3 = "select nombre from grupo where id=$idx";
   $resul3 = mysqli_query($link, $quer3);
   if ($ro3 = mysqli_fetch_array($resul3)) { $nombregrupo = $ro3["nombre"]; } else { $nombregrupo = ''; }

   $idx = $row["iddistribuidor2"];
   if ($idx==0) {
      $nombredistribuidor = 'Techland LLC';
   } else {
      $quer3 = "select nombre from distribuidor where id=$idx";
      $resul3 = mysqli_query($link, $quer3);
      if ($ro3 = mysqli_fetch_array($resul3)) { 
         $nombredistribuidor = $ro3["nombre"];
      } else {
         $nombredistribuidor = '';
      }
   }

   $filatodos = array(
      "idembajador" => $row["idembajador"],
      "nombreembajador" => $nombreembajador,
      "imei" => $row["imei"],
      "idmodelo" => $idmodelo,
      "nombremodelo" => $nombre_modelo,
      "fecha" => $row["fecha"],
      "puntos" => intval($row["comisionganada"]),
      "comision" => floatval($row["comisiondolares"]),
      "pagada" => $row["pagada"],
      "idtienda" => $row["idtienda2"],
      "nombretienda" => $nombretienda,
      "idgrupo" => $row["idgrupo2"],
      "nombregrupo" => $nombregrupo,
      "iddistribuidor" => $row["iddistribuidor2"],
      "nombredistribuidor" => $nombredistribuidor,
      "status" => $row["status"],
      "aprobacion" => $row["aprobacion"],
      "notacredito" => $row["notacredito"],
      "fechapago" => $row["fechapago"]
   );
   $listatodos[] = json_encode($filatodos);
}
$quer2 = "select nombre from tienda where id=$idtienda2";
$resul2 = mysqli_query($link, $quer2);
if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
$filatienda = array(
   "id" => $idtienda2,
   "nombre" => $nombre,
   "puntos" => intval($puntostienda),
   "ganada" => floatval($ganadatienda),
   "pagada" => floatval($pagadatienda),
   "pendiente" => floatval($nopagadatienda),
   "embajadores" => $lista
);
$listatienda[] = $filatienda;
///////////////////////////////////////////////////////
$quer2 = "select nombre from grupo where id=$idgrupo2";
$resul2 = mysqli_query($link, $quer2);
if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
$filagrupo = array(
   "id" => $idgrupo2,
   "nombre" => $nombre,
   "puntos" => intval($puntosgrupo),
   "ganada" => floatval($ganadagrupo),
   "pagada" => floatval($pagadagrupo),
   "pendiente" => floatval($nopagadagrupo),
   "tiendas" => $listatienda
);
$listagrupo[] = $filagrupo;
///////////////////////////////////////////////////////
$quer2 = "select nombre from distribuidor where id=$iddistribuidor2";
$resul2 = mysqli_query($link, $quer2);
if ($ro2 = mysqli_fetch_array($resul2)) { $nombre = $ro2["nombre"]; } else { $nombre = ''; }
$nombre = ($iddistribuidor==0) ? 'Techland LLC' : $nombre ;
$filadistribuidor = array(
   "id" => $iddistribuidor2,
   "nombre" => $nombre,
   "puntos" => intval($puntosdistribuidor),
   "ganada" => floatval($ganadadistribuidor),
   "pagada" => floatval($pagadadistribuidor),
   "pendiente" => floatval($nopagadadistribuidor),
   "grupos" => $listagrupo
);
$listadistribuidor[] = $filadistribuidor;
///////////////////////////////////////////////////////
$filatotal = array(
   "puntos" => intval($puntostotales),
   "ganada" => floatval($ganadatotales),
   "pagada" => floatval($pagadatotales),
   "pendiente" => floatval($nopagadatotales),
   "distribuidores" => $listadistribuidor
);
$listatotal[] = json_encode($filatotal);

if (count($listatotal)>0 && $puntostotales>0) {
   $exito   = 'SI';
   $mensaje = 'busqueda exitosa';
} else {
   $mensaje = 'Lista vacía';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',',$listatotal).']';
$respuesta .= ',"registrosx": ['. implode(',',$listatodos).']';
$respuesta .= '}';

echo $respuesta;
?>