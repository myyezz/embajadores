const LISTA = 'http://embajadores.myyezz.com/api/listamodelosemb.php';
const EQUIVALENCIA = 'http://embajadores.myyezz.com/api/equivalencia.php';

const inicio = () => {
   console.log(localStorage);
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
   }
   fetch(EQUIVALENCIA)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         document.getElementById('mensaje').innerHTML = '<b>(*) Equivalencia: ' + responseData.registros[0].puntospordolar + ' puntos por dolar.</b>';
      } else {
      }
   });   
   busqueda();
}

const busqueda = () => {
   totalfilas = document.getElementById("tabla").children.length;
   if (totalfilas>0) {
      for (i=0; i<totalfilas; i++) {
         document.getElementById("tabla").removeChild(document.getElementById("tabla").children[0])
      }
   }
   fetch(LISTA)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         registros = responseData.registros;
         llenartabla(registros);
      } else {
         listavacia();
      }
   });   
}

const listavacia = () => {
   txtx = document.createTextNode("Lista Vacía");
   clx = document.createElement("td");
   clx.style.textAlign = 'center';
   clx.colSpan = 3;
   clx.appendChild(txtx);

   fila = document.createElement("tr");
   fila.appendChild(clx);

   document.getElementById("tabla").appendChild(fila);
}

const llenartabla = (registros) => {
   if (registros.length>0) {
      registros.forEach(elemento => {
         // console.log(elemento);
         // txt0 = document.createTextNode(elemento.id);
         // cl0 = document.createElement("td");
         // cl0.appendChild(txt0);

         txt1 = document.createTextNode(elemento.nombre);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txt2 = document.createTextNode(elemento.comision);
         cl2 = document.createElement("td");
         cl2.style.textAlign = 'right';
         cl2.appendChild(txt2);

         txtstatus = document.createTextNode(elemento.status.substr(0,1).toUpperCase()+elemento.status.substr(1,100));
         cl3 = document.createElement("td");
         cl3.appendChild(txtstatus);

         fila = document.createElement("tr");
         // fila.appendChild(cl0);
         fila.appendChild(cl1);
         fila.appendChild(cl2);
         fila.appendChild(cl3);

         document.getElementById("tabla").appendChild(fila);
      });
   }
}
