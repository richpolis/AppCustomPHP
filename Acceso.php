<?php
require ("Conexion.php");

$miconexion = new DB_mysql ;

if (!$miconexion->conectar("appinca", "localhost", "richpolis", "D3m3s1s1")){
    die ($miconexion->Error);}
?>



