$(document).ready(function() {
	
	$("#loginbtn").click(function() {
	
		var action = $("#form1").attr('action');
		var pag = $("#pag").val();
		var form_data = {
			username: $("#username").val(),
			password: $("#password").val(),
			is_ajax: 1
		};
		
		$.ajax({
			type: "POST",
			url: action,
			data: form_data,
			success: function(response)
			{
				if (response.trim() == 'success') {
					$("#form1").slideUp('slow', function() {
						$("#message").html("<div class='success'>Has ingresado exit&oacute;samente al sitio.</div>");
					});
					
					if (pag) 
						window.location=pag;
					else
						window.location="index.php";
					
				} else {
					$("#message").html(response);
					//$("#message").html("<div class='error'>Nombre de usuario y/o contrase&ntilde;a inv&aacute;lidos.</div>");	
				}
			}
		});
		
		return false;
	});
	
});
