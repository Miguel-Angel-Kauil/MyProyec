

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>

<script language=javascript>
function validar (){
	alert("estoy llamando a la funcion");
	var nombretext = document.getElementById("nombre").value;
	if (nombretext.value==""){
		alert("el campo nombre esta vacio");
	}
	else{
		var contrasenatext = document.getElementById("contrasena").value;
		if (contrasenatxt.value == ""){
			alert("el campo contrasena no puede estar vacio");
			}
			else {
				document.getElementById("boton").value
				}
		}
}
</script>

</head>

<body>
<p>&nbsp;</p>
<form id="form1" name="form1" method="get" action="2.php">
  <p>
    <label for="nombre">nombre</label>
    <input type="text" name="nombre2" id="nombre" />
  </p>
  <p>
    <label for="contrasena">contrasena</label>
    <input type="text" name="contrasena2" id="contrasena" />
  </p>
  <p>login
    <input type="button" name="login2" id="login2" value="Enviar" onclick="validar(this.value)"/>
    <input type="hidden" name="boton" id="boton" />
  </p>
</form>
</body>
</html>