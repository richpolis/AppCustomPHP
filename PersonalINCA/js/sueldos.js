$(document).ready(function(){
	
	//Inicializacion para los botones de insertar, cancelar y modificar
	$('#datos').hide();
	
	$('#change-form')
	   .validate({
         submitHandler: function(form) {			 
			 modinsertar($('input[name=id_empleado]').val(), $('input[name=id_mod]').val());			           				
         }
        }); 
	
	//Mensajes en espaniol para la validacion de la forma
	jQuery.extend( jQuery.validator.messages, {
	  required: "Este campo es obligatorio.",
	  remote: "Por favor, rellena este campo.",
	  email: "Por favor, escribe una dirección de correo válida",
	  url: "Por favor, escribe una URL válida.",
	  date: "Por favor, escribe una fecha válida.",
	  dateISO: "Por favor, escribe una fecha (ISO) válida.",
	  number: "Por favor, escribe un número entero válido.",
	  digits: "Por favor, escribe sólo dígitos.",
	  creditcard: "Por favor, escribe un número de tarjeta válido.",
	  equalTo: "Por favor, escribe el mismo valor de nuevo.",
	  accept: "Por favor, escribe un valor con una extensión aceptada.",
	  maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
	  minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
	  rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
	  range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
	  max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
	  min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")	  
	});
	
	//Inicializacion del DatePicker
	$.datepicker.setDefaults( $.datepicker.regional[""] );
	$("#fecha_modificacion").datepicker( $.datepicker.regional["es"] );
	$("#fecha_modificacion").datepicker( "option", "changeMonth", true);
	$("#fecha_modificacion").datepicker( "option", "changeYear", true);
	 
	$('#cancelar').click(function() { 	
		$('#datos').hide();
		$('#buscar').show();	
		return false;	  
	});
	 
	 //Funciones para la tabla de resultados
	$("#report tr:odd").addClass("odd");
	$("#report tr:not(.odd)").hide();
	$("#report tr:first-child").show();
	
	$("#report tr.odd").click(function(){
		$(this).next("tr").toggle();
		$(this).find(".arrow").toggleClass("up");
	});
	//$("#report").jExpand();	
	
	//para enviar la busqueda	
	//if submit button is clicked
    $('#doBuscar').click(function () {    
         
        //Get the data from all the fields
		var page = $('input[name=page]');
        var nombre = $('input[name=nombre]');
        var gerencia = $('select[name=gerencia]');
        var ubicacion = $('select[name=ubicacion]');
        var obra = $('select[name=obra]');
		var empresa = $('select[name=empresa]');
		var tipo = $('select[name=tipo]');	
		var finiquitado = $('select[name=finiquitado]');		
		$('input[name=nombre2]').val(nombre.val());		
        $('input[name=gerencia2]').val(gerencia.val());		
        $('input[name=ubicacion2]').val(ubicacion.val());
        $('input[name=obra2]').val(obra.val());
		$('input[name=empresa2]').val(empresa.val());
		$('input[name=tipo2]').val(tipo.val());
		$('input[name=finiquitado2]').val(finiquitado.val());

		page.val("");
		
        //organize the data properly
        var data = 'nombre=' + nombre.val() + '&gerencia=' + gerencia.val() + '&ubicacion='
        + ubicacion.val() + '&obra=' + obra.val() + '&empresa=' + empresa.val() + '&tipo='  + tipo.val()
		+ '&finiquitado=' + finiquitado.val();
         
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "buscarSueldos.php",      
            //GET method is used
            type: "GET",
            //pass the data        
            data: data,                
            //Do not cache the page
            cache: false,            
            //success
            success: function (html) {             
                $('#right').html(html); 
				//Funciones para la tabla de resultados 
				$("#report tr:odd").addClass("odd");
				$("#report tr:not(.odd)").hide();
				$("#report tr:first-child").show();  
				/*$("#report div.arrow").click(function(){
					$(this).next("tr").toggle();
					$(this).find(".arrow").toggleClass("up");
				});  */
				$("#report div.arrow").click(function(){
					$(this).parent().parent().find(".arrow").toggleClass("up");
					if ($(this).parent().parent().next("tr").is(":visible")){
						$('#info_' + $(this).parent().parent().attr('id')).html("");
						$(this).parent().parent().next("tr").slideUp();												
					}
					else{
						getInfoEmpleado($(this).parent().parent().attr('id'), $(this).parent().attr('class'));
						$(this).parent().parent().next("tr").slideDown();						
					}
					//$(this).parent().parent().next("tr").toggle();				
				});      
            }      
        });
		
		//cancel the submit button default behaviours
        return false;
	}); 
	
	//Hacer búsqueda de inicio
	$("#doBuscar").trigger("click");
	 
});

function modificarSueldo(id) {
		$('input[name=fecha_modificacion]').val("");
		$('input[name=nuevo_sueldo]').val("");
		$('#nuevo_porc_div').show();
		$('input[name=nuevo_porcentaje]').val("");
		$('input[name=accion]').val("insertar");
		$('input[name=tipo]').val("normal");
		$('input[name=id_empleado]').val(id);
			
		$('#label_im').html("Modificar Sueldo");
		$('#buscar').hide();
		$('#datos').show();	
		return false;	  
}
	
function modificarSueldoAumento(id) {
	$('input[name=fecha_modificacion]').val("");
	$('input[name=nuevo_sueldo]').val("");
	$('#nuevo_porc_div').hide();
	$('input[name=nuevo_porcentaje]').val("");
	$('input[name=accion]').val("insertar");
	$('input[name=tipo]').val("aumento");
	$('input[name=id_empleado]').val(id);
		
	$('#label_im').html("Modificar Sueldo Aumento");
	$('#buscar').hide();
	$('#datos').show();	
	return false;
}

//para cambiar de pagina
function Buscar(pageno) {        
         
	//Get the data from all the fields
	var page = pageno;
	var nombre = $('input[name=nombre2]');
	var gerencia = $('input[name=gerencia2]');
	var ubicacion = $('input[name=ubicacion2]');
	var obra = $('input[name=obra2]');
	var empresa = $('input[name=empresa2]');
	var tipo = $('input[name=tipo2]');
	var finiquitado = $('input[name=finiquitado2]');

	//organize the data properly
	var data = 'nombre=' + nombre.val() + '&gerencia=' + gerencia.val() + '&ubicacion='
	+ ubicacion.val() + '&obra=' + obra.val() + '&empresa=' + empresa.val() + '&tipo='  + tipo.val()
	+ '&finiquitado='  + finiquitado.val()+ '&page='  + page;
	 
	//start the ajax
	$.ajax({
		//this is the php file that processes the data and send mail
		url: "buscarSueldos.php",      
		//GET method is used
		type: "GET",
		//pass the data        
		data: data,                
		//Do not cache the page
		cache: false,            
		//success
		success: function (html) {   				        
			$('#right').html(html);
			//Funciones para la tabla de resultados 
			$("#report tr:odd").addClass("odd");
			$("#report tr:not(.odd)").hide();
			$("#report tr:first-child").show(); 	
			$("#report div.arrow").click(function(){
				$(this).parent().parent().find(".arrow").toggleClass("up");
				if ($(this).parent().parent().next("tr").is(":visible")){
					$('#info_' + $(this).parent().parent().attr('id')).html("");
					$(this).parent().parent().next("tr").slideUp();												
				}
				else{
					getInfoEmpleado($(this).parent().parent().attr('id'), $(this).parent().attr('class'));
					$(this).parent().parent().next("tr").slideDown();						
				}
				//$(this).parent().parent().next("tr").toggle();
			});         
		}      
	});
	 
	//cancel the submit button default behaviours
	return false;
}

function getInfoEmpleado(id, clase) {

	var data = 'id=' + id + '&class=' + clase;
	//jQuery('#datos').showLoading();

	$.ajax({
		url: 'consultarSueldos.php',      
		type: "GET",      
		data: data,                
		cache: false,            
		success: function (html) { 
			//jQuery('#datos').hideLoading();  
			$('#info_' + id).html(html);		
		}      
	});
}

//Se llama al hacer click en el boton de modificar un sueldo
function iniModificar(id, idmod, tipo) {
	var data = 'id=' + id + '&modificar=true' + '&idmod=' + idmod + '&tipo=' + tipo;

	$.ajax({
		url: 'consultarSueldos.php',      
		type: "GET",       
		data: data,  
		dataType: 'json',             
		//cache: false,            
		//success
		success: function (html) { 
			//jQuery('#datos').hideLoading(); 
			
			$('input[name=fecha_modificacion]').val(html.fecha);			
			$('input[name=nuevo_sueldo]').val(html.nuevo_sueldo);
			$('input[name=nuevo_porcentaje]').val(html.nuevo_porcentaje);					
			$('input[name=accion]').val("modificar");
			$('input[name=id_empleado]').val(id);
			$('input[name=id_mod]').val(idmod);
			$('input[name=tipo]').val(tipo);
			
			if (tipo == "normal"){
				$('#label_im').html("Editar Modificaci&oacute;n de Sueldo");
				$('#nuevo_porc_div').show();			
			}else{				
				$('#label_im').html("Editar Modificaci&oacute;n de Sueldo por Aumento");
				$('#nuevo_porc_div').hide();
			}
			$('#buscar').hide();
			$('#datos').show();	
		},  
		error: function (data, status, e)
		{
				apprise(e);
		}    
	});
		
	return false;
}

//Se llama al hacer click en el boton de eliminar de un empleado
function eliminarModificacion(id, idm, tipo) {
	var data = 'id=' + id + '&idm=' + idm + '&tipo=' + tipo;
	 
	apprise('Se eliminar&aacute; la &uacute;ltima modificaci&oacute;n realizada <br />' 
			+ 'y se reestablecer&aacute;n los valores anteriores de sueldo y/o porcentaje IMSS. <br /><br />'
			+ '¿Seguro que desea eliminar el registro?', 
		{'verify':true, 'textYes':'Si, elim&iacute;nalo!', 'textNo':'No, quiero conservar el registro'}, 
		function(r){
    		if(r){
				jQuery('#buscar').showLoading();
				$.ajax({
					url: 'eliminarSueldos.php',      
					type: "GET",       
					data: data,            
					cache: false,            
					//success
					success: function (html) { 
						jQuery('#buscar').hideLoading(); 
						$("#doBuscar").trigger("click");
						getEmpleadosSelect();
						apprise("Se ha eliminado el registro con &eacute;xito.");	
					},  
					error: function (data, status, e)
					{
						jQuery('#buscar').hideLoading(); 
						apprise(e);
					}    
				});
			}
			else {
				return false;
			}
		});
		
	return false;
}

//inserta un registro de una modificacion de sueldos
function modinsertar(id, idm) {
	var idr = id;
	var idmod = idm;
	var eliminar_archivo;
	var fecha_modificacion = $('input[name=fecha_modificacion]').val();
	var nuevo_sueldo = $('input[name=nuevo_sueldo]').val();
	var nuevo_porcentaje = $('input[name=nuevo_porcentaje]').val();	
	var accion = $('input[name=accion]').val();
	var tipo = $('input[name=tipo]').val();

	var action = "insertarModificarSueldos.php";

	var data = 'id=' + idr + '&idmod=' + idmod + '&fecha_modificacion=' + fecha_modificacion 
	+ '&nuevo_sueldo=' + nuevo_sueldo
	+ '&nuevo_porcentaje=' + nuevo_porcentaje
	+ '&accion=' + accion + '&tipo=' + tipo;

	$.ajax({
		url: action,      
		type: "GET",      
		data: data,                
		cache: false,            
		success: function (html) { 
			jQuery('#datos').hideLoading();           
			if (html.trim() == "success") {			
				$('#datos').hide();
				$('#buscar').show();
				$("#doBuscar").trigger("click");
				if (accion == "insertar") {
					apprise("Se ha insertado el registro correctamente.");	
				} else {
					apprise("Se ha modificado el registro correctamente.");	
				}							
			}
			else {
				apprise(html);
			}
		}      
	});	
}

