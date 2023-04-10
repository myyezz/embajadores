const URL = 'https://myyezz.github.io/embajadores/api/grupos.php';
const LISTA = 'https://myyezz.github.io/embajadores/api/listagrupos.php';

const limpiar = () => {
   document.getElementById("nombre").value = "";
   document.getElementById("telefono").value = "";
   document.getElementById("email").value = "";
   document.getElementById("direccion").value = "";
   document.getElementById("contacto").value = "";
   document.getElementById("telefonocontacto").value = "";
}

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
      registros.forEach(elemento => {
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

         document.getElementById("tabla").appendChild(fila);
      });
   }
}

const registro = () => {
   if (document.getElementById("nombre").value!="" && 
   document.getElementById("telefono").value!="" && 
   document.getElementById("email").value!="" && 
   document.getElementById("direccion").value!="" && 
   document.getElementById("contacto").value!="" && 
   document.getElementById("telefonocontacto").value!="") {
      document.getElementById("form-submit").disabled = true;
      let data = new FormData();

      data.append("nombre"         , document.getElementById("nombre").value);
      data.append("idejecutivo"    , 0);
      data.append("celular"        , document.getElementById("telefono").value);
      data.append("email"          , document.getElementById("email").value);
      data.append("direccion"      , document.getElementById("direccion").value);
      data.append("contacto"       , document.getElementById("contacto").value);
      data.append("celularcontacto", document.getElementById("telefonocontacto").value);
      data.append("iddistribuidor" , 1);

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
