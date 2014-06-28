<?php
session_start();
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$id = $_REQUEST['id'];
if (isset($_REQUEST['idf']))
	$idf = $_REQUEST['idf'];

if (isset($_REQUEST["class"]))
	$class = $_REQUEST['class'];


if (isset($_REQUEST["modificar"])){ /*** ENVIAMOS LOS DATOS PARA MODIFICAR VIA JSON  ********/
	$query = "SELECT * FROM archivos_faltas WHERE id_empleado = $id AND id_archivo_faltas = $idf";
	$result = $miconexion->consulta($query);
	$row = mysql_fetch_array($result);

	if ($row["archivo"] == NULL)
		$archivo = "";
	else
		$archivo = $row["archivo"];
	
	$query2 = "SELECT * FROM empleados WHERE id_empleado = $id";
	$result2 = $miconexion->consulta($query2);
	$row2 = mysql_fetch_array($result2);

	//return in JSON format
	
	$json = "{";
	$json .= "\"mes\": \"".$row["mes"]."\",\n";
	$json .= "\"ano\": \"".$row["ano"]."\",\n";
	$json .= "\"nombre\": \"".htmlentities($row2["nombre"]).
				" ".htmlentities($row2["apellido_paterno"])." ".htmlentities($row2["apellido_materno"])."\",\n";
	$json .= "\"archivo\": \"".$archivo."\"\n";
	$json .= "}";
		
	//echo $json;
	echo $json;
}
else{ /*** ES PARA MOSTRAR LOS DATOS DE LOS PRESTAMOS DEL EMPLEADO  ********/
	$query = "SELECT * FROM archivos_faltas WHERE id_empleado = $id ORDER BY ano DESC, mes DESC;";
	$result = $miconexion->consulta($query);
	
	$response = "<td class='$class' colspan='7'>\n";
	
	if (mysql_num_rows($result)!=0) {
		$c = true;
		while($row = mysql_fetch_array($result)) {
			if ($c == false){
				$response.= "	<div class='con_linea'><hr style='width: 98%; padding: 0; margin: 0;' /></div>\n";			
			}
			else 
				$c = false;
			//Mes
			switch ($row["mes"]) {
				case 1: $mesS = "Enero"; break;	
				case 2: $mesS = "Febrero"; break;
				case 3: $mesS = "Marzo"; break;
				case 4: $mesS = "Abril"; break;
				case 5: $mesS = "Mayo"; break;
				case 6: $mesS = "Junio"; break;
				case 7: $mesS = "Julio"; break;
				case 8: $mesS = "Agosto"; break;
				case 9: $mesS = "Septiembre"; break;
				case 10: $mesS = "Octubre"; break;
				case 11: $mesS = "Noviembre"; break;
				case 12: $mesS = "Diciembre"; break;
			}
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<div class='con_eti' style='width: 20%;'>";
			if ($_SESSION['nivel'] == 0) {
				$response.= "<div style='float: left;'><a style='float: left;' href='#' onclick='return iniModificarA("
						.$row["id_empleado"].", ".$row["id_archivo_faltas"].");' title='Modificar Archivo Mensual de Faltas'><img src='images/form_edit.png' /></a>".
						"<a style='padding-left: 10px; float: right;' href='#' onclick='return eliminarFaltaA(".$row["id_empleado"].", "
						.$row["id_archivo_faltas"].");' title='Eliminar Pr&eacute;stamo'><img src='images/sign_remove.png' /></a></div>";
			}
						
			$response.= "Mes: </div>".
						"<div class='con_valor' style='width: 8%; float: left;'>".$mesS."</div>\n";
			//Ano			
			$response.= "		<div class='con_eti' style='width: 15%;'>".
						"A&ntilde;o: </div>".
						"<div class='con_valor' style='width: 8%; float: left;'>".$row["ano"]."</div>\n";
		
			//Archivo			
			$response.= "		<div class='con_eti' style='width: 30%; float: right; display: inline;'>";
		
			if ($row["archivo"] != NULL && $row["archivo"] != ""){
				$response .= "<a href='./archivos/".$row["archivo"]."' target='_blank'> Ver archivo </a>";
			}
			else{
				$response .= "Archivo no cargado";
			}

			$response.= "		</div>\n";
			$response.= "	</div>\n";
		}
	}
	else{
		$response.= "	<h2>No hay ning&uacute;n archivo mensual de faltas para este(a) empleado(a).</h2>\n";
	}
	
	
	
	
	$response .= "</td>\n";
	
	echo $response;
}

$miconexion->desconectar();
exit();

?>