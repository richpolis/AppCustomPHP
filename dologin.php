<?php
if(session_id () =='') {session_start();}
include ("Acceso.php");

$is_ajax = $_REQUEST['is_ajax'];
if(isset($is_ajax) && $is_ajax) {

	$username = $_REQUEST['username'];
	$password = md5(sha1($_REQUEST['password']));
	
	$result = $miconexion->consulta("SELECT * FROM monitos".
	" WHERE id_monito = '$username' and password = '$password';");
	
	if (mysql_num_rows($result)!=0) {

		$row = mysql_fetch_array($result);
		//session_regenerate_id(); 
		$_SESSION['idusuario'] = $username;
		$_SESSION['nombre'] = htmlentities($row['nombre']);
		$_SESSION['nivel'] = $row['nivel'];
		$_SESSION['uloged'] = true;

		echo "success";
		session_write_close();		
	}
	else {
		echo "failed";
	}
	$miconexion->desconectar();
}
?>