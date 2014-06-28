$(document).ready(function(){
	
	//Inicializacion para los botones de insertar, cancelar y modificar
	$('#datos').hide();
	$('#finiquito').hide();
	
	$('#change-form')
	   .validate({
         submitHandler: function(form) {			 
			 if ($('input[name=accion]').val() == "modificar"){
				 ajaxFileUpload("empleado", "modificar", "archivo_alta", $('input[name=id_empleado]').val()); 
			 }
			 else if ($('input[name=accion]').val() == "insertar"){
				 ajaxFileUpload("empleado", "subir", "archivo_alta", ""); 
			 }
			           				
         }
        }); 
		
	$('#formfiniquito')
	   .validate({
         submitHandler: function(form) {			 
			 if ($('input[name=accion_finiquito]').val() == "modificar"){
				 ajaxFileUpload("finiquito", "modificar", "archivo_finiquito", $('input[name=id_empleado_finiquito]').val()); 
			 }
			 else if ($('input[name=accion_finiquito]').val() == "insertar"){
				 ajaxFileUpload("finiquito", "subir", "archivo_finiquito", $('input[name=id_empleado_finiquito]').val());
			 }
			           				
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
	$("#fecha_ingreso").datepicker( $.datepicker.regional["es"] );
	$("#fecha_ingreso").datepicker( "option", "changeMonth", true);
	$("#fecha_ingreso").datepicker( "option", "changeYear", true);

	$("#fecha_nacimiento").datepicker($.datepicker.regional["es"]);
	$("#fecha_nacimiento").datepicker( "option", "changeMonth", true);
	$("#fecha_nacimiento").datepicker( "option", "changeYear", true);
	$("#fecha_nacimiento").datepicker( "option", "defaultDate", "01/01/1980");
	$("#fecha_nacimiento").datepicker( "option", "yearRange", 'c-50:c+20' );
	
	$("#fecha_finiquito").datepicker( $.datepicker.regional["es"] );
	$("#fecha_finiquito").datepicker( "option", "changeMonth", true);
	$("#fecha_finiquito").datepicker( "option", "changeYear", true);
	
	$('#insertar').click(function() {
		$('input[name=nombrei]').val("");
		$('input[name=apellidop]').val("");
		$('input[name=apellidom]').val("");
		$('input[name=puestoi]').val("");
		$('select[name=jefe_inmediato]').val("-1");
		$('select[name=coordinacion_gerencia]').val("-1");
		$('select[name=ubicacioni]').val("0");
		$('select[name=obra_lugar]').val("-1");
		$('input[name=fecha_ingreso]').val("");
		$('select[name=empresa_contratante]').val("0");
		$('select[name=tipo_contratacion]').val("0");
		$('input[name=sueldo_bruto_mensual]').val("");
		$('input[name=porcentaje_imss]').val("");
		$('input[name=fecha_nacimiento]').val("");
		$('select[name=estado_civil]').val("0");
		$('input[name=lugar_de_origen]').val("");
		$('textarea[name=domicilio_actual]').val("");
		$('input[name=email]').val("");
		$('select[name=nacionalidad]').val("0");
		$('select[name=grado_de_estudios]').val("0");
		$('input[name=rfc]').val("");
		$('input[name=curp]').val("");
		$('input[name=tel]').val("");
		$('input[name=extension]').val("");	
		$('#archivo_alta_div').html("<input type='file' id='archivo_alta' name='archivo_alta' value='' />");
		$(":file").uniform();
		$('input[name=accion]').val("insertar");
		$('#archivo_alta_eliminar').hide();
		$.uniform.update("select");	
			
		$('#label_im').html("Insertar un Empleado");
		$('#buscar').hide();
		$('#datos').show();	
		return false;	  
	});
	 
	$('#cancelar').click(function() { 	
		$('#datos').hide();
		$('#buscar').show();	
		return false;	  
	});
	
	$('#cancelar_finiquito').click(function() {	
		$('#finiquito').hide();
		$('#buscar').show();
		return false;
	});
	
	$('#eliminar_finiquito').click(function() {
		$('#datos_finiquito').toggle();
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
            url: "buscarEmpleados.php",      
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
		
	//para cambiar de pagina	
	//if submit button is clicked
    //$('.cambiapag').click(function () {  
	 
});

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
		url: "buscarEmpleados.php",      
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
	//Get the data from all the fields

	var data = 'id=' + id + '&class=' + clase;
	//jQuery('#datos').showLoading();

	$.ajax({
		url: 'consultarEmpleados.php',      
		type: "GET",      
		data: data,                
		cache: false,            
		success: function (html) { 
			//jQuery('#datos').hideLoading();  
			$('#info_' + id).html(html);		
		}      
	});
}

function getEmpleadosSelect() {
	//Get the data from all the fields

	var data = 'select=true';

	$.ajax({
		url: 'consultarEmpleados.php',      
		type: "GET",      
		data: data,                
		cache: false,            
		success: function (html) { 
			//jQuery('#datos').hideLoading();  
			$('select[name=jefe_inmediato]').html(html);		
		}      
	});
}

//Se llama al hacer click en el boton de modificar de un empleado
function iniModificar(id) {
	var data = 'id=' + id + '&modificar=true';

	$.ajax({
		url: 'consultarEmpleados.php',      
		type: "GET",       
		data: data,  
		dataType: 'json',             
		//cache: false,            
		//success
		success: function (html) { 
			//jQuery('#datos').hideLoading(); 
			
			$('input[name=nombrei]').val(html.nombre);
			$('input[name=apellidop]').val(html.apellido_paterno);
			$('input[name=apellidom]').val(html.apellido_materno);
			$('input[name=puestoi]').val(html.puesto);
			$('select[name=jefe_inmediato]').val(html.jefe_inmediato);
			$('select[name=coordinacion_gerencia]').val(html.id_gerencia);
			$('select[name=ubicacioni]').val(html.ubicacion);
			$('select[name=obra_lugar]').val(html.id_obra);
			$('input[name=fecha_ingreso]').val(html.fecha_ingreso);
			$('select[name=empresa_contratante]').val(html.empresa_contratante);
			$('select[name=tipo_contratacion]').val(html.tipo_contratacion);
			$('input[name=sueldo_bruto_mensual]').val(html.sueldo_bruto_mensual);
			$('input[name=porcentaje_imss]').val(html.porcentaje_imss);
			$('input[name=fecha_nacimiento]').val(html.fecha_nacimiento);
			$('select[name=estado_civil]').val(html.estado_civil);
			$('input[name=lugar_de_origen]').val(html.lugar_de_origen);
			$('textarea[name=domicilio_actual]').val(html.domicilio);
			$('input[name=email]').val(html.email);
			$('select[name=nacionalidad]').val(html.nacionalidad);
			$('select[name=grado_de_estudios]').val(html.grado_de_estudios);
			$('input[name=rfc]').val(html.rfc);
			$('input[name=curp]').val(html.curp);
			$('input[name=tel]').val(html.tel);
			$('input[name=extension]').val(html.extension);	
			$('input[name=eliminar_archivo_alta]').attr('checked', false);
			$('#archivo_alta_div').html("<input type='file' id='archivo_alta' name='archivo_alta' value='' />");
			$(":file").uniform();
			
			if (html.archivo_alta == "") {
				$('#archivo_alta_eliminar').hide();
			} else {
				$('#archivo_alta_actual').html("<a href='./archivos/" + html.archivo_alta + "' target='_blank'> Ver archivo</a>");
				$('#archivo_alta_eliminar').show();	
			}
						
			$('input[name=accion]').val("modificar");
			$('input[name=id_empleado]').val(id);
			$.uniform.update("select");	
			
			$('#label_im').html("Modificar un Empleado");
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

//Se llama al hacer click en el boton de modificar de un empleado
function iniModificarFiniquito(id) {
	var data = 'id=' + id + '&modificar=true';

	$.ajax({
		url: 'consultarEmpleados.php',      
		type: "GET",       
		data: data,  
		dataType: 'json',             
		//cache: false,            
		//success
		success: function (html) { 
			//jQuery('#datos').hideLoading(); 
			$('#eliminar_finiquito_div').show();			
			$('input[name=fecha_finiquito]').val(html.fecha_finiquito);
			$('input[name=monto_finiquito]').val(html.monto_finiquito);
			$('input[name=eliminar_archivo_finiquito]').attr('checked', false);
			$('input[name=eliminar_finiquito]').attr('checked', false);
			$('#datos_finiquito').show();
			$('#archivo_finiquito_div').html("<input type='file' id='archivo_finiquito' name='archivo_finiquito' value='' />");
			$(":file").uniform();
			
			if (html.archivo_finiquito == "") {
				$('#archivo_finiquito_eliminar').hide();
			} else {
				$('#archivo_finiquito_actual').html("<a href='./archivos/" + html.archivo_finiquito + "'> Ver archivo</a>");
				$('#archivo_finiquito_eliminar').show();	
			}
						
			$('input[name=accion_finiquito]').val("modificar");
			$('input[name=id_empleado_finiquito]').val(id);
			$.uniform.update("select");	
			
			$('#label_im_finiquito').html("Modificar Finiquito del Empleado");
			$('#buscar').hide();
			$('#finiquito').show();	
		},  
		error: function (data, status, e)
		{
				apprise(e);
		}    
	});
		
	return false;
}

//Se llama al hacer click en el boton de finiquitar de un empleado
function finiquitar(id) {
	$('#eliminar_finiquito_div').hide();
	$('#datos_finiquito').show();
	$('input[name=fecha_finiquito]').val("");
	$('input[name=monto_finiquito]').val("");
	$('#archivo_finiquito_div').html("<input type='file' id='archivo_finiquito' name='archivo_finiquito' value='' />");
	$(":file").uniform();
	$('input[name=accion_finiquito]').val("insertar");
	$('input[name=id_empleado_finiquito]').val(id);
	$('#archivo_finiquito_eliminar').hide();
		
	$('#label_im_finiquito').html("Finiquitar Empleado");
	$('#buscar').hide();
	$('#finiquito').show();	
		
	return false;
}

//Se llama al hacer click en el boton de eliminar de un empleado
function eliminarEmpleado(id) {
	var data = 'id=' + id;
	 
	apprise('Se eliminar&aacute; permanentemente el registro y todos los <br />' 
			+ 'dem&aacute;s registros y archivos referenciando a este empleado. <br /><br />'
			+ '¿Seguro que desea eliminar el registro?', 
		{'verify':true, 'textYes':'Si, elim&iacute;nalo!', 'textNo':'No, quiero conservar el registro'}, 
		function(r){
    		if(r){
				jQuery('#buscar').showLoading();
				$.ajax({
					url: 'eliminarEmpleados.php',      
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

//inserta un registro de un empleado
function insertar(id) {
	//Get the data from all the fields	
	var idr = id;
	var eliminar_archivo;
	var nombre = encodeURIComponent($('input[name=nombrei]').val());
	var apellidop = encodeURIComponent($('input[name=apellidop]').val());
	var apellidom = encodeURIComponent($('input[name=apellidom]').val());
	var puesto = encodeURIComponent($('input[name=puestoi]').val());
	var jefe_inmediato = $('select[name=jefe_inmediato]').val();
	var coordinacion_gerencia = $('select[name=coordinacion_gerencia]').val();
	var ubicacion = $('select[name=ubicacioni]').val();
	var obra_lugar = $('select[name=obra_lugar]').val();
	var fecha_ingreso = $('input[name=fecha_ingreso]').val();
	var empresa_contratante = $('select[name=empresa_contratante]').val();
	var tipo_contratacion = $('select[name=tipo_contratacion]').val();
	var sueldo_bruto_mensual = $('input[name=sueldo_bruto_mensual]').val();
	var porcentaje_imss = $('input[name=porcentaje_imss]').val();
	var fecha_nacimiento = $('input[name=fecha_nacimiento]').val();
	var estado_civil = $('select[name=estado_civil]').val();
	var lugar_de_origen = encodeURIComponent($('input[name=lugar_de_origen]').val());
	var domicilio_actual = encodeURIComponent($('textarea[name=domicilio_actual]').val());
	var email = encodeURIComponent($('input[name=email]').val());
	var nacionalidad = $('select[name=nacionalidad]').val();
	var grado_de_estudios = $('select[name=grado_de_estudios]').val();
	var rfc = $('input[name=rfc]').val();
	var curp = $('input[name=curp]').val();
	var tel = encodeURIComponent($('input[name=tel]').val());
	var extension = encodeURIComponent($('input[name=extension]').val());
	var archivo_alta = encodeURIComponent($('input[name=archivo_alta]').val());		
	var accion = $('input[name=accion]').val();
	
	if ($('input[name=eliminar_archivo_alta]').is(':checked')) {
		archivo_alta = "";
		eliminar_archivo = "1";
	}
	else {
		eliminar_archivo = "0";
	}
	
	var action = "insertarEmpleados.php";

	var data = 'id=' + idr + '&nombre=' + nombre + '&apellidop=' + apellidop + '&apellidom='
	+ apellidom + '&puesto=' + puesto + '&jefe_inmediato=' + jefe_inmediato 
	+ '&coordinacion_gerencia='  + coordinacion_gerencia + '&ubicacion=' + ubicacion
	+ '&obra_lugar=' + obra_lugar + '&fecha_ingreso=' + fecha_ingreso 
	+ '&empresa_contratante=' + empresa_contratante + '&tipo_contratacion=' 
	+ tipo_contratacion + '&sueldo_bruto_mensual=' + sueldo_bruto_mensual
	+ '&porcentaje_imss=' + porcentaje_imss + '&fecha_nacimiento=' + fecha_nacimiento 
	+ '&estado_civil=' + estado_civil + '&lugar_de_origen=' + lugar_de_origen 
	+ '&domicilio_actual=' + domicilio_actual + '&email=' + email + '&nacionalidad=' + nacionalidad 
	+ '&grado_de_estudios=' + grado_de_estudios + '&rfc=' + rfc
	+ '&curp=' + curp + '&tel=' + tel + '&extension=' + extension + '&archivo_alta=' + archivo_alta
	+ '&accion=' + accion + '&eliminar_archivo=' + eliminar_archivo;

	$.ajax({
		//this is the php file that processes the data and send mail
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
				getEmpleadosSelect();
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

//finiquita un empleado
function finiquitoEmpleado(id) {
	//Get the data from all the fields	
	var idr = id;
	var eliminar_archivo_finiquito;

	var fecha_finiquito = $('input[name=fecha_finiquito]').val();
	var monto_finiquito = $('input[name=monto_finiquito]').val();
	var archivo_finiquito = encodeURIComponent($('input[name=archivo_finiquito]').val());		
	var accion = $('input[name=accion_finiquito]').val();
	
	if ($('input[name=eliminar_finiquito]').is(':checked')) {
		eliminar_finiquito = "1";
	}
	else {
		eliminar_finiquito = "0";
	}
	
	if ($('input[name=eliminar_archivo_finiquito]').is(':checked')) {
		archivo_finiquito = "";
		eliminar_archivo_finiquito = "1";
	}
	else {
		eliminar_archivo_finiquito = "0";
	}
	
	var action = "finiquitarEmpleados.php";

	var data = 'id=' + idr + '&fecha_finiquito=' + fecha_finiquito 
	+ '&monto_finiquito=' + monto_finiquito
	+ '&archivo_finiquito=' + archivo_finiquito
	+ '&accion=' + accion + '&eliminar_finiquito=' + eliminar_finiquito
	+ '&eliminar_archivo_finiquito=' + eliminar_archivo_finiquito;

	$.ajax({
		//this is the php file that processes the data and send mail
		url: action,      
		type: "GET",      
		data: data,                
		cache: false,            
		success: function (html) { 
			jQuery('#finiquito').hideLoading();           
			if (html = "success") {						
				$('#finiquito').hide();
				$('#buscar').show();
				$("#doBuscar").trigger("click");
				getEmpleadosSelect();
				if (accion == "insertar") {
					apprise("Se ha registrado el finiquito correctamente.");	
				} else {
					apprise("Se ha modificado el finiquito correctamente.");	
				}				
			}
			else {
				apprise(html);
			}
		}      
	});	
}
	
function ajaxFileUpload(tipo, accion, id, idr){
	//starting setting some animation when the ajax starts and completes
	if (tipo == "empleado") {
		jQuery('#datos').showLoading();
		if ($('#archivo_alta').val().trim() == "" && !$('input[name=eliminar_archivo_alta]').is(':checked')) {
			insertar(idr);
			return false;	
		}
	
		if ($('input[name=eliminar_archivo_alta]').is(':checked')) {
			accion = "borrar";	
		}
	}
	else if (tipo == "finiquito") {
		jQuery('#finiquito').showLoading();
		if ($('#archivo_finiquito').val().trim() == "" && !$('input[name=eliminar_archivo_finiquito]').is(':checked')) {
			finiquitoEmpleado(idr);
			return false;
		}
		if ($('input[name=eliminar_archivo_finiquito]').is(':checked')) {
			accion = "borrar";	
		}
	}
	
	$.ajaxFileUpload
	(
		{
			url:'doajaxfileupload.php', 
			secureuri:false,
			fileElementId:id,
			dataType: 'json',
			data:{tipo:tipo, accion:accion, id:id, idr:idr },
			success: function (data, status)
			{
				if(typeof(data.error) != 'undefined')
				{
					if(data.error != '')
					{
						apprise(data.error);
					}else
					{
						if (tipo == "empleado") {
							insertar(idr);
						}
						else if (tipo == "finiquito") {
							finiquitoEmpleado(idr);
						}
						//alert(data.msg);
					}
					
				}
				else {
					//alert(data.msg + data.error);
				}
			},
			error: function (data, status, e)
			{
				apprise(e);
			}
		}
	)	
	return false;
}

