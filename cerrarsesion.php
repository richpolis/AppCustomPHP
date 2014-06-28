<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Sesi&oacute;n Cerrada</title>

<?php 

  
@ require_once ('header.php'); 
echo "<h1>Sesi&oacute;n Cerrada</h1>";
@ require_once ('header2.php');
session_unset();
session_destroy();
?>

<article class="clearfix">
<div id="texto">
<p>
<?php
  echo "<h1 style='text-align: center;'><br />Su sesión ha sido finalizada correctamente.</h1>";
?>
</p>


</div>
</article>
  
<?php 

$includeFile = file_get_contents("./footer.php");
echo $includeFile;

?>     