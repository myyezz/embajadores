const CONSULTAIMEI = 'https://myyezz.github.io/embajadores/api/consultaimei.php';


const limpiar = () => {
   document.getElementById("imei").value = "";
}

const consultaimei = () => {
   if (document.getElementById("imei").value!="") {
      document.getElementById("form-submit").disabled = true;
      let data = new FormData();
   
      data.append("imei", document.getElementById("imei").value);
   
      fetch(CONSULTAIMEI, {
         method: 'POST',
         body: data
      })
      .then((response) => response.json())
      .then((responseData) => {
         if (responseData.exito==="SI") {
            document.getElementById("modelo").value = responseData.registros[0].nombremodelo;
            document.getElementById("comision").value = formatNumber.new(responseData.registros[0].comision);
            document.getElementById("vendido").value = responseData.registros[0].vendido;
            document.getElementById("nombretienda").value = responseData.registros[0].nombretienda;
            document.getElementById("nombregrupo").value = responseData.registros[0].nombregrupo;
            document.getElementById("nombredistribuidor").value = responseData.registros[0].nombredistribuidor;
         } else {
            alert(responseData.mensaje);
         }
         document.getElementById("form-submit").disabled = false;
      });
   } else {
      alert("El campo IMEI no puede estar vacío");
      document.getElementById("form-submit").disabled = false;
      document.getElementById("imei").focus();
   }
}
