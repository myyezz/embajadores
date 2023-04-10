const URL = 'http://embajadores.myyezz.com/api/comisionesenrevision.php';
const URL2 = 'http://embajadores.myyezz.com/api/revisioncomisiones.php';

let registros, id, imei; 

const inicio = () => {
   localStorage.clear();
   busqueda();
}

const busqueda = () => {
   totalfilas = document.getElementById("tabla").children.length;
   if (totalfilas>0) {
      for (i=0; i<totalfilas; i++) {
         document.getElementById("tabla").removeChild(document.getElementById("tabla").children[0])
      }
   }
   LISTA = URL;
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
   clx.colSpan = 5;
   clx.appendChild(txtx);

   fila = document.createElement("tr");
   fila.appendChild(clx);

   document.getElementById("tabla").appendChild(fila);
}

const llenartabla = (registros) => {
   if (registros.length>0) {
      registros.forEach((elemento, xindice) => {
         txt1 = document.createTextNode(elemento.imei);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txt5 = document.createTextNode(elemento.embajador);
         cl5 = document.createElement("td");
         cl5.appendChild(txt5);

         txt2 = document.createTextNode(elemento.comisionganada);
         cl2 = document.createElement("td");
         cl2.appendChild(txt2);

         txt21 = document.createTextNode(formatNumber.new(elemento.comisiondolares));
         cl21 = document.createElement("td");
         cl21.appendChild(txt21);

         txt3 = document.createTextNode(elemento.revision);
         cl3 = document.createElement("td");
         cl3.appendChild(txt3);

         fila = document.createElement("tr");
         fila.appendChild(cl1);
         fila.appendChild(cl5);
         fila.appendChild(cl2);
         fila.appendChild(cl21);
         fila.appendChild(cl3);
         fila.id = xindice + '-' + elemento.imei;

         fila.addEventListener("click", function() { editar(this.id) });
         fila.style.cursor = 'pointer';

         document.getElementById("tabla").appendChild(fila);
      });
   }
}

const editar = (idx) => {
   id = idx.split("-");
   console.log(registros[id[0]]);
   imei = id[1];
   document.getElementById("distribuidorcarga").value    = registros[id[0]].distribuidorcarga;
   document.getElementById("grupocarga").value           = registros[id[0]].grupocarga;
   document.getElementById("fechacarga").value           = registros[id[0]].fechacarga;

   document.getElementById("distribuidorregistro").value = registros[id[0]].distribuidorregistro;
   document.getElementById("gruporegistro").value        = registros[id[0]].gruporegistro;
   document.getElementById("fecharegistro").value        = registros[id[0]].fecharegistro;

   document.getElementById("distribuidorcarga").parentNode.classList.remove('is-empty');
   document.getElementById("grupocarga").parentNode.classList.remove('is-empty');
   document.getElementById("fechacarga").parentNode.classList.remove('is-empty');
   document.getElementById("distribuidorregistro").parentNode.classList.remove('is-empty');
   document.getElementById("gruporegistro").parentNode.classList.remove('is-empty');
   document.getElementById("fecharegistro").parentNode.classList.remove('is-empty');
}

const confirmar = () => {
   let data = new FormData();

   data.append("imei"    , imei);
   data.append("status", "confirmada");

   fetch(URL2, {
      method: 'POST',
      body: data
   })
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         busqueda();
      }
   });
}

const rechazar = () => {
   let data = new FormData();

   data.append("imei"    , imei);
   data.append("status", "rechazada");

   fetch(URL2, {
      method: 'POST',
      body: data
   })
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         busqueda();
      }
   });
}
