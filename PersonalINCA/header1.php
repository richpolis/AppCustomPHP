</head>
<body>
	<div id="headerstretch">
		<div id="navstretch">
			<header class="clearfix">
				<a href="../index.php"><img src="../images/logoBDP.png" id="logo" alt="Foundation Six" width="497" height="143" style="padding-top: 50px;"></a>
              <div style="display: inline; float:right">
              
              <nav id="nav1">
              <?php		  
			  if(isset($_SESSION["uloged"]) && (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "cerrarsesion.php")){				
			  ?>
                  <ul>
                      <li id="empleados"><a href="./empleados.php">Empleados</a></li>
                      <li id="obras"><a href="./obras.php">Obras</a></li>
                      <li id="sueldos"><a href="./sueldos.php">Modificaciones de Sueldos</a></li>
                      <li id="recibos"><a href="./recibos.php">Recibos de Honorarios</a></li>
                      <li id="asistencias"><a href="./asistencias.php">Control de Asistencias</a></li>                   	  
                      <li id="viaticos"><a href="./viaticos.php">Viáticos INCA</a></li>
                  </ul>
              <?php
			  	}
			  ?>
              </nav>
              <nav id="nav2">
              <?php			  
			  if(isset($_SESSION["uloged"]) && (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "cerrarsesion.php")){				
			  ?>
                  <ul>
                      <li id="prestamos"><a href="./prestamos.php">Préstamos INCA</a></li>
                      <li id="foraneidades"><a href="./foraneidades.php">Foraneidad/Compensación</a></li>
                      <li id="inmuebles"><a href="./inmuebles.php">Inmuebles INCA</a></li>
                      <li id="localidades"><a href="./localidades.php">Localidades de Inmuebles</a></li>
                      <li id="formatos"><a href="./formatos.php">Formatos Personal</a></li>
                      <?php		  
						  if ($_SESSION['nivel'] == 0) {			
					  ?>
                      <li id="usuarios"><a href="./usuarios.php">Usuarios</a></li>
                      <?php
						  }
					  ?>
                  </ul>
              <?php
			  	} else {
				echo "<ul>\n";
				for ($i = 0; $i < 6; $i++) {
					echo "<li>&nbsp;</li>\n";
				}
				echo "</ul>\n";
				}
			  ?>
              </nav>              
              </div>
              <div id="usuario">
              <?php		  
			  if(isset($_SESSION["uloged"]) && (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "cerrarsesion.php")){
			  	echo "Registrado como <b>".$_SESSION["nombre"]."</b>";
				
			  ?>
                <img  style="vertical-align: middle;" src="../images/man.png" width="23" height="45" align="absmiddle"> 
              <?php
			  	}
			  ?>
        	  </div>
			</header>
		</div>
        
        
		<div id="subbanner">
        	<div id="titulo">