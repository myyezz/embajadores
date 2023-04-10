const GRUPOS = 'http://embajadores.myyezz.com/api/listaembajadores.php';

let registros; 

const inicio = () => {
   localStorage.clear();
   // busquedagrupos()
   busqueda();
}
/*
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
*/
const busqueda = () => {
   totalfilas = document.getElementById("tabla").children.length;
   if (totalfilas>0) {
      for (i=0; i<totalfilas; i++) {
         document.getElementById("tabla").removeChild(document.getElementById("tabla").children[0])
      }
   }
   LISTA = GRUPOS;
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
         txt1 = document.createTextNode(elemento.nombre);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txt5 = document.createTextNode(elemento.celular);
         cl5 = document.createElement("td");
         cl5.appendChild(txt5);

         txt2 = document.createTextNode(elemento.email);
         cl2 = document.createElement("td");
         cl2.appendChild(txt2);

         
         txt6 = document.createTextNode(elemento.tallafranela);
         cl6 = document.createElement("td");
         cl6.appendChild(txt6);

         txt7 = document.createTextNode(elemento.nombretienda);
         cl7 = document.createElement("td");
         cl7.appendChild(txt7);

         txt3 = document.createTextNode(elemento.nombregrupo+' ('+elemento.nombredistribuidor+')');
         cl3 = document.createElement("td");
         cl3.appendChild(txt3);

         fila = document.createElement("tr");
         fila.appendChild(cl1);
         fila.appendChild(cl5);
         fila.appendChild(cl2);
         fila.appendChild(cl6);
         fila.appendChild(cl7);
         fila.appendChild(cl3);

         document.getElementById("tabla").appendChild(fila);
      });
   }
}
