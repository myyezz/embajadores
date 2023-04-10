const URL = 'http://embajadores.myyezz.com/api/logindst.php';

const limpiar = () => {
   document.getElementById("email").value = "";
   document.getElementById("password").value = "";
}

const logindst = () => {
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
            localStorage.setItem('token'   ,      responseData.registros[0].token);
            localStorage.setItem('id'      ,      responseData.registros[0].token);
            window.open('./principal.html', '_self');
            limpiar();
         } else {
            document.getElementById("form-submit").disabled = false;
         }
      });
   }
}
