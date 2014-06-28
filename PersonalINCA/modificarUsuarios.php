<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}
$nivel = $_REQUEST['nivel'];
$nombre = utf8_decode(trim($_REQUEST['nombre']));
$id = utf8_decode(trim($_REQUEST['id']));
$newpassword = utf8_decode(trim($_REQUEST['newpassword']));
$cnewpassword = utf8_decode(trim($_REQUEST['cnewpassword']));

if ($nivel == "0") {
	$password = md5(sha1(utf8_decode(trim($_REQUEST['password']))));
	$result = $miconexion->consulta("SELECT * FROM monitos WHERE nivel = 0;");
	$row = mysql_fetch_array($result);
	if ($row["password"] != $password) {
		echo "¡La contrase&ntilde;a es incorrecta!";
		$miconexion->desconectar();
		exit();
	}
}

if ($newpassword != $cnewpassword) {
	echo "Las contrase&ntilde;as no coinciden.";
	$miconexion->desconectar();
	exit();
}

$result = $miconexion->consulta("SELECT * FROM monitos WHERE id_monito = '$id' AND nivel <> $nivel;");
if (mysql_num_rows($result)!=0) {
	echo "Ya existe un usuario con esa ID.";
	$miconexion->desconectar();
	exit();
}

$newpassword = md5(sha1($newpassword));

$query = "UPDATE monitos SET ".
		"id_monito = '$id', nombre = '$nombre', password = '$newpassword' ".
		"WHERE nivel = $nivel;";
		
$result = $miconexion->consulta($query);
	
if($result) {
	echo "success";	
}
else {
	echo "No se pudo modificar el usuario.";
}
$miconexion->desconectar();
exit();

?>