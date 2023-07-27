const URL = 'https://embajadores.cash-flag.com/api/cargafile.php';

let archivos = [], archivo;

function handleFile(e) {
   document.getElementById("span-form-submit").innerHTML = " Procesando...";
   letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   // Check for the various File API support.
   if (window.File && window.FileReader && window.FileList && window.Blob) {
      // Great success! All the File APIs are supported.
      let file = document.getElementById('archivo').files[0];
      let f = file;
      let reader = new FileReader();

      reader.onload = function() {
         let data = new Uint8Array(reader.result);
         let workbook = XLSX.read(data, {type: 'array'});

         /* DO SOMETHING WITH workbook HERE */
         // archivos.push(archivo[0]);

         xHoja = 0;
         
         worksheet = workbook.Sheets[workbook.SheetNames[xHoja]];
         rango = XLSX.utils.decode_range(worksheet['!ref']);
         ci     = rango.s.c;
         fi     = rango.s.r;
         cf     = rango.e.c;
         ff     = rango.e.r;

         tabla  = '{"registros":';
         tabla += '[';

         errores = 0;
         for (i = fi+1; i <= ff; i++) { // 24 filas desde la 2 hasta la 20
            x = i+1;
            // ID del cliente
            celda = "A"+x;
            errores += (worksheet[celda]!=undefined) ? 0 : 1;
            // UPC - Modelo
            celda = "C"+x;
            errores += (worksheet[celda]!=undefined) ? 0 : 1;
            // imeis
            celda = "E"+x;
            errores += (worksheet[celda]!=undefined) ? 0 : 1;
         }
         if (errores>0) {
            alert('Hay errores en la estructura del archivo, por favor revisar e intentar de nuevo.');
            tabla += ']}';
            document.getElementById("archivo").value = "";
            document.getElementById("span-form-submit").innerHTML = " Enviar";
         } else {
            first = true;
            for (i = fi+1; i <= ff; i++) { // 24 filas desde la 2 hasta la 20
               x = i+1;
               // ID del cliente
               celda = "A"+x;
               idgrupo = (worksheet[celda].v!=undefined) ? worksheet[celda].v : 0 ;
               // UPC - Modelo
               celda = "C"+x;
               idmodelo = (worksheet[celda].v!=undefined) ? worksheet[celda].v.trim() : "" ;
               // imeis
               celda = "E"+x;
               xValor = (worksheet[celda].v!=undefined) ? String(worksheet[celda].v).trim() : "" ;
               aValor = xValor.split(",");
               if (idgrupo!=0 && idmodelo!="" && xValor!="") {
                  if (first) {
                     first = false;
                     coma = "";
                  } else {
                     coma = ",";
                  }
                  tabla += coma+'{';
                  // ID del distribuidor
                  tabla += '"iddistribuidor":' +  '0';
                  // ID del cliente
                  tabla += ',"idgrupo":' +  idgrupo;
                  // ID de la tienda
                  tabla += ',"idtienda":' +  '0';
                  // UPC - Modelo
                  tabla += ',"idmodelo":"' +  idmodelo + '"';
                  // imeis
                  tabla += ',"imeis":[';
                  com2 = '';
                  firs2 = true;
                  aValor.forEach(element => {
                     if (firs2) { firs2 = false; } else { com2 = ','; }
                     tabla += com2+'"'+element.trim()+'"';
                  });
                  tabla += ']';
                  tabla += '}';
               }
            }
            tabla += ']}';
   
            datos = new FormData();
            datos.append("registros", tabla);
   
            fetch(URL, {
               method: 'POST',
               body: datos
            })
            .then((response) => {console.log(response); response.json();})
            .then((responseData) => {
               if (responseData.exito=="SI") {
                  alert(responseData.mensaje);
                  console.log(responseData);
                  llenartabla(file.name, responseData);
                  document.getElementById("archivo").value = "";
               } else {
                  alert(responseData.mensaje);
               }
            });
         }
      };
      reader.readAsArrayBuffer(f);
   }
}

const cargaimeis = () => {
   handleFile()
}
document.getElementById('form-submit').addEventListener('click', handleFile, false);

const llenartabla = (file, registros) => {
   if (registros.correctos.length>0) {
      txt = "";
      coma = '';
      first = true;
      registros.correctos.forEach((elemento) => {
         if (first) {
            first = false;
         } else {
            coma = ', ';
         }
         txt += coma+elemento;
      });
      txt0 = document.createTextNode(file+' - Registros correctos: ');
      txt1 = document.createTextNode(txt);
      cl1 = document.createElement("td");
      sp1 = document.createElement("span");
      sp2 = document.createElement("span");
      sp1.appendChild(txt0);
      sp2.appendChild(txt1);
      cl1.appendChild(sp1);
      cl1.appendChild(sp2);

      fila = document.createElement("tr");
      fila.appendChild(cl1);
      document.getElementById("tabla").appendChild(fila);
   }

   if (registros.duplicados.length>0) {
      txt = "";
      coma = '';
      first = true;
      registros.duplicados.forEach((elemento) => {
         if (first) {
            first = false;
         } else {
            coma = ', ';
         }
         txt += coma+elemento;
      });
      txt0 = document.createTextNode(file+' - Registros duplicados: ');
      txt1 = document.createTextNode(txt);
      cl1 = document.createElement("td");
      cl1.style.display = 'flex';
      cl1.style.flexDirection = 'column';
      sp1 = document.createElement("span");
      sp2 = document.createElement("span");
      sp1.appendChild(txt0);
      sp2.appendChild(txt1);
      cl1.appendChild(sp1);
      cl1.appendChild(sp2);

      fila = document.createElement("tr");
      fila.appendChild(cl1);
      document.getElementById("tabla").appendChild(fila);
   }

   if (registros.invalidos.length>0) {
      txt = "";
      coma = '';
      first = true;
      registros.invalidos.forEach((elemento) => {
         if (first) {
            first = false;
         } else {
            coma = ', ';
         }
         txt += coma+elemento;
      });
      txt0 = document.createTextNode(file+' - Registros inválidos: ');
      txt1 = document.createTextNode(txt);
      cl1 = document.createElement("td");
      sp1 = document.createElement("span");
      sp2 = document.createElement("span");
      sp1.appendChild(txt0);
      sp2.appendChild(txt1);
      cl1.appendChild(sp1);
      cl1.appendChild(sp2);

      fila = document.createElement("tr");
      fila.appendChild(cl1);
      document.getElementById("tabla").appendChild(fila);
   }
   document.getElementById("span-form-submit").innerHTML = " Enviar";
}
