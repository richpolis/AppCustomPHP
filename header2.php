        	</div>
            <div id="sesion">
           		<?php
					if (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "login.php"){	
					if(isset($_SESSION["uloged"]) && (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) != "cerrarsesion.php")){
			  	?>
        		<p class="cta-button2"><a href="cerrarsesion.php">Cerrar Sesi&oacute;n</a></p>
                <?php
			   		} else {
				?>
                <p class="cta-button"><a href="login.php">Iniciar Sesi&oacute;n</a></p>
                <?php
			   		} 
					}
				?>
        	</div>
		</div>
	</div>
    
    <div id="contentstretch">
		<div id="maincontent">