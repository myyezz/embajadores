const URL = 'https://myyezz.github.io/embajadores/api/comisionestotalesporfecha.php';

let registros, registrosx, distribuidores, grupos, tiendas; 

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
   totalfilas = document.getElementById("tabla").children.length;
   if (totalfilas>0) {
      for (i=0; i<totalfilas; i++) {
         document.getElementById("tabla").removeChild(document.getElementById("tabla").children[0])
      }
   }
}

const busqueda = () => {
   totalfilas = document.getElementById("tabla").children.length;
   if (totalfilas>0) {
      for (i=0; i<totalfilas; i++) {
         document.getElementById("tabla").removeChild(document.getElementById("tabla").children[0])
      }
   }
   LISTA = URL + "?desde="+document.getElementById('desde').value + "&hasta="+document.getElementById('hasta').value;
   // console.log(LISTA);
   fetch(LISTA)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         registros = responseData.registros;
         registrosx = responseData.registrosx;
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
   clx.colSpan = 9;
   clx.appendChild(txtx);

   fila = document.createElement("tr");
   fila.appendChild(clx);

   document.getElementById("tabla").appendChild(fila);
}

const llenartabla = (registros) => {
   if (registros.length>0) {
      registros.forEach((elemento) => {
         cl0d = document.createElement("td");
         cl0d1 = document.createElement("i");
         cl0d1.classList.add("material-icons");
         cl0d1.classList.add("mdi");
         cl0d1.classList.add("mdi-chevron-down");
         cl0d1.id = 'all-i';
         cl0d.classList.add("coli");
         cl0d.style.cursor = 'pointer';
         cl0d.addEventListener("click", function() { muestradistribuidores(elemento.distribuidores, 'all') });
         cl0d.appendChild(cl0d1);

         tx0g = document.createTextNode('-');
         cl0g = document.createElement("td");
         cl0g.classList.add("coli");
         cl0g.appendChild(tx0g);

         tx0t = document.createTextNode('-');
         cl0t = document.createElement("td");
         cl0t.classList.add("coli");
         cl0t.appendChild(tx0t);

         tx0e = document.createTextNode('-');
         cl0e = document.createElement("td");
         cl0e.classList.add("coli");
         cl0e.appendChild(tx0e);

         txt1 = document.createTextNode('TOTAL GENERAL COMISIONES');
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txti = document.createTextNode('');
         cli = document.createElement("td");
         cli.appendChild(txti);

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
         fila.id = "all";
         fila.classList.add('n0a');

         fila.appendChild(cl0d);
         fila.appendChild(cl0g);
         fila.appendChild(cl0t);
         fila.appendChild(cl0e);
         fila.appendChild(cl1);
         fila.appendChild(cli);
         fila.appendChild(cl11);
         fila.appendChild(cl5);
         fila.appendChild(cl2);
         fila.appendChild(cl3);

         document.getElementById("tabla").appendChild(fila);
         if (elemento.distribuidores.length>0) {
            llenardistribuidores(elemento.distribuidores, fila.id);
         }
      });
   }
}

const llenardistribuidores = (registros, id) => {
   if (registros.length>0) {
      registros.forEach((elemento) => {
         tx0d = document.createTextNode('-');
         cl0d = document.createElement("td");
         cl0d.classList.add("coli");
         cl0d.appendChild(tx0d);

         cl0g = document.createElement("td");
         cl0g1 = document.createElement("i");
         cl0g1.classList.add("material-icons");
         cl0g1.classList.add("mdi");
         cl0g1.classList.add("mdi-chevron-down");
         // cl0g1.id = id+'-'+elemento.id+'-i';
         cl0g1.id = elemento.id+'-i';
         cl0g.classList.add("coli");
         cl0g.style.cursor = 'pointer';
         // cl0g.addEventListener("click", function() { muestragrupos(elemento.grupos, id+'-'+elemento.id) });
         cl0g.addEventListener("click", function() { muestragrupos(elemento.grupos, elemento.id) });
         cl0g.appendChild(cl0g1);

         tx0t = document.createTextNode('-');
         cl0t = document.createElement("td");
         cl0t.classList.add("coli");
         cl0t.appendChild(tx0t);

         tx0e = document.createTextNode('-');
         cl0e = document.createElement("td");
         cl0e.classList.add("coli");
         cl0e.appendChild(tx0e);

         txt1 = document.createTextNode(elemento.id+' - '+elemento.nombre);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txti = document.createTextNode('');
         cli = document.createElement("td");
         cli.appendChild(txti);

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
         // fila.id = id+'-'+elemento.id;
         fila.id = elemento.id;
         fila.classList.add(id);
         // fila.classList.add('n0a');
         fila.classList.add('n1d');
         // fila.classList.add(elemento.id);

         fila.appendChild(cl0d);
         fila.appendChild(cl0g);
         fila.appendChild(cl0t);
         fila.appendChild(cl0e);
         fila.appendChild(cl1);
         fila.appendChild(cli);
         fila.appendChild(cl11);
         fila.appendChild(cl5);
         fila.appendChild(cl2);
         fila.appendChild(cl3);

         document.getElementById("tabla").appendChild(fila);
         if (elemento.grupos.length>0) {
            llenargrupos(elemento.grupos,fila.id, id, elemento.id);
         }
      });
   }
}

const llenargrupos = (registros, id, clid, clid2) => {
   if (registros.length>0) {
      registros.forEach((elemento) => {
         tx0d = document.createTextNode('-');
         cl0d = document.createElement("td");
         cl0d.classList.add("coli");
         cl0d.appendChild(tx0d);

         tx0g = document.createTextNode('-');
         cl0g = document.createElement("td");
         cl0g.classList.add("coli");
         cl0g.appendChild(tx0g);

         cl0t = document.createElement("td");
         cl0t1 = document.createElement("i");
         cl0t1.classList.add("material-icons");
         cl0t1.classList.add("mdi");
         cl0t1.classList.add("mdi-chevron-down");
         // cl0t1.id = id+'-'+elemento.id+'-i';
         cl0t1.id = elemento.id+'-i';
         cl0t.classList.add("coli");
         cl0t.style.cursor = 'pointer';
         // cl0t.addEventListener("click", function() { muestratiendas(elemento.tiendas, id+'-'+elemento.id) });
         cl0t.addEventListener("click", function() { muestratiendas(elemento.tiendas, elemento.id) });
         cl0t.appendChild(cl0t1);

         tx0e = document.createTextNode('-');
         cl0e = document.createElement("td");
         cl0e.classList.add("coli");
         cl0e.appendChild(tx0e);

         txt1 = document.createTextNode(elemento.id+' - '+elemento.nombre);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txti = document.createTextNode('');
         cli = document.createElement("td");
         cli.appendChild(txti);

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
         // fila.id = id+'-'+elemento.id;
         fila.id = elemento.id;
         // fila.classList.add(id);
         fila.classList.add(clid);
         fila.classList.add(clid2);
         fila.classList.add('n0a');
         fila.classList.add('n1d');
         fila.classList.add('n2g');
         // fila.classList.add(elemento.id);

         fila.appendChild(cl0d);
         fila.appendChild(cl0g);
         fila.appendChild(cl0t);
         fila.appendChild(cl0e);
         fila.appendChild(cl1);
         fila.appendChild(cli);
         fila.appendChild(cl11);
         fila.appendChild(cl5);
         fila.appendChild(cl2);
         fila.appendChild(cl3);

         document.getElementById("tabla").appendChild(fila);
         if (elemento.tiendas.length>0) {
            llenartiendas(elemento.tiendas,fila.id, clid, clid2, elemento.id);
         }
      });
   }
}

const llenartiendas = (registros, id, clid, clid2, clid3) => {
   if (registros.length>0) {
      registros.forEach((elemento) => {
         tx0d = document.createTextNode('-');
         cl0d = document.createElement("td");
         cl0d.classList.add("coli");
         cl0d.appendChild(tx0d);

         tx0g = document.createTextNode('-');
         cl0g = document.createElement("td");
         cl0g.classList.add("coli");
         cl0g.appendChild(tx0g);

         tx0t = document.createTextNode('-');
         cl0t = document.createElement("td");
         cl0t.classList.add("coli");
         cl0t.appendChild(tx0t);

         cl0e = document.createElement("td");
         cl0e1 = document.createElement("i");
         cl0e1.classList.add("material-icons");
         cl0e1.classList.add("mdi");
         cl0e1.classList.add("mdi-chevron-down");
         // cl0e1.id = id+'-'+elemento.id+'-i';
         cl0e1.id = elemento.id+'-i';
         cl0e.classList.add("coli");
         cl0e.style.cursor = 'pointer';
         // cl0e.addEventListener("click", function() { muestraembajadores(elemento.embajadores,id+'-'+elemento.id) });
         cl0e.addEventListener("click", function() { muestraembajadores(elemento.embajadores, elemento.id) });
         cl0e.appendChild(cl0e1);

         txt1 = document.createTextNode(elemento.id+' - '+elemento.nombre);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txti = document.createTextNode('');
         cli = document.createElement("td");
         cli.appendChild(txti);

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
         // fila.id = id+'-'+elemento.id;
         fila.id = elemento.id;
         // fila.classList.add(id);
         fila.classList.add(clid);
         fila.classList.add(clid2);
         fila.classList.add(clid3);
         fila.classList.add('n0a');
         fila.classList.add('n1d');
         fila.classList.add('n2g');
         fila.classList.add('n3t');
         // fila.classList.add(clid4);
         // fila.classList.add(elemento.id);

         fila.appendChild(cl0d);
         fila.appendChild(cl0g);
         fila.appendChild(cl0t);
         fila.appendChild(cl0e);
         fila.appendChild(cl1);
         fila.appendChild(cli);
         fila.appendChild(cl11);
         fila.appendChild(cl5);
         fila.appendChild(cl2);
         fila.appendChild(cl3);

         document.getElementById("tabla").appendChild(fila);
         if (elemento.embajadores.length>0) {
            llenarembajadores(elemento.embajadores, clid, clid2, clid3, elemento.id);
         }
      });
   }
}

const llenarembajadores = (registros, id, clid, clid2, clid3, clid4) => {
   if (registros.length>0) {
      registros.forEach((elemento) => {
         tx0d = document.createTextNode('-');
         cl0d = document.createElement("td");
         cl0d.classList.add("coli");
         cl0d.appendChild(tx0d);

         tx0g = document.createTextNode('-');
         cl0g = document.createElement("td");
         cl0g.classList.add("coli");
         cl0g.appendChild(tx0g);

         tx0t = document.createTextNode('-');
         cl0t = document.createElement("td");
         cl0t.classList.add("coli");
         cl0t.appendChild(tx0t);

         tx0e = document.createTextNode('-');
         cl0e = document.createElement("td");
         cl0e.classList.add("coli");
         cl0e.appendChild(tx0e);

         txt1 = document.createTextNode(elemento.id+' - '+elemento.nombre);
         cl1 = document.createElement("td");
         cl1.appendChild(txt1);

         txti = document.createTextNode(elemento.imei);
         cli = document.createElement("td");
         cli.appendChild(txti);

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
         fila.id = elemento.imei;
         fila.classList.add(id);
         fila.classList.add(clid);
         fila.classList.add(clid2);
         fila.classList.add(clid3);
         // fila.classList.add('n0a');
         fila.classList.add('n1d');
         fila.classList.add('n2g');
         fila.classList.add('n3t');
         fila.classList.add('n4e');
         // fila.classList.add(clid4);
         // fila.classList.add(elemento.id);

         fila.appendChild(cl0d);
         fila.appendChild(cl0g);
         fila.appendChild(cl0t);
         fila.appendChild(cl0e);
         fila.appendChild(cl1);
         fila.appendChild(cli);
         fila.appendChild(cl11);
         fila.appendChild(cl5);
         fila.appendChild(cl2);
         fila.appendChild(cl3);

         document.getElementById("tabla").appendChild(fila);
      });
   }
}

const muestraembajadores = (registros, id) => {
   if (document.getElementById(id+'-i').classList.contains("mdi-chevron-down")) {
      document.getElementById(id+'-i').classList.remove("mdi-chevron-down")
      document.getElementById(id+'-i').classList.add("mdi-chevron-right")
      document.getElementById(id).classList.add("is-collapsed")

      registros.forEach((elemento) => {
         document.getElementById(elemento.imei).style.display = 'none';
      });
   } else {
      document.getElementById(id+'-i').classList.remove("mdi-chevron-right")
      document.getElementById(id+'-i').classList.add("mdi-chevron-down")
      document.getElementById(id).classList.remove("is-collapsed")

      registros.forEach((elemento) => {
         document.getElementById(elemento.imei).style.display = 'table-row';
      });
   }
}

const muestratiendas = (registros, id) => {
   if (document.getElementById(id+'-i').classList.contains("mdi-chevron-down")) {
      document.getElementById(id+'-i').classList.remove("mdi-chevron-down")
      document.getElementById(id+'-i').classList.add("mdi-chevron-right")
      document.getElementById(id).classList.add("is-collapsed")

      // registros.forEach((elemento) => {
      //    document.getElementById(id+'-'+elemento.id).style.display = 'none';
      // });
      totalfilas = document.getElementById("tabla").children.length;
      if (totalfilas>0) {
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains(id)) {
               document.getElementById("tabla").children[i].style.display = 'none';
            }
         }
      }
   } else {
      document.getElementById(id+'-i').classList.remove("mdi-chevron-right")
      document.getElementById(id+'-i').classList.add("mdi-chevron-down")
      document.getElementById(id).classList.remove("is-collapsed")

      // registros.forEach((elemento) => {
      //    document.getElementById(id+'-'+elemento.id).style.display = 'table-row';
      // });
      totalfilas = document.getElementById("tabla").children.length;
      if (totalfilas>0) {
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains(id)) {
               document.getElementById("tabla").children[i].style.display = 'table-row';
            }
         }
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains('is-collapsed')) {
               xid = document.getElementById("tabla").children[i].id;
               console.log(xid);
               for (j=0; j<totalfilas; j++) {
                  if (document.getElementById("tabla").children[j].classList.contains(xid)) {
                     document.getElementById("tabla").children[j].style.display = 'none';
                  }
               }
            }
         }
      }
   }
}

const muestragrupos = (registros, id) => {
   if (document.getElementById(id+'-i').classList.contains("mdi-chevron-down")) {
      document.getElementById(id+'-i').classList.remove("mdi-chevron-down")
      document.getElementById(id+'-i').classList.add("mdi-chevron-right")
      document.getElementById(id).classList.add("is-collapsed")

      // registros.forEach((elemento) => {
      //    document.getElementById(elemento.id).style.display = 'none';
      // });
      totalfilas = document.getElementById("tabla").children.length;
      if (totalfilas>0) {
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains(id)) {
               document.getElementById("tabla").children[i].style.display = 'none';
            }
         }
      }
   } else {
      document.getElementById(id+'-i').classList.remove("mdi-chevron-right")
      document.getElementById(id+'-i').classList.add("mdi-chevron-down")
      document.getElementById(id).classList.remove("is-collapsed")

      // registros.forEach((elemento) => {
      //    document.getElementById(elemento.imei).style.display = 'table-row';
      // });
      totalfilas = document.getElementById("tabla").children.length;
      if (totalfilas>0) {
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains(id)) {
               document.getElementById("tabla").children[i].style.display = 'table-row';
            }
         }
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains('is-collapsed')) {
               xid = document.getElementById("tabla").children[i].id;
               console.log(xid);
               for (j=0; j<totalfilas; j++) {
                  if (document.getElementById("tabla").children[j].classList.contains(xid)) {
                     document.getElementById("tabla").children[j].style.display = 'none';
                  }
               }
            }
         }
      }
   }
}

const muestradistribuidores = (registros, id) => {
   if (document.getElementById(id+'-i').classList.contains("mdi-chevron-down")) {
      document.getElementById(id+'-i').classList.remove("mdi-chevron-down")
      document.getElementById(id+'-i').classList.add("mdi-chevron-right")
      document.getElementById(id).classList.add("is-collapsed")

      // registros.forEach((elemento) => {
      //    document.getElementById(elemento.id).style.display = 'none';
      // });
      totalfilas = document.getElementById("tabla").children.length;
      if (totalfilas>0) {
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains(id)) {
               document.getElementById("tabla").children[i].style.display = 'none';
            }
         }
      }
   } else {
      document.getElementById(id+'-i').classList.remove("mdi-chevron-right")
      document.getElementById(id+'-i').classList.add("mdi-chevron-down")
      document.getElementById(id).classList.remove("is-collapsed")

      // registros.forEach((elemento) => {
      //    document.getElementById(elemento.imei).style.display = 'table-row';
      // });
      totalfilas = document.getElementById("tabla").children.length;
      if (totalfilas>0) {
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains(id)) {
               document.getElementById("tabla").children[i].style.display = 'table-row';
            }
         }
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains('is-collapsed')) {
               xid = document.getElementById("tabla").children[i].id;
               console.log(xid);
               for (j=0; j<totalfilas; j++) {
                  if (document.getElementById("tabla").children[j].classList.contains(xid)) {
                     document.getElementById("tabla").children[j].style.display = 'none';
                  }
               }
            }
         }
      }
   }
}

const colapsa = (nivel) => {
   if (nivel=='n0a') {
      totalfilas = document.getElementById("tabla").children.length;
      if (totalfilas>0) {
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains('n1d') || document.getElementById("tabla").children[i].classList.contains('n2g') || document.getElementById("tabla").children[i].classList.contains('n3t') || document.getElementById("tabla").children[i].classList.contains('n4e')) {
               document.getElementById("tabla").children[i].style.display = 'none';
            } else {
               if (document.getElementById("tabla").children[i].classList.contains("is-collapsed")) {
                  document.getElementById("tabla").children[i].classList.remove("is-collapsed");
               }
               if (document.getElementById("tabla").children[i].classList.contains(nivel)) {
                  xid = document.getElementById("tabla").children[i].id+'-i';
                  console.log(xid);
                  if (document.getElementById(xid).classList.contains("mdi-chevron-down")) {
                     document.getElementById(xid).classList.remove("mdi-chevron-down");
                     document.getElementById(xid).classList.add("mdi-chevron-right");
                  }
               } else {
                  xid = document.getElementById("tabla").children[i].id+'-i';
                  console.log(xid);
                  if (document.getElementById(xid).classList.contains("mdi-chevron-right")) {
                     document.getElementById(xid).classList.remove("mdi-chevron-right");
                     document.getElementById(xid).classList.add("mdi-chevron-down");
                  }
               }
               document.getElementById("tabla").children[i].style.display = 'table-row';
            }
         }
      }
   }
   if (nivel=='n1d') {
      totalfilas = document.getElementById("tabla").children.length;
      if (totalfilas>0) {
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains('n2g') || document.getElementById("tabla").children[i].classList.contains('n3t') || document.getElementById("tabla").children[i].classList.contains('n4e')) {
               document.getElementById("tabla").children[i].style.display = 'none';
            } else {
               if (document.getElementById("tabla").children[i].classList.contains("is-collapsed")) {
                  document.getElementById("tabla").children[i].classList.remove("is-collapsed");
               }
               if (document.getElementById("tabla").children[i].classList.contains(nivel)) {
                  xid = document.getElementById("tabla").children[i].id+'-i';
                  if (document.getElementById(xid).classList.contains("mdi-chevron-down")) {
                     document.getElementById(xid).classList.remove("mdi-chevron-down");
                     document.getElementById(xid).classList.add("mdi-chevron-right");
                  }
               } else {
                  xid = document.getElementById("tabla").children[i].id+'-i';
                  if (document.getElementById(xid).classList.contains("mdi-chevron-right")) {
                     document.getElementById(xid).classList.remove("mdi-chevron-right");
                     document.getElementById(xid).classList.add("mdi-chevron-down");
                  }
               }
               document.getElementById("tabla").children[i].style.display = 'table-row';
            }
         }
      }
   }
   if (nivel=='n2g') {
      totalfilas = document.getElementById("tabla").children.length;
      if (totalfilas>0) {
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains('n3t') || document.getElementById("tabla").children[i].classList.contains('n4e')) {
               document.getElementById("tabla").children[i].style.display = 'none';
            } else {
               if (document.getElementById("tabla").children[i].classList.contains("is-collapsed")) {
                  document.getElementById("tabla").children[i].classList.remove("is-collapsed");
               }
               if (document.getElementById("tabla").children[i].classList.contains(nivel)) {
                  xid = document.getElementById("tabla").children[i].id+'-i';
                  if (document.getElementById(xid).classList.contains("mdi-chevron-down")) {
                     document.getElementById(xid).classList.remove("mdi-chevron-down");
                     document.getElementById(xid).classList.add("mdi-chevron-right");
                  }
               } else {
                  xid = document.getElementById("tabla").children[i].id+'-i';
                  if (document.getElementById(xid).classList.contains("mdi-chevron-right")) {
                     document.getElementById(xid).classList.remove("mdi-chevron-right");
                     document.getElementById(xid).classList.add("mdi-chevron-down");
                  }
               }
               document.getElementById("tabla").children[i].style.display = 'table-row';
            }
         }
      }
   }
   if (nivel=='n3t') {
      totalfilas = document.getElementById("tabla").children.length;
      if (totalfilas>0) {
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains('n4e')) {
               document.getElementById("tabla").children[i].style.display = 'none';
            } else {
               if (document.getElementById("tabla").children[i].classList.contains("is-collapsed")) {
                  document.getElementById("tabla").children[i].classList.remove("is-collapsed");
               }
               if (document.getElementById("tabla").children[i].classList.contains(nivel)) {
                  xid = document.getElementById("tabla").children[i].id+'-i';
                  if (document.getElementById(xid).classList.contains("mdi-chevron-down")) {
                     document.getElementById(xid).classList.remove("mdi-chevron-down");
                     document.getElementById(xid).classList.add("mdi-chevron-right");
                  }
               } else {
                  xid = document.getElementById("tabla").children[i].id+'-i';
                  if (document.getElementById(xid).classList.contains("mdi-chevron-right")) {
                     document.getElementById(xid).classList.remove("mdi-chevron-right");
                     document.getElementById(xid).classList.add("mdi-chevron-down");
                  }
               }
               document.getElementById("tabla").children[i].style.display = 'table-row';
            }
         }
      }
   }
   if (nivel=='n4e') {
      totalfilas = document.getElementById("tabla").children.length;
      if (totalfilas>0) {
         for (i=0; i<totalfilas; i++) {
            if (document.getElementById("tabla").children[i].classList.contains("is-collapsed")) {
               document.getElementById("tabla").children[i].classList.remove("is-collapsed");
            }
            if (!document.getElementById("tabla").children[i].classList.contains(nivel)) {
               xid = document.getElementById("tabla").children[i].id+'-i';
               console.log(xid);
               if (document.getElementById(xid).classList.contains("mdi-chevron-right")) {
                  document.getElementById(xid).classList.remove("mdi-chevron-right");
                  document.getElementById(xid).classList.add("mdi-chevron-down");
               }
            }
            document.getElementById("tabla").children[i].style.display = 'table-row';
         }
      }
   }
}
