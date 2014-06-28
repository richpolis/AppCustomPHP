<?php
include ("../Acceso.php");
require_once('Browser.php');
$browser = new Browser();
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

if( $browser->getBrowser() == Browser::BROWSER_IE) {	
	$idformato = $_REQUEST['id'];
}
else {
	$idformato = utf8_decode($_REQUEST['id']);
}

$result = $miconexion->consulta("DELETE FROM formatos WHERE id_formato = '$idformato';");

if(!$result) {
	echo "No se pudo eliminar el registro de la base de datos.";
} else {

	if ($idformato!=NULL && $idformato!= 'NULL' && $idformato!= "") {
		unlink("../formatos/".$idformato);
	}

	echo "success";
}
	
$miconexion->desconectar();
exit();

?>