// Función para mostrar los decimales que se quieran
var formatNumber = {
	separador: ".", // separador para los miles
	sepDecimal: ',', // separador para los decimales
	formatear: function (num) {
		num += '';
		var splitStr = num.split('.');
		var splitLeft = splitStr[0];
		var xright = splitStr[1] < 10 ? splitStr[1] * 10 : splitStr[1];
		var splitRight = splitStr.length > 1 ? this.sepDecimal + xright : this.sepDecimal + '00';
		var regx = /(\d+)(\d{3})/;
		while (regx.test(splitLeft)) {
			splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
		}
		return this.simbol + splitLeft + splitRight;
	},
	new: function (num, simbol) {
		this.simbol = simbol || '';
		return this.formatear(num);
	}
}

		// var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : this.sepDecimal + '00';


function fexisteUrl(url) {
	var http = new XMLHttpRequest();
	http.open('HEAD', url, false);
	http.send();
	return http.status != 404;
}

function fmensaje(texto) {
	var mensaje = '';
	for (let index = 0; index < texto.length; index++) {
		mensaje += texto[index];
		if (texto.length > 1 && index + 1 < texto.length) {
			mensaje += '\n';
		}
	}
	return mensaje;
}

function fparamurl(xurl) {
	var paramstr = xurl;
	var paramarr = paramstr.split ("&");
	var params = {};

	for ( var i = 0; i < paramarr.length; i++) {
	   var tmparr = paramarr[i].split("=");
	   params[tmparr[0]] = decodeURI(tmparr[1]);
	}
	return params;
}

function fbaseURL (ruta) {
	// let ruta1 = ruta.pathname.split('/'), ruta2 = ruta.protocol + '//';
	let ruta1 = ruta.pathname.split('/'), ruta2 = ruta.origin + '/';
	for (let i = 1; i < ruta1.length - 1; i++) { ruta2 += ruta1[i] + '/'; }
	return ruta2;
}

const validaemail = (elemento,correo) => {
   if (correo!="") {
      arroba = 0;
      punto = 0;
      posa = 0;
      posp = 0;
      for (index = 0; index < correo.length; index++) {
         if (correo[index] == "@") { arroba++; posa = index; }
         if (correo[index] == ".") { punto++; posp = index; }
      }
      if (arroba + punto > 1 && posp > posa) {
         return true;
      } else {
         alert('Email invalido, debe introducir un formato de email válido (incluir el @ y al menos un . )'); 
         document.getElementById(elemento).focus();
         return false;
      }
   }
}

function validatelefono(elemento,valor) {
	lista = "0123456789";
	let novalido = 0;
	for (let i = 0; i < valor.length; i++) {
		posicion = lista.indexOf(valor.substr(i,1));
		if (posicion<0) {
			novalido++;
		}
	}
	if (novalido>0) {
		alert("En este campo sólo se permiten números");
		document.getElementById(elemento).value = valor.substr(0,valor.length-1);

		document.getElementById(elemento).focus();
		return false;
	} else {
		return true;
	}
}

const comparaigual = (valor1,valor2) => {
	return (valor1 === valor2) ? true : false ;
} 