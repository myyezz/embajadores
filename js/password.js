const URL = 'https://myyezz.github.io/embajadores/api/password.php';

const limpiar = () => {
   document.getElementById("password").value = "";
   document.getElementById("password2").value = "";
}

const cambiodepassword = () => {
   if (document.getElementById("password").value!="" && document.getElementById("password2").value!="") {
      pwd1 = document.getElementById("password").value.trim();
      pwd2 = document.getElementById("password2").value.trim();
      if (pwd1!=pwd2) {
         alert("Password no coincide");
         document.getElementById("password").focus();
      } else {
         if (pwd1.length<4) {
            alert("Password debe contener más de 4 caracteres");
            document.getElementById("password").focus();
         } else {
            document.getElementById("form-submit").disabled = true;
            let data = new FormData();
      
            data.append("email",    localStorage.getItem('email'));
            data.append("password", pwd1);
      
            fetch(URL, {
               method: 'POST',
               body: data
            })
            .then((response) => response.json())
            .then((responseData) => {
               console.log(responseData);
               if (responseData.exito==="SI") {
                  localStorage.setItem('token'                 , responseData.registros[0].token);
                  localStorage.setItem('id'                    , responseData.registros[0].id);
                  localStorage.setItem('email'                 , responseData.registros[0].email);
                  localStorage.setItem('nombre'                , responseData.registros[0].nombre);
                  localStorage.setItem('idtienda'              , responseData.registros[0].idtienda);
                  localStorage.setItem('nombretienda'          , responseData.registros[0].nombretienda);
                  localStorage.setItem('idgrupo'               , responseData.registros[0].idtienda);
                  localStorage.setItem('iddistribuidor'        , responseData.registros[0].idtienda);
                  localStorage.setItem('acum_unidades'         , responseData.registros[0].acum_unidades);
                  localStorage.setItem('acum_monto'            , responseData.registros[0].acum_monto);
                  localStorage.setItem('acum_unidades_revision', responseData.registros[0].acum_unidades_revision);
                  localStorage.setItem('acum_monto_revision'   , responseData.registros[0].acum_monto_revision);
                  window.open('./ventas.html', '_self');
                  limpiar();
               } else {
                  alert(responseData.mensaje);
                  document.getElementById("form-submit").disabled = false;
               }
            });
         }
      }
   } else {
      alert("No puede dejar el campo en blanco");
      document.getElementById("password").focus();
   }
}
