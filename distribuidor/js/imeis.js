const URL = 'https://embajadores.cash-flag.com/api/cargafile.php';

let archivos = [], archivo;

function handleFile(e) {
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

         first = true;
         for (i = fi+1; i < ff; i++) { // 24 filas desde la 2 hasta la 20
            x = i+2;
            // ID del cliente
            celda = "D"+x;
            idgrupo = (worksheet[celda].v!=undefined) ? worksheet[celda].v : 0 ;
            // UPC - Modelo
            celda = "F"+x;
            idmodelo = (worksheet[celda].v!=undefined) ? worksheet[celda].v.trim() : "" ;
            // imeis
            celda = "I"+x;
            xValor = (worksheet[celda].v!=undefined) ? worksheet[celda].v.trim() : "" ;
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
               tabla += '"iddistribuidor":' +  '1';
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
         .then((response) => response.json())
         .then((responseData) => {
            if (responseData.exito=="SI") {
               alert(responseData.mensaje);
               document.getElementById("archivo").value = "";
            } else {
               alert(responseData.mensaje);
            }
         });
      };
      reader.readAsArrayBuffer(f);
   }
}

const cargaimeis = () => {
   handleFile()
}
document.getElementById('form-submit').addEventListener('click', handleFile, false);
