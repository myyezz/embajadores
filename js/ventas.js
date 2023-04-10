const IMEIS = 'https://myyezz.github.io/embajadores/api/imeis.php';
const URL = 'https://myyezz.github.io/embajadores/api/venta.php';
const EQUIVALENCIA = 'https://myyezz.github.io/embajadores/api/equivalencia.php';
let token, id, email, nombre, idtienda, nombretienda, acum_unidades, acum_monto, acum_unidades_revision, acum_monto_revision;

const inicio = () => {
   if (localStorage.getItem('token')!=undefined) {
      token                  = localStorage.getItem('token');
      id                     = (localStorage.getItem('id')!=undefined) ? localStorage.getItem('id') : 0 ;
      email                  = (localStorage.getItem('email')!=undefined) ? localStorage.getItem('email') : "" ;
      nombre                 = (localStorage.getItem('nombre')!=undefined) ? localStorage.getItem('nombre') : "" ;
      idtienda               = (localStorage.getItem('idtienda')!=undefined) ? localStorage.getItem('idtienda') : 0 ;
      nombretienda           = (localStorage.getItem('nombretienda')!=undefined) ? localStorage.getItem('nombretienda') : "" ;
      acum_unidades          = (localStorage.getItem('acum_unidades')!=undefined) ? parseInt(localStorage.getItem('acum_unidades')) : 0 ;
      acum_monto             = (localStorage.getItem('acum_monto')!=undefined) ? parseFloat(localStorage.getItem('acum_monto')) : 0.00 ;
      acum_unidades_revision = (localStorage.getItem('acum_unidades_revision')!=undefined) ? parseInt(localStorage.getItem('acum_unidades_revision')) : 0 ;
      acum_monto_revision    = (localStorage.getItem('acum_monto_revision')!=undefined) ? parseFloat(localStorage.getItem('acum_monto_revision')) : 0.00 ;
      document.getElementById("nombre_embajador").innerHTML = nombre;
      document.getElementById("acum_unidades").value          = acum_unidades;
      document.getElementById("acum_monto").value             = acum_monto;
      document.getElementById("acum_unidades_revision").value = acum_unidades_revision;
      document.getElementById("acum_monto_revision").value    = acum_monto_revision;
   }

   fetch(EQUIVALENCIA)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         document.getElementById('mensaje').innerHTML = '(*) Equivalencia: ' + responseData.registros[0].puntospordolar + ' puntos por dolar.';
      } else {
      }
   });   
}

const limpiar = () => {
   document.getElementById("imei").value = "";
   document.getElementById("modelo").value = "";
   document.getElementById("form-submit").disabled = false;
}

const venta = () => {
   if (document.getElementById("imei").value!="") {
      xURL = IMEIS + '?idembajador='+id+'&imei=' + document.getElementById("imei").value + '&idtienda=' + idtienda;
      fetch(xURL)
      .then((response) => response.json())
      .then((responseData) => {
         if (responseData.exito==="SI") {
            document.getElementById("modelo").value = responseData.registros[0].nombremodelo;
            acum_unidades++;
            acum_monto   += responseData.registros[0].comision;
            if (responseData.registros[0].status=='en revision') {
               acum_unidades_revision++;
               acum_monto_revision   += responseData.registros[0].comision;
            }
            localStorage.setItem('acum_unidades'         , acum_unidades);
            localStorage.setItem('acum_monto'            , acum_monto);
            localStorage.setItem('acum_unidades_revision', acum_unidades_revision);
            localStorage.setItem('acum_monto_revision'   , acum_monto_revision);
   
            document.getElementById("acum_unidades").value          = acum_unidades;
            document.getElementById("acum_monto").value             = acum_monto;
            document.getElementById("acum_unidades_revision").value = acum_unidades_revision;
            document.getElementById("acum_monto_revision").value    = acum_monto_revision;
            // document.getElementById("botonenviar").style.display = 'none';
            document.getElementById("botonconfirmar").style.display = 'block';
               // return true;
         } else {
            alert(responseData.mensaje);
            // return false
         }
      });
   }
}

const confirma = () => {
   let data = new FormData();
   
   data.append("idembajador", id);
   data.append("imei",        document.getElementById("imei").value);

   fetch(URL, {
      method: 'POST',
      body: data
   })
   .then((response) => response.json())
   .then((responseData) => {
      alert(responseData.mensaje);
      if (responseData.exito==="SI") {
         limpiar();
         // document.getElementById("botonenviar").style.display = 'block';
         document.getElementById("botonconfirmar").style.display = 'none';
      } else {
         document.getElementById("form-submit").disabled = false;
      }
   });
}