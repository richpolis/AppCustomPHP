<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$id = $_REQUEST['id'];

if (isset($_REQUEST["class"]))
	$class = $_REQUEST['class'];

$query = "SELECT * FROM empleados WHERE id_empleado = $id";

$result = $miconexion->consulta($query);

$row = mysql_fetch_array($result);

if (isset($_REQUEST["modificar"])){ /*** ENVIAMOS LOS DATOS PARA MODIFICAR VIA JSON  ********/
	
	if ($row["archivo_alta_foraneidad"] == NULL)
		$archivo_alta_foraneidad = "";
	else
		$archivo_alta_foraneidad = $row["archivo_alta_foraneidad"];
		
	if ($row["archivo_baja_foraneidad"] == NULL)
		$archivo_baja_foraneidad = "";
	else
		$archivo_baja_foraneidad = $row["archivo_baja_foraneidad"];
	
	$json = "{";
	$json .= "\"monto\": \"".$row["foraneidad_monto"]."\",\n";
	$json .= "\"estado\": \"".$row["estado_foraneidad"]."\",\n";
	$json .= "\"transporte\": \"".$row["apoyo_mensual_transporte"]."\",\n";
	$json .= "\"nombre\": \"".htmlentities($row["nombre"]).
				" ".htmlentities($row["apellido_paterno"])." ".htmlentities($row["apellido_materno"])."\",\n";
	$json .= "\"archivo_alta\": \"".$archivo_alta_foraneidad."\",\n";
	$json .= "\"archivo_baja\": \"".$archivo_baja_foraneidad."\"\n";
	$json .= "}";
		
	//echo $json;
	echo $json;
} 
else{ /*** ES PARA MOSTRAR LOS DATOS DEL EMPLEADO SOLAMENTE  ********/
	$response = "<td class='$class' colspan='6'>\n";
	$response.= "<div class='con_col'>\n";
	//Monto foraneidad
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti' style='width: 70%'> Monto foraneidad: </div><div class='con_valor' style='width: 25%'>$".
				$row["foraneidad_monto"]."</div>\n";
	$response.= "	</div>\n";
	//Apoyo mensual transporte
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti' style='width: 70%'> Apoyo Mensual Transporte: </div><div class='con_valor' style='width: 25%'>$".
				$row["apoyo_mensual_transporte"]."</div>\n";
	$response.= "	</div>\n";
	
	$response.= "</div>\n";
	$response.= "<div class='con_col'>\n";
	  	
	//Ultimo recibo
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti'> Archivo Alta: </div><div class='con_valor'>";
	if ($row["archivo_alta_foraneidad"] == NULL || $row["archivo_alta_foraneidad"] == ""){
		$response .= "No cargado";
	}
	else {
		$response .= "<a href='./archivos/".$row["archivo_alta_foraneidad"]."' target='_blank'> Ver archivo </a>";
	}
	$response.= "		</div>\n";
	$response.= "	</div>\n";
	//Penultimo recibo
	$response.= "	<div class='con_linea'>\n";	
	$response.= "		<div class='con_eti'> Archivo Baja: </div><div class='con_valor'>";
	if ($row["archivo_baja_foraneidad"] == NULL || $row["archivo_baja_foraneidad"] == ""){
		$response .= "No cargado";
	}
	else {
		$response .= "<a href='./archivos/".$row["archivo_baja_foraneidad"]."' target='_blank'> Ver archivo </a>";
	}
	$response.= "		</div>\n";
	$response.= "	</div>\n";	
	
	$response.= "</div>";	
	
	$response .= "</td>\n";
	
	echo $response;
}

$miconexion->desconectar();
exit();

?>