const URL = 'https://embajadores.cash-flag.com/api/candidatos.php';
const LISTA = 'https://embajadores.cash-flag.com/api/listacandidatos.php';
const TIENDAS = 'https://embajadores.cash-flag.com/api/listatiendas.php?grupo=1';

let xtiendas, registros;

const limpiar = () => {
   document.getElementById("nombre").value = "";
   document.getElementById("telefono").value = "";
   document.getElementById("email").value = "";
   document.getElementById("tallafranela").value = "";
   document.getElementById("tienda1").value = "";
   document.getElementById("direcciontienda").value = "";
   document.getElementById("tienda2").value = "0";
}

const inicio = () => {
   localStorage.clear();
   busquedatiendas()
   busqueda();
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
               document.getElementById('tienda2').appendChild(opt);
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
         txt1 = document.createTextNode(elemento.id +' - '+ elemento.nombre);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txt2 = document.createTextNode(elemento.celular);
         cl2 = document.createElement("td");
         cl2.appendChild(txt2);

         txt3 = document.createTextNode(elemento.email);
         cl3 = document.createElement("td");
         cl3.appendChild(txt3);

         txt4 = document.createTextNode(elemento.status);
         cl4 = document.createElement("td");
         cl4.appendChild(txt4);

         fila = document.createElement("tr");
         fila.appendChild(cl1);
         fila.appendChild(cl2);
         fila.appendChild(cl3);
         fila.appendChild(cl4);
         fila.id = indice + '-' + elemento.id;

         fila.addEventListener("click", function() { editar(this.id) });
         fila.style.cursor = 'pointer';

         document.getElementById("tabla").appendChild(fila);
      });
   }
}

const editar = (idx) => {
   id = idx.split("-");
   document.getElementById("nombre").value          = registros[id[0]].nombre;
   document.getElementById("telefono").value        = registros[id[0]].celular;
   document.getElementById("email").value           = registros[id[0]].email;
   document.getElementById("tallafranela").value    = registros[id[0]].tallafranela;
   document.getElementById("tienda1").value         = registros[id[0]].nombretienda;
   document.getElementById("direcciontienda").value = registros[id[0]].direcciontienda;
   document.getElementById("tienda2").value         = registros[id[0]].idtienda;
   document.getElementById("indice").value          = id[1];

   document.getElementById("nombre").parentNode.classList.remove('is-empty');
   document.getElementById("telefono").parentNode.classList.remove('is-empty');
   document.getElementById("email").parentNode.classList.remove('is-empty');
   document.getElementById("tallafranela").parentNode.classList.remove('is-empty');
   document.getElementById("tienda1").parentNode.classList.remove('is-empty');
   document.getElementById("direcciontienda").parentNode.classList.remove('is-empty');
   document.getElementById("tienda2").parentNode.classList.remove('is-empty');
   document.getElementById("indice").parentNode.classList.remove('is-empty');

   document.getElementById("nombre").focus();
}

const confirmar = () => {
   if (document.getElementById("nombre").value!="" && 
   document.getElementById("telefono").value!="" && 
   document.getElementById("email").value!="" && 
   document.getElementById("tallafranela").value!="0" && 
   document.getElementById("tienda2").value!="0") {
      document.getElementById("form-submit").disabled = true;
      document.getElementById("form-submit2").disabled = true;
      let data = new FormData();

      data.append("id"          , document.getElementById("indice").value);
      data.append("nombre"      , document.getElementById("nombre").value);
      data.append("telefono"    , document.getElementById("telefono").value);
      data.append("email"       , document.getElementById("email").value);
      data.append("tallafranela", document.getElementById("tallafranela").value);
      data.append("idtienda"    , document.getElementById("tienda2").value);
      data.append("status"      , "activo");

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
         document.getElementById("form-submit2").disabled = false;
      });
   } else {
      alert('Debe completar todos los campos, revise de nuevo el formulario')
   }
}

const rechazar = () => {
   if (confirm("¿Seguro de rechazar a este candidato?")) {
      document.getElementById("form-submit").disabled = true;
      document.getElementById("form-submit2").disabled = true;
      let data = new FormData();

      data.append("id"          , document.getElementById("indice").value);
      data.append("nombre"      , document.getElementById("nombre").value);
      data.append("email"       , document.getElementById("email").value);
      data.append("status"      , "rechazado");

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
         document.getElementById("form-submit2").disabled = false;
      });
   }
}
