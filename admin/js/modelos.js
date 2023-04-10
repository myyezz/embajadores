const URL = 'https://myyezz.github.io/embajadores/api/modelos.php';
const LISTA = 'https://myyezz.github.io/embajadores/api/listamodelos.php';
const EQUIVALENCIA = 'https://myyezz.github.io/embajadores/api/equivalencia.php';

const limpiar = () => {
   document.getElementById("indice").value = "New";
   document.getElementById("idmodelo").value = "";
   document.getElementById("nombre").value = "";
   document.getElementById("comision").value = "";
   document.getElementById("status").value = "0";
}

const inicio = () => {
   localStorage.clear();
   fetch(EQUIVALENCIA)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         document.getElementById('mensaje').innerHTML = '<b>(*) Equivalencia: ' + responseData.registros[0].puntospordolar + ' puntos por dolar.</b>';
      } else {
      }
   });   
   limpiar();
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
   clx.colSpan = 4;
   clx.appendChild(txtx);

   fila = document.createElement("tr");
   fila.appendChild(clx);

   document.getElementById("tabla").appendChild(fila);
}

const llenartabla = (registros) => {
   if (registros.length>0) {
      registros.forEach((elemento, xindice) => {
         txt0 = document.createTextNode(elemento.id);
         cl0 = document.createElement("td");
         cl0.appendChild(txt0);

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
         fila.appendChild(cl0);
         fila.appendChild(cl1);
         fila.appendChild(cl2);
         fila.appendChild(cl3);
         fila.id = xindice + '-' + elemento.id;

         fila.addEventListener("click", function() { editar(this.id) });
         fila.style.cursor = 'pointer';

         document.getElementById("tabla").appendChild(fila);
      });
   }
}

const editar = (idx) => {
   id = idx.split("-");
   console.log(registros[id[0]]);
   document.getElementById("nombre").value          = registros[id[0]].nombre;
   document.getElementById("comision").value        = registros[id[0]].comision;
   document.getElementById("status").value          = registros[id[0]].status;
   document.getElementById("indice").value          = id[1];
   document.getElementById("idmodelo").value        = id[1];

   document.getElementById("nombre").parentNode.classList.remove('is-empty');
   document.getElementById("comision").parentNode.classList.remove('is-empty');
   document.getElementById("status").parentNode.classList.remove('is-empty');
   document.getElementById("indice").parentNode.classList.remove('is-empty');
   document.getElementById("idmodelo").parentNode.classList.remove('is-empty');

   document.getElementById("nombre").focus();
}

const registro = () => {
   if (document.getElementById("idmodelo").value!="" && document.getElementById("nombre").value!="" && document.getElementById("comision").value!="") {
      document.getElementById("form-submit").disabled = true;
      let data = new FormData();

      data.append("id"      , document.getElementById("idmodelo").value);
      data.append("indice"  , document.getElementById("indice").value);
      data.append("nombre"  , document.getElementById("nombre").value);
      data.append("comision", document.getElementById("comision").value);
      data.append("status"  , document.getElementById("status").value);

      fetch(URL, {
         method: 'POST',
         body: data
      })
      .then((response) => response.json())
      .then((responseData) => {
         if (responseData.exito==="SI") {
            limpiar();
            busqueda();
         }
         document.getElementById("form-submit").disabled = false;
      });
   }
}
