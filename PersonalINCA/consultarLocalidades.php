<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$id = $_REQUEST['id'];

$query = "SELECT * FROM localidades_inmuebles WHERE id_localidad = $id";

$result = $miconexion->consulta($query);

$row = mysql_fetch_array($result);

/*** ENVIAMOS LOS DATOS PARA MODIFICAR VIA JSON  ********/
//return in JSON format
$json = "{";
$json .= "\"nombre\": \"".utf8_encode($row["nombre"])."\"\n";
$json .= "}";
  
//echo $json;
echo $json;


$miconexion->desconectar();
exit();

?>