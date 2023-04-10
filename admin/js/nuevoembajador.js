const URL = 'https://embajadores.cash-flag.com/api/registrointerno.php';
const TIENDAS = 'https://embajadores.cash-flag.com/api/listatiendas.php?grupo=1';

const limpiar = () => {
   document.getElementById("nombre").value = "";
   document.getElementById("telefono").value = "";
   document.getElementById("email").value = "";
   document.getElementById("tienda").value = "0";
   document.getElementById("tallafranela").value = "0";
   document.getElementById("password").value = "";
}

const inicio = () => {
   localStorage.clear();
   busquedatiendas();
}

const busquedatiendas = () => {
   fetch(TIENDAS)
   .then((response) => response.json())
   .then((responseData) => {
      if (responseData.exito==="SI") {
         datos = responseData.registros;
         if (datos.length>0) {
            datos.forEach(elemento => {
               txtx = document.createTextNode(elemento.nombregrupo + ' - '+ elemento.nombre);
               opt = document.createElement("option");
               opt.value = elemento.id;
               opt.appendChild(txtx);
               document.getElementById('tienda').appendChild(opt);
            });
         }
      }
   });   
}

const registro = () => {
   console.log('registro');
   if (document.getElementById("nombre").value != "" &&
   document.getElementById("telefono").value != "" &&
   document.getElementById("email").value != "" &&
   document.getElementById("tienda").value != "0" &&
   document.getElementById("tallafranela").value != "0" &&
   document.getElementById("password").value != "") {
      console.log('entró');
      pwd1 = document.getElementById("password").value.trim();
      if (pwd1.length>0) {
         document.getElementById("form-submit").disabled = true;
         let data = new FormData();

         data.append("nombre"         , document.getElementById("nombre").value);
         data.append("telefono"       , document.getElementById("telefono").value);
         data.append("email"          , document.getElementById("email").value);
         data.append("tienda"         , document.getElementById("tienda").value);
         data.append("direcciontienda", "Registro interno");
         data.append("tallafranela"   , document.getElementById("tallafranela").value);
         data.append("password"       , document.getElementById("password").value);
         data.append("iddistribuidor" , 0);

         console.log(URL)
         fetch(URL, {
            method: 'POST',
            body: data
         })
         .then((response) => response.json())
         .then((responseData) => {
            if (responseData.exito==="SI") {
               alert('Registro exitoso.')
               limpiar();
            }
            document.getElementById("form-submit").disabled = false;
         });
      }
   }
}
