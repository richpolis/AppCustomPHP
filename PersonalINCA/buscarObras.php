<?php
session_start();
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$query = "SELECT * FROM obras ORDER BY nombre ASC;";

$result = $miconexion->consulta($query);
	
if (mysql_num_rows($result)!=0) {

	//Generar codigo de las tablas
	$response = "<table id='report' width='80%' style='margin: 0 auto;'>\n";
	$response .= "	<tr>\n".
				"		<th style='width: 20px; padding: 0;'></th>\n".
				"		<th style='width: 20px; padding: 0;'></th>\n".
				"		<th>Nombre</th>\n".
				"		<th>Organigrama</th>\n".
				"	</tr>\n";
	$c = 0;
	while($row = mysql_fetch_array($result)) {
		if ($c % 2 == 0)
			$class="filapar";
		else
			$class="filaimpar";			
		$c++;
		$response .= "	<tr id='".$row["id_obra"]."'>\n";
		$response .= "		<td class='$class'>";
		if ($_SESSION['nivel'] == 0) {
			$response .= "<a href='#' onclick='return iniModificar(".$row["id_obra"].
						");' title='Modificar registro de obra'><img src='images/form_edit.png' /></a>";
		}		
		$response .= "</td>";
		
		$response .= "<td class='$class'>";
		if ($_SESSION['nivel'] == 0) {
			$response .= "<a href='#' onclick='return eliminarObra(".$row["id_obra"].
						")' title='Eliminar registro de obra'><img src='images/sign_remove.png' /></a>";
		}					
		$response .= "		</td>\n".
					"		<td class='$class'>\n".
					"		".htmlentities($row["nombre"])."\n".
					"		</td>\n".
					"		<td class='$class'>\n";
		if ($row["organigrama"] == NULL || $row["organigrama"] == ""){
			$response .= "No cargado";
		}
		else {
			$response .= "<a href='./archivos/".$row["organigrama"]."' target='_blank'> Ver archivo </a>";
		}
		$response .="		</td>\n";
					"	</tr>\n";					
	}
				
				
	$response .= "</table>\n";
	
	echo $response;
}
else {
	echo "<h1 style='text-align: center;'>".
		" <br />No se encontr&oacute; ning&uacute;n registro de obras.".
		"</h1>\n";
}
$miconexion->desconectar();
exit();

?>