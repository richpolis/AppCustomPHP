<?php
session_start();
include ("../Acceso.php");
require_once('Browser.php');
$browser = new Browser();
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$query = "SELECT * FROM formatos ORDER BY descripcion ASC;";

$result = $miconexion->consulta($query);
	
if (mysql_num_rows($result)!=0) {

	//Generar codigo de las tablas
	$response = "<table id='report' width='100%' style='margin: 0 auto;'>\n";
	$response .= "	<tr>\n".
				"		<th style='width: 20px; padding: 0;'></th>\n".
				"		<th style='width: 20px; padding: 0;'></th>\n".
				"		<th>Descripcion</th>\n".
				"		<th>Archivo</th>\n".
				"		<th>Privado</th>\n".
				"	</tr>\n";
	$c = 0;
	while($row = mysql_fetch_array($result)) {
		if ($c % 2 == 0)
			$class="filapar";
		else
			$class="filaimpar";			
		$c++;
		$response .= "	<tr id='".$row["id_formato"]."'>\n";
		$response .= "		<td class='$class'>";
		if ($_SESSION['nivel'] == 0) {
			$response .= "<a href='#' onclick='return iniModificar(\"".htmlentities($row["id_formato"]).
						"\");' title='Modificar formato'><img src='images/form_edit.png' /></a>";
		}		
		$response .= "</td>";
		
		$response .= "<td class='$class'>";
		if ($_SESSION['nivel'] == 0) {
			$response .= "<a href='#' onclick='return eliminarFormato(\"".htmlentities($row["id_formato"]).
						"\")' title='Eliminar formato'><img src='images/sign_remove.png' /></a>";
		}					
		$response .= "		</td>\n".
					"		<td class='$class'>\n".
					"		".htmlentities($row["descripcion"])."\n".
					"		</td>\n".
					"		<td class='$class'>\n";
		if ($row["id_formato"] == NULL || $row["id_formato"] == ""){
			$response .= "No cargado";
		}
		else {
			$response .= "<a href='../formatos/".htmlentities($row["id_formato"])."' target='_blank'> ".htmlentities($row["id_formato"])." </a>";
		}
		$response .="		</td>\n";
		
		$response .= "		<td class='$class'>\n";
		if ($row["privado"] == 0)
			$response .= "		No\n";
		else
			$response .= "		S&iacute;\n";
		$response .= "		</td>\n";			
					
					"	</tr>\n";					
	}
				
				
	$response .= "</table>\n";
	
	echo $response;
}
else {
	echo "<h1 style='text-align: center;'>".
		" <br />No se encontr&oacute; ning&uacute;n formato.".
		"</h1>\n";
}
$miconexion->desconectar();
exit();

?>