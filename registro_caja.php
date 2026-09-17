	<!doctype html>
<html lang="en">
<head>
<script>
  function limpiarFormulario() {
    document.getElementById("guardar_caja").reset();
  }
</script>
 


</head>


<?php
        //include('conexion.php');
        //include('menu.php');
        
        
        
		if (isset($con))
		{
	?>

	<!-- Modal -->
     
        
          <body>  
            
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	 
         
               
            <div class="modal-dialog" role="document">
              
           
                
                
		<div class="modal-content">
                    
                  
                    
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar inicio de caja</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_caja" name="guardar_caja">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nom_cat" class="col-sm-3 control-label">Fecha</label>
				<div class="col-sm-8">
				  <input type="date" class="form-control" id="fecha" name="fecha" required>
				</div>
			  </div>
			  
                     
                        
                        
			  <div class="form-group">
				<label for="des_cat" class="col-sm-3 control-label">Inicio de caja en S/.</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="inicio" name="inicio" placeholder="Solo número de dos decimales" required>
				  
				</div>
			  </div>
                        
                        
                        
			 
			
		  </div>
		  <div class="modal-footer">
                       <button type="button" class="btn btn-default" onclick="limpiarFormulario()">Limpiar</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

      
        
            
            </body>
            
</html>