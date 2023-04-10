const URL = 'http://embajadores.myyezz.com/api/comisionesporfecha.php';

let registros; 

const inicio = () => {
   localStorage.clear();
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

const busqueda = () => {
   totalfilas = document.getElementById("tabla").children.length;
   if (totalfilas>0) {
      for (i=0; i<totalfilas; i++) {
         document.getElementById("tabla").removeChild(document.getElementById("tabla").children[0])
      }
   }
   LISTA = URL + "?desde="+document.getElementById('desde').value + "&hasta="+document.getElementById('hasta').value;
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
         txt1 = document.createTextNode(elemento.id +' - '+ elemento.nombre);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txt11 = document.createTextNode(elemento.puntos);
         cl11 = document.createElement("td");
         cl11.appendChild(txt11);

         txt5 = document.createTextNode(formatNumber.new(elemento.ganada));
         cl5 = document.createElement("td");
         cl5.appendChild(txt5);

         txt2 = document.createTextNode(formatNumber.new(elemento.pagada));
         cl2 = document.createElement("td");
         cl2.appendChild(txt2);

         txt3 = document.createTextNode(formatNumber.new(elemento.pendiente));
         cl3 = document.createElement("td");
         cl3.appendChild(txt3);

         fila = document.createElement("tr");
         fila.appendChild(cl1);
         fila.appendChild(cl11);
         fila.appendChild(cl5);
         fila.appendChild(cl2);
         fila.appendChild(cl3);

         document.getElementById("tabla").appendChild(fila);
      });
   }
}
