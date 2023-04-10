const URL = 'https://myyezz.github.io/embajadores/api/login.php';
const USER = 'https://myyezz.github.io/embajadores/api/user.php';

const registro = () => {
   window.open("./registro.html","_self");
}

const limpiar = () => {
   document.getElementById("email").value = "";
   document.getElementById("password").value = "";
}

const login = () => {
   if (validaemail(document.getElementById("email").id, document.getElementById("email").value) &&
   document.getElementById("password").value!="") {
      document.getElementById("form-submit").disabled = true;
      let data = new FormData();

      data.append("email",    document.getElementById("email").value);
      data.append("password", document.getElementById("password").value);

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
            if (responseData.registros[0].nuevo=='SI') {
               window.open('./password.html', '_self');
            } else {
               window.open('./ventas.html', '_self');
            }
            limpiar();
         } else {
            alert(responseData.mensaje);
            document.getElementById("form-submit").disabled = false;
         }
      });
   }
}

const buscauser = () => {
   if (validaemail(document.getElementById("email").id, document.getElementById("email").value)) {
      document.getElementById("form-submit").disabled = true;
      let data = new FormData();

      data.append("email",    document.getElementById("email").value);

      fetch(USER, {
         method: 'POST',
         body: data
      })
      .then((response) => response.json())
      .then((responseData) => {
         if (responseData.exito==="SI") {
            window.open('./resetpassword.html?id='+responseData.registros[0].id, '_self');
         } else {
            alert(responseData.mensaje);
            document.getElementById("form-submit").disabled = false;
         }
      });
   }
}
