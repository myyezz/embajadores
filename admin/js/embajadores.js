const URL = 'https://myyezz.github.io/embajadores/api/embajadores.php';
const LISTA = 'https://myyezz.github.io/embajadores/api/listaembajadores.php';
const TIENDAS = 'https://myyezz.github.io/embajadores/api/listatiendas.php?grupo=1';

let registros;

const limpiar = () => {
   document.getElementById("indice").value = "New";
   document.getElementById("nombre").value = "";
   document.getElementById("telefono").value = "";
   document.getElementById("email").value = "";
   document.getElementById("tallafranela").value = "";
   document.getElementById("tienda").value = "0";
   document.getElementById("status").value = "0";
}

const inicio = () => {
   localStorage.clear();
   limpiar();
   busquedatiendas()
   busqueda();
}

const busquedatiendas = () => {
   fetch(TIENDAS)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         datos = responseData.registros;
         if (datos.length>0) {
            datos.forEach(elemento => {
               txtx = document.createTextNode(elemento.nombregrupo + ' - '+ elemento.nombre);
               opt = document.createElement("option");
               opt.value = elemento.id;
               opt.appendChild(txtx);
               document.getElementById('tienda').appendChild(opt);
            });
         }
      }
   });   
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
      registros.forEach((elemento, indice) => {
         txt1 = document.createTextNode(elemento.id + ' - '+ elemento.nombre);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txt2 = document.createTextNode(elemento.celular);
         cl2 = document.createElement("td");
         cl2.appendChild(txt2);

         txt3 = document.createTextNode(elemento.email);
         cl3 = document.createElement("td");
         cl3.appendChild(txt3);

         xst = elemento.status.substr(0,1).toUpperCase() + elemento.status.substr(1,100);
         txt4 = document.createTextNode(xst);
         cl4 = document.createElement("td");
         cl4.appendChild(txt4);

         fila = document.createElement("tr");
         fila.id = indice + '-' + elemento.id;
         fila.appendChild(cl1);
         fila.appendChild(cl2);
         fila.appendChild(cl3);
         fila.appendChild(cl4);

         fila.addEventListener("click", function() { editar(this.id) });
         fila.style.cursor = 'pointer';

         document.getElementById("tabla").appendChild(fila);
      });
   }
}

const editar = (idx) => {
   id = idx.split("-");
   document.getElementById("nombre").value       = registros[id[0]].nombre;
   document.getElementById("telefono").value     = registros[id[0]].celular;
   document.getElementById("email").value        = registros[id[0]].email;
   document.getElementById("tallafranela").value = registros[id[0]].tallafranela;
   document.getElementById("tienda").value       = registros[id[0]].idtienda;
   document.getElementById("status").value       = registros[id[0]].status;
   document.getElementById("indice").value       = id[1];

   document.getElementById("nombre").parentNode.classList.remove('is-empty');
   document.getElementById("telefono").parentNode.classList.remove('is-empty');
   document.getElementById("email").parentNode.classList.remove('is-empty');
   document.getElementById("tallafranela").parentNode.classList.remove('is-empty');
   document.getElementById("tienda").parentNode.classList.remove('is-empty');
   document.getElementById("status").parentNode.classList.remove('is-empty');
   document.getElementById("indice").parentNode.classList.remove('is-empty');

   document.getElementById("nombre").focus();
}

const registro = () => {
   if (document.getElementById("nombre").value!="" && 
   document.getElementById("telefono").value!="" && 
   document.getElementById("email").value!="" && 
   document.getElementById("tallafranela").value!="0" && 
   document.getElementById("tienda").value!="0" && 
   document.getElementById("status").value!="0") {
      document.getElementById("form-submit").disabled = true;
      let data = new FormData();

      data.append("id"          , document.getElementById("indice").value);
      data.append("nombre"      , document.getElementById("nombre").value);
      data.append("telefono"    , document.getElementById("telefono").value);
      data.append("email"       , document.getElementById("email").value);
      data.append("tallafranela", document.getElementById("tallafranela").value);
      data.append("idtienda"    , document.getElementById("tienda").value);
      data.append("status"      , document.getElementById("status").value);

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
