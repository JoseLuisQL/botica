 $(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_sucursal.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar la categoria")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_sucursal.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		
		
	
$( "#guardar_sucursal" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_sucursal.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_sucursal" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_sucursal.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	
	function obtener_datos(id){
			var nombre = $("#nombre"+id).val();
                        var ruc = $("#ruc"+id).val();
                        var direccion = $("#direccion"+id).val();
                        var correo = $("#correo"+id).val();
                        var telefono = $("#telefono"+id).val();
                        var ubigeo = $("#ubigeo"+id).val();
                        var departamento = $("#departamento"+id).val();
                        var provincia = $("#provincia"+id).val();
                        var distrito = $("#distrito"+id).val();
                        
                        $("#mod_nombre").val(nombre);
                        $("#mod_ruc").val(ruc);
                        $("#mod_direccion").val(direccion);
                        $("#mod_correo").val(correo);
                        $("#mod_telefono").val(telefono);
                        $("#mod_id").val(id);
                        $("#mod_ubigeo").val(ubigeo);
                        $("#mod_departamento").val(departamento);
                        $("#mod_provincia").val(provincia);
                        $("#mod_distrito").val(distrito);
		}