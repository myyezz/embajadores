const URL = 'https://embajadores.cash-flag.com/api/modelos.php';
const LISTA = 'https://embajadores.cash-flag.com/api/listamodelos.php';

const limpiar = () => {
   document.getElementById("nombre").value = "";
   document.getElementById("comision").value = "";
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

         txt2 = document.createTextNode(formatNumber.new(elemento.comision));
         cl2 = document.createElement("td");
         cl2.style.textAlign = 'right';
         cl2.appendChild(txt2);

         fila = document.createElement("tr");
         fila.appendChild(cl1);
         fila.appendChild(cl2);

         document.getElementById("tabla").appendChild(fila);
      });
   }
}

const registro = () => {
   if (document.getElementById("nombre").value!="" && document.getElementById("comision").value!="") {
      document.getElementById("form-submit").disabled = true;
      let data = new FormData();

      data.append("nombre"  , document.getElementById("nombre").value);
      data.append("comision", document.getElementById("comision").value);

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
