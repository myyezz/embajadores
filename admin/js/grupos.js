const URL = 'https://myyezz.github.io/embajadores/api/grupos.php';
const LISTA = 'https://myyezz.github.io/embajadores/api/listagrupos.php';

const limpiar = () => {
   document.getElementById("indice").value = "New";
   document.getElementById("idgrupo").value = "";
   document.getElementById("nombre").value = "";
   document.getElementById("telefono").value = "";
   document.getElementById("email").value = "";
   document.getElementById("direccion").value = "";
   document.getElementById("contacto").value = "";
   document.getElementById("telefonocontacto").value = "";
   document.getElementById("status").value = "0";
}

const inicio = () => {
   localStorage.clear();
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
         txt1 = document.createTextNode(elemento.nombre);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txt2 = document.createTextNode(elemento.celular);
         cl2 = document.createElement("td");
         cl2.appendChild(txt2);

         txt3 = document.createTextNode(elemento.email);
         cl3 = document.createElement("td");
         cl3.appendChild(txt3);

         txt4 = document.createTextNode(elemento.contacto);
         cl4 = document.createElement("td");
         cl4.appendChild(txt4);

         fila = document.createElement("tr");
         fila.appendChild(cl1);
         fila.appendChild(cl2);
         fila.appendChild(cl3);
         fila.appendChild(cl4);
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
   document.getElementById("nombre").value           = registros[id[0]].nombre;
   document.getElementById("telefono").value         = registros[id[0]].celular;
   document.getElementById("email").value            = registros[id[0]].email;
   document.getElementById("direccion").value        = registros[id[0]].direccion;
   document.getElementById("contacto").value         = registros[id[0]].contacto;
   document.getElementById("telefonocontacto").value = registros[id[0]].celularcontacto;
   document.getElementById("status").value           = registros[id[0]].status;
   document.getElementById("indice").value           = id[1];
   document.getElementById("idgrupo").value          = id[1];

   document.getElementById("nombre").parentNode.classList.remove('is-empty');
   document.getElementById("telefono").parentNode.classList.remove('is-empty');
   document.getElementById("email").parentNode.classList.remove('is-empty');
   document.getElementById("direccion").parentNode.classList.remove('is-empty');
   document.getElementById("contacto").parentNode.classList.remove('is-empty');
   document.getElementById("telefonocontacto").parentNode.classList.remove('is-empty');
   document.getElementById("status").parentNode.classList.remove('is-empty');
   document.getElementById("indice").parentNode.classList.remove('is-empty');
   document.getElementById("idgrupo").parentNode.classList.remove('is-empty');

   document.getElementById("nombre").focus();
}

const registro = () => {
   if (document.getElementById("idgrupo").value!="" &&
   document.getElementById("nombre").value!="" && 
   document.getElementById("telefono").value!="" && 
   document.getElementById("email").value!="" && 
   document.getElementById("direccion").value!="" && 
   document.getElementById("contacto").value!="" && 
   document.getElementById("telefonocontacto").value!="") {
      console.log('entró');
      document.getElementById("form-submit").disabled = true;
      let data = new FormData();

      data.append("id"             , document.getElementById("idgrupo").value);
      data.append("indice"         , document.getElementById("indice").value);
      data.append("nombre"         , document.getElementById("nombre").value);
      data.append("idejecutivo"    , 0);
      data.append("celular"        , document.getElementById("telefono").value);
      data.append("email"          , document.getElementById("email").value);
      data.append("direccion"      , document.getElementById("direccion").value);
      data.append("contacto"       , document.getElementById("contacto").value);
      data.append("celularcontacto", document.getElementById("telefonocontacto").value);
      data.append("status"         , document.getElementById("status").value);
      data.append("iddistribuidor" , 0);

      fetch(URL, {
         method: 'POST',
         body: data
      })
      .then((response) => response.json())
      .then((responseData) => {
         if (responseData.exito==="SI") {
            limpiar();
            busqueda();
         } else {
            alert(responseData.mensaje);
         }
         document.getElementById("form-submit").disabled = false;
      });
   } else {
      console.log('no entró');
   }
}
