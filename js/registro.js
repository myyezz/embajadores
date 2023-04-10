const URL = 'https://embajadores.cash-flag.com/api/registro.php';

const limpiar = () => {
   document.getElementById("nombre").value = "";
   document.getElementById("telefono").value = "";
   document.getElementById("email").value = "";
   document.getElementById("tienda").value = "";
   document.getElementById("direcciontienda").value = "";
   document.getElementById("tallafranela").value = "0";
   document.getElementById("password").value = "";
   document.getElementById("password2").value = "";
}

const inicio = () => {
   localStorage.clear();
}


const registro = () => {
   console.log('registro');
   if (document.getElementById("nombre").value != "" &&
   document.getElementById("telefono").value != "" &&
   document.getElementById("email").value != "" &&
   document.getElementById("tienda").value != "" &&
   document.getElementById("direcciontienda").value != "" &&
   document.getElementById("tallafranela").value != "0" &&
   document.getElementById("password").value != "" &&
   document.getElementById("password2").value != "") {
      console.log('entró');
      pwd1 = document.getElementById("password").value.trim();
      pwd2 = document.getElementById("password2").value.trim();
      if (pwd1.length>0 && pwd2.length>0) {
         if (!comparaigual(pwd1, pwd2)) {
            alert("Password no coincide");
            document.getElementById("password").focus()
         } else {
            document.getElementById("form-submit").disabled = true;
            let data = new FormData();

            data.append("nombre"         , document.getElementById("nombre").value);
            data.append("telefono"       , document.getElementById("telefono").value);
            data.append("email"          , document.getElementById("email").value);
            data.append("tienda"         , document.getElementById("tienda").value);
            data.append("direcciontienda", document.getElementById("direcciontienda").value);
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
                  alert('Solicitud de registro enviada. Recibirás un correo electrónico cuando se apruebe tu registro.')
                  limpiar();
               }
               document.getElementById("form-submit").disabled = false;
            });
         }
      } else {
         alert("Password no puede quedar en blanco");
         document.getElementById("password").focus()
      }
   }
}
