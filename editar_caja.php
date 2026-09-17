	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Caja</h4>
		  </div>
		  <div class="modal-body">
			<form style="color:black;" class="form-horizontal" method="post" id="editar_caja" name="editar_caja">
			<div id="resultados_ajax2"></div>
			  <div class="form-group">
				<label for="mod_cat" class="col-sm-3 control-label">Inicio de Caja en <?php echo moneda;?>.</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_inicio" name="mod_inicio" placeholder="Solo número de dos decimales" required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
			   
			  
			  
                        
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>