<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$id = $_REQUEST['id'];

if (isset($_REQUEST['class']))
	$class = $_REQUEST['class'];


$query = "SELECT * FROM empleados WHERE id_empleado = $id;";

$result = $miconexion->consulta($query);

$row = mysql_fetch_array($result);

if (isset($_REQUEST["modificar"])){ /*** ENVIAMOS LOS DATOS PARA MODIFICAR VIA JSON  ********/
	
	if ($row["ultimo_recibo"] == NULL)
		$ultimo_recibo = "";
	else
		$ultimo_recibo = $row["ultimo_recibo"];
		
	if ($row["penultimo_recibo"] == NULL)
		$penultimo_recibo = "";
	else
		$penultimo_recibo = $row["penultimo_recibo"];

	
	$json = "{";
	$json .= "\"faltantes\": \"".$row["recibos_faltantes"]."\",\n";
	$json .= "\"ultimo_recibo\": \"".$ultimo_recibo."\",\n";
	$json .= "\"penultimo_recibo\": \"".$penultimo_recibo."\"\n";
	$json .= "}";
		
	//echo $json;
	echo $json;
} 
else{ /*** ES PARA MOSTRAR LOS DATOS DEL EMPLEADO SOLAMENTE  ********/

	$response = "<td class='$class' colspan='6'>\n";
	$response.= "<div class='con_col'>\n";  
	//Recibos faltantes
	$response.= "	<div class='con_linea'>\n";	
	$response.= "		<div class='con_eti'> Recibos faltantes: </div><div class='con_valor'>".
				$row["recibos_faltantes"]."</div>\n"; 
	$response.= "	</div>\n";
	
	
	$response.= "</div>\n";
	$response.= "<div class='con_col'>\n";
	  
	
	//Ultimo recibo
	$response.= "	<div class='con_linea'>\n";	
	$response.= "		<div class='con_eti'> &Uacute;ltimo recibo: </div><div class='con_valor'>";
	if ($row["ultimo_recibo"] == NULL || $row["ultimo_recibo"] == ""){
		$response .= "No cargado";
	}
	else {
		$response .= "<a href='./archivos/".$row["ultimo_recibo"]."' target='_blank'> Ver archivo </a>";
	}
	$response.= "		</div>\n";
	$response.= "	</div>\n";
	//Penultimo recibo
	$response.= "	<div class='con_linea'>\n";	
	$response.= "		<div class='con_eti'> Pen&uacute;ltimo recibo: </div><div class='con_valor'>";
	if ($row["penultimo_recibo"] == NULL || $row["penultimo_recibo"] == ""){
		$response .= "No cargado";
	}
	else {
		$response .= "<a href='./archivos/".$row["penultimo_recibo"]."' target='_blank'> Ver archivo </a>";
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