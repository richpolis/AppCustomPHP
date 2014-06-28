<?php
include ("../Acceso.php");
require_once('Browser.php');
$browser = new Browser();
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

if( $browser->getBrowser() == Browser::BROWSER_IE) {	
	$id = $_REQUEST['id'];
}
else {
	$id = utf8_decode($_REQUEST['id']);
}


$query = "SELECT * FROM formatos WHERE id_formato = '$id';";

$result = $miconexion->consulta($query);

$row = mysql_fetch_array($result);

/*** ENVIAMOS LOS DATOS PARA MODIFICAR VIA JSON  ********/

if ($row["id_formato"] == NULL)
  $archivo = "";
else
  $archivo = $row["id_formato"];

//return in JSON format
$json = "{";
$json .= "\"descripcion\": \"".utf8_encode($row["descripcion"])."\",\n";
$json .= "\"privado\": \"".$row["privado"]."\",\n";
$json .= "\"archivo\": \"".utf8_encode($archivo)."\"\n";
$json .= "}";


echo $json;

$miconexion->desconectar();
exit();

?>