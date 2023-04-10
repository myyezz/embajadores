const URL = 'https://embajadores.cash-flag.com/api/resetpassword.php';

const limpiar = () => {
   document.getElementById("password").value = "";
   document.getElementById("password2").value = "";
}

const inicio = () => {
   localStorage.clear();
   params = fparamurl(window.location.search.substr(1));
   if (params.id!=undefined) {
      document.getElementById("idembajador").value = params.id;
   }
}

const registro = () => {
   if (document.getElementById("password").value != "" &&
   document.getElementById("password2").value != "" &&
   document.getElementById("idembajador").value != "") {
      pwd1 = document.getElementById("password").value.trim();
      pwd2 = document.getElementById("password2").value.trim();
      if (pwd1.length>0 && pwd2.length>0) {
         if (!comparaigual(pwd1, pwd2)) {
            alert("Password no coincide");
            document.getElementById("password").focus()
         } else {
            document.getElementById("form-submit").disabled = true;
            let data = new FormData();

            data.append("password"    , document.getElementById("password").value);
            data.append("idembajador" , document.getElementById("idembajador").value);

            fetch(URL, {
               method: 'POST',
               body: data
            })
            .then((response) => response.json())
            .then((responseData) => {
               if (responseData.exito==="SI") {
                  // alert('Cambio de password efectivo.')
                  // limpiar();
                  window.open('./index.html', '_self');
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
