	<!doctype html>
<html lang="en">
<head>
<script>
  function limpiarFormulario() {
    document.getElementById("guardar_lote").reset();
  }
</script>
</head>
<?php
if (isset($con))
{
?>
	<!-- Modal -->
<body>      
	<div class="modal fade" id="nuevoPack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">  
            <div class="modal-dialog" role="document">  
		<div class="modal-content" style="background: white;">  
		  <div class="modal-header" style="background: #58FAAC;color:black;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black" >Agregar lote</font></h4>
		  </div>
		  <div class="modal-body">
			<form style="color:black;" class="form-horizontal" method="post" id="guardar_lote" name="guardar_lote">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nom_cat" class="col-sm-3 control-label">Lote</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" class="form-control" id="lote" name="lote" placeholder="Lote" required>
				</div>
			  </div>
                         <div class="form-group">
				<label for="nom_cat" class="col-sm-3 control-label">Fecha Fabricación</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="date" autocomplete="off" class="form-control" id="fec_fab" name="fec_fab" placeholder="Fecha Fabricación">
				</div>
			  </div>
                         <div class="form-group">
				<label for="nom_cat" class="col-sm-3 control-label">Fecha Vencimiento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="date" autocomplete="off" class="form-control" id="fec_vto" name="fec_vto" placeholder="Fecha Vencimiento" required>
				</div>
			  </div>   
                         <div class="form-group">
				<label for="nom_cat" class="col-sm-3 control-label">Inv inicial</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="number" min="0.01" autocomplete="off" step="0.01" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad" required>
				</div>
			  </div> 
                           
                        
                        
			  	
		  </div>
		  <div class="modal-footer">
                       <button type="button" class="btn btn-warning" onclick="limpiarFormulario()">Limpiar</button>
			<button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
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

<script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Seleccionar",
        dropdownParent: $('#nuevoPack'),
        allowClear: true
      });
      $(".select2_group").select2({});
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "Con Max Selección límite de 4",
        allowClear: true
      });
    });
    
    
   
  </script>
  