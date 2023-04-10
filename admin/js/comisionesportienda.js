const URL = 'https://myyezz.github.io/embajadores/api/comisionesportienda.php';
const GRUPOS = 'https://myyezz.github.io/embajadores/api/listatiendas.php?grupo=1';

let registros; 

const inicio = () => {
   localStorage.clear();
   busquedagrupos()
   f = new Date();
   y = f.getFullYear()
   xm = f.getMonth() + 1
   m = (xm<10) ? "0"+xm : xm ;
   xd = f.getDate();
   d = (xd<10) ? "0"+xd : xd ;
   document.getElementById("desde").value = y+'-'+m+'-01';
   document.getElementById("hasta").value = y+'-'+m+'-'+d;
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
               txtx = document.createTextNode(elemento.nombregrupo + ' - '+ elemento.nombre);
               // txtx = document.createTextNode(elemento.id + ' - ' + elemento.nombre);
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
   xembajador = document.getElementById('grupo').value;
   xdesde = document.getElementById('desde').value;
   xhasta = document.getElementById('hasta').value;

   LISTA = URL + "?idtienda="+xembajador + "&desde="+xdesde + "&hasta="+xhasta;
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
   clx.colSpan = 5;
   clx.appendChild(txtx);

   fila = document.createElement("tr");
   fila.appendChild(clx);

   document.getElementById("tabla").appendChild(fila);
}

const llenartabla = (registros) => {
   if (registros.length>0) {
      registros.forEach((elemento, indice) => {
         txt1 = document.createTextNode(elemento.imei);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         fecha = elemento.fecha.substr(8,2)+'/'+elemento.fecha.substr(5,2)+'/'+elemento.fecha.substr(0,4)
         txt5 = document.createTextNode(fecha);
         cl5 = document.createElement("td");
         cl5.appendChild(txt5);

         txt2 = document.createTextNode(elemento.comisionganada);
         cl2 = document.createElement("td");
         cl2.appendChild(txt2);

         txt21 = document.createTextNode(formatNumber.new(elemento.comisiondolares));
         cl21 = document.createElement("td");
         cl21.appendChild(txt21);

         txt3 = document.createTextNode(elemento.pagada);
         cl3 = document.createElement("td");
         cl3.appendChild(txt3);

         fila = document.createElement("tr");
         fila.appendChild(cl1);
         fila.appendChild(cl5);
         fila.appendChild(cl2);
         fila.appendChild(cl21);
         fila.appendChild(cl3);

         document.getElementById("tabla").appendChild(fila);
      });
   }
}
