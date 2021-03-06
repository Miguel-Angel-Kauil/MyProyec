<?php require_once('Connections/Conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_ConsultaUsuario = 5;
$pageNum_ConsultaUsuario = 0;
if (isset($_GET['pageNum_ConsultaUsuario'])) {
  $pageNum_ConsultaUsuario = $_GET['pageNum_ConsultaUsuario'];
}
$startRow_ConsultaUsuario = $pageNum_ConsultaUsuario * $maxRows_ConsultaUsuario;

mysql_select_db($database_Conexion, $Conexion);
$query_ConsultaUsuario = "SELECT id, estado_id, nombre, apellidos, telefono, email FROM clientes ORDER BY id ASC";
$query_limit_ConsultaUsuario = sprintf("%s LIMIT %d, %d", $query_ConsultaUsuario, $startRow_ConsultaUsuario, $maxRows_ConsultaUsuario);
$ConsultaUsuario = mysql_query($query_limit_ConsultaUsuario, $Conexion) or die(mysql_error());
$row_ConsultaUsuario = mysql_fetch_assoc($ConsultaUsuario);

if (isset($_GET['totalRows_ConsultaUsuario'])) {
  $totalRows_ConsultaUsuario = $_GET['totalRows_ConsultaUsuario'];
} else {
  $all_ConsultaUsuario = mysql_query($query_ConsultaUsuario);
  $totalRows_ConsultaUsuario = mysql_num_rows($all_ConsultaUsuario);
}
$totalPages_ConsultaUsuario = ceil($totalRows_ConsultaUsuario/$maxRows_ConsultaUsuario)-1;

mysql_select_db($database_Conexion, $Conexion);
$query_Recordset1 = "SELECT * FROM clientes";
$Recordset1 = mysql_query($query_Recordset1, $Conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$queryString_ConsultaUsuario = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ConsultaUsuario") == false && 
        stristr($param, "totalRows_ConsultaUsuario") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ConsultaUsuario = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ConsultaUsuario = sprintf("&totalRows_ConsultaUsuario=%d%s", $totalRows_ConsultaUsuario, $queryString_ConsultaUsuario);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vista Usuario</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p><a href="Agregar_usuario.php">Agregar usuario</a></p>
<form id="form1" name="form1" method="get" action="Buscar.php">
  <span id="sprytextfield1">
  <label for="nombre">nombre</label>
  <input type="text" name="nombre" id="nombre" />
  <span class="textfieldRequiredMsg">Se necesita un valor.</span></span>
  <input type="submit" name="buscar" id="buscar" value="Buscar" />
</form>
<p>&nbsp;</p>
<table border="1">
  <tr>
    <td>id</td>
    <td>estado_id</td>
    <td>nombre</td>
    <td>apellidos</td>
    <td>telefono</td>
    <td>email</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_ConsultaUsuario['id']; ?></td>
      <td><?php echo $row_ConsultaUsuario['estado_id']; ?></td>
      <td><?php echo $row_ConsultaUsuario['nombre']; ?></td>
      <td><?php echo $row_ConsultaUsuario['apellidos']; ?></td>
      <td><?php echo $row_ConsultaUsuario['telefono']; ?></td>
      <td><?php echo $row_ConsultaUsuario['email']; ?></td>
      <td><a href="Editar_usuario.php?id_=<?php echo $row_ConsultaUsuario['id'];?>">Modificar</a></td>
      <td><a href="Eliminar_Usuario.php?ID=<?php echo $row_ConsultaUsuario['id'];?>">Eliminar</a></td>
    </tr>
    <?php } while ($row_ConsultaUsuario = mysql_fetch_assoc($ConsultaUsuario)); ?>
</table>
<table border="0">
  <tr>
    <td><?php if ($pageNum_ConsultaUsuario > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ConsultaUsuario=%d%s", $currentPage, 0, $queryString_ConsultaUsuario); ?>">Primero</a>
    <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_ConsultaUsuario > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ConsultaUsuario=%d%s", $currentPage, max(0, $pageNum_ConsultaUsuario - 1), $queryString_ConsultaUsuario); ?>">Anterior</a>
    <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_ConsultaUsuario < $totalPages_ConsultaUsuario) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ConsultaUsuario=%d%s", $currentPage, min($totalPages_ConsultaUsuario, $pageNum_ConsultaUsuario + 1), $queryString_ConsultaUsuario); ?>">Siguiente</a>
    <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_ConsultaUsuario < $totalPages_ConsultaUsuario) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ConsultaUsuario=%d%s", $currentPage, $totalPages_ConsultaUsuario, $queryString_ConsultaUsuario); ?>">&Uacute;ltimo</a>
    <?php } // Show if not last page ?></td>
  </tr>
</table>
</p>
<p>&nbsp; 
Registros <?php echo ($startRow_ConsultaUsuario + 1) ?> a <?php echo min($startRow_ConsultaUsuario + $maxRows_ConsultaUsuario, $totalRows_ConsultaUsuario) ?> de <?php echo $totalRows_ConsultaUsuario ?> </p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
  </script>
</body>
</html>
<?php
mysql_free_result($ConsultaUsuario);

mysql_free_result($Recordset1);
?>
