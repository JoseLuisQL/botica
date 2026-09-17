		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_resumen.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}
                $( "#guardar_resumen" ).submit(function( event ) {
                $('#guardar_datos').attr("disabled", true);
  
                var parametros = $(this).serialize();
                $.ajax({
			type: "POST",
			url: "pdf/documentos/envio_data_resumen_boletas.php",
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

		function resumen(id_factura){
			VentanaCentrada('./pdf/documentos/resumen/'+id_factura,'Factura','','1024','768','true');
		}
                function cdrresumen(id_factura){
			VentanaCentrada('./pdf/documentos/cdrresumen/'+id_factura,'Factura','','1024','768','true');
		}
               


