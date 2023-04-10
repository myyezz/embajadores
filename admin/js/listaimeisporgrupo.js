const URL = 'http://embajadores.myyezz.com/api/listaimeisporgrupo.php';
const GRUPOS = 'http://embajadores.myyezz.com/api/listagrupos.php';

let registros; 

const inicio = () => {
   localStorage.clear();
   busquedagrupos()
   busqueda();
}

const busquedagrupos = () => {
   fetch(GRUPOS)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         grupos = responseData.registros;
         if (grupos.length>0) {
            grupos.forEach(elemento => {
               txtx = document.createTextNode(elemento.nombre);
               opt = document.createElement("option");
               opt.value = elemento.id;
               opt.appendChild(txtx);
               document.getElementById('grupo').appendChild(opt);
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
   LISTA = URL + "?idgrupo=" + document.getElementById('grupo').value;
   console.log(LISTA);
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
   console.log(registros);
   if (registros.length>0) {
      registros.forEach((elemento, indice) => {
         txt1 = document.createTextNode(elemento.imei);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txt5 = document.createTextNode(elemento.idmodelo +' - '+ elemento.nombre_modelo);
         cl5 = document.createElement("td");
         cl5.appendChild(txt5);

         txt2 = document.createTextNode(elemento.idtienda +' - '+ elemento.nombre_tienda);
         cl2 = document.createElement("td");
         cl2.appendChild(txt2);

         txt3 = document.createTextNode(elemento.vendido);
         cl3 = document.createElement("td");
         cl3.appendChild(txt3);

         fila = document.createElement("tr");
         fila.appendChild(cl1);
         fila.appendChild(cl5);
         fila.appendChild(cl2);
         fila.appendChild(cl3);

         document.getElementById("tabla").appendChild(fila);
      });
   }
}
