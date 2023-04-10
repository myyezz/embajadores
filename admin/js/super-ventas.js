const LISTA = 'http://embajadores.myyezz.com/api/listaembajadores.php';
const TIENDAS = 'http://embajadores.myyezz.com/api/listatiendas.php?grupo=1';
const GRUPOS = 'http://embajadores.myyezz.com/api/listagrupos.php';
const DISTRIB = 'http://embajadores.myyezz.com/api/listadistribuidores.php';

const REGISTRO = 'http://embajadores.myyezz.com/api/buscaregistro.php?imei=';
const URL = 'http://embajadores.myyezz.com/api/superventa.php';

let xdatos, datos, xfecha;

const limpiar = () => {
   document.getElementById("imei").value            = "";
   document.getElementById("idembajador").value     = 0;
   document.getElementById("fecha").value           = xfecha;
   document.getElementById("comisionganada").value  = 0;
   document.getElementById("comisiondolares").value = 0.00;
   document.getElementById("pagada").value          = 0;
   document.getElementById("status").value          = 0;
   document.getElementById("aprobacion").value      = xfecha;
   document.getElementById("notacredito").value     = "";
   document.getElementById("fechapago").value       = xfecha;
   document.getElementById("idtienda1").value       = 0;
   document.getElementById("idtienda2").value       = 0;
   document.getElementById("idgrupo1").value        = 0;
   document.getElementById("idgrupo2").value        = 0;
   document.getElementById("iddistribuidor1").value = 0;
   document.getElementById("iddistribuidor2").value = 0;
}

const busquedaembajadores = () => {
   fetch(LISTA)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         xtiendas = responseData.registros;
         if (xtiendas.length>0) {
            xtiendas.forEach(elemento => {
               txtx = document.createTextNode(elemento.nombre);
               opt = document.createElement("option");
               opt.value = elemento.id;
               opt.appendChild(txtx);
               document.getElementById('idembajador').appendChild(opt);
            });
         }
      }
   });   
}

const busquedatiendas = () => {
   fetch(TIENDAS)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         xtiendas = responseData.registros;
         if (xtiendas.length>0) {
            xtiendas.forEach(elemento => {
               txtx = document.createTextNode(elemento.nombregrupo + ' - '+ elemento.nombre);
               opt = document.createElement("option");
               opt.value = elemento.id;
               opt.appendChild(txtx);
               document.getElementById('idtienda1').appendChild(opt);

               txtx2 = document.createTextNode(elemento.nombregrupo + ' - '+ elemento.nombre);
               opt2 = document.createElement("option");
               opt2.value = elemento.id;
               opt2.appendChild(txtx2);
               document.getElementById('idtienda2').appendChild(opt2);
            });
         }
      }
   });   
}

const busquedagrupos = () => {
   fetch(GRUPOS)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         xtiendas = responseData.registros;
         if (xtiendas.length>0) {
            xtiendas.forEach(elemento => {
               txtx = document.createTextNode(elemento.nombre);
               opt = document.createElement("option");
               opt.value = elemento.id;
               opt.appendChild(txtx);
               document.getElementById('idgrupo1').appendChild(opt);

               txtx2 = document.createTextNode(elemento.nombre);
               opt2 = document.createElement("option");
               opt2.value = elemento.id;
               opt2.appendChild(txtx2);
               document.getElementById('idgrupo2').appendChild(opt2);
            });
         }
      }
   });   
}

const busquedadistribuidores = () => {
   fetch(DISTRIB)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         xtiendas = responseData.registros;
         if (xtiendas.length>0) {
            xtiendas.forEach(elemento => {
               txtx = document.createTextNode(elemento.nombre);
               opt = document.createElement("option");
               opt.value = elemento.id;
               opt.appendChild(txtx);
               document.getElementById('iddistribuidor1').appendChild(opt);

               txtx2 = document.createTextNode(elemento.nombre);
               opt2 = document.createElement("option");
               opt2.value = elemento.id;
               opt2.appendChild(txtx2);
               document.getElementById('iddistribuidor2').appendChild(opt2);
            });
         }
      }
   });   
}

const inicio = () => {
   localStorage.clear();
   document.getElementById("fecha").parentNode.classList.remove("is-empty");

   dt = new Date();
   dd = dt.getDate();
   dd = (dd<10) ? '0'+dd : dd ;
   mm = dt.getMonth() + 1;
   mm = (mm<10) ? '0'+mm : mm ;
   yyyy = dt.getFullYear();
   xfecha = yyyy+'-'+mm+'-'+dd;
   document.getElementById("fecha").value = xfecha;
   document.getElementById("aprobacion").value = xfecha;
   document.getElementById("fechapago").value = xfecha;
   busquedaembajadores();
   busquedatiendas();
   busquedagrupos();
   busquedadistribuidores();
}

const buscaregistro = (imei) => {
   fetch(REGISTRO+imei)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         xdatos = responseData.registros;
         if (xdatos.length>0) {
            xdatos.forEach(elemento => {
               datos = elemento;
               document.getElementById("idembajador").value     = elemento.idembajador;
               document.getElementById("fecha").value           = elemento.fecha;
               document.getElementById("comisionganada").value  = elemento.comisionganada;
               document.getElementById("comisiondolares").value = elemento.comisiondolares;
               document.getElementById("pagada").value          = elemento.pagada;
               document.getElementById("status").value          = elemento.status;
               document.getElementById("aprobacion").value      = elemento.aprobacion;
               document.getElementById("notacredito").value     = elemento.notacredito;
               document.getElementById("fechapago").value       = elemento.fechapago;
               document.getElementById("idtienda1").value       = elemento.idtienda1;
               document.getElementById("idtienda2").value       = elemento.idtienda2;
               document.getElementById("idgrupo1").value        = elemento.idgrupo1;
               document.getElementById("idgrupo2").value        = elemento.idgrupo2;
               document.getElementById("iddistribuidor1").value = elemento.iddistribuidor1;
               document.getElementById("iddistribuidor2").value = elemento.iddistribuidor2;

               document.getElementById("comisionganada").parentNode.classList.remove("is-empty");
               document.getElementById("comisiondolares").parentNode.classList.remove("is-empty");
               document.getElementById("notacredito").parentNode.classList.remove("is-empty");
            });
         }
      }
   });   

   document.getElementById("idembajador").focus();
}

const confirmar = () => {
   document.getElementById("form-submit").disabled = true;
   let data = new FormData();

   data.append("id"             , datos.id);
   data.append("imei"           , document.getElementById("imei").value);
   data.append("idembajador"    , document.getElementById("idembajador").value);
   data.append("fecha"          , document.getElementById("fecha").value);
   data.append("comisionganada" , document.getElementById("comisionganada").value);
   data.append("comisiondolares", document.getElementById("comisiondolares").value);
   data.append("pagada"         , document.getElementById("pagada").value);
   data.append("status"         , document.getElementById("status").value);
   data.append("aprobacion"     , document.getElementById("aprobacion").value);
   data.append("notacredito"    , document.getElementById("notacredito").value);
   data.append("fechapago"      , document.getElementById("fechapago").value);
   data.append("idtienda1"      , document.getElementById("idtienda1").value);
   data.append("idtienda2"      , document.getElementById("idtienda2").value);
   data.append("idgrupo1"       , document.getElementById("idgrupo1").value);
   data.append("idgrupo2"       , document.getElementById("idgrupo2").value);
   data.append("iddistribuidor1", document.getElementById("iddistribuidor1").value);
   data.append("iddistribuidor2", document.getElementById("iddistribuidor2").value);

   fetch(URL, {
      method: 'POST',
      body: data
   })
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         limpiar();
      }
      document.getElementById("form-submit").disabled = false;
   });
}
