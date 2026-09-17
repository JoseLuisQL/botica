	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content" style="background: white;">
		  <div class="modal-header" style="background: #58FAAC;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Editar  Lote</font></h4>
		  </div>
		  <div class="modal-body">
			<form style="color:black;" class="form-horizontal" method="post" id="editar_lote" name="editar_lote">
			<div id="resultados_ajax2"></div>
                            <div class="form-group">
				<label for="mod_serie" class="col-sm-3 control-label">Lote</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input autocomplete="off" type="text" class="form-control" id="mod_lote" name="mod_lote" placeholder="Lote" required>
					<input type="hidden" name="mod_id" id="mod_id">
                                        <input type="hidden" name="mod_final" id="mod_final">
                                        <input type="hidden" name="mod_id_producto" id="mod_id_producto">
				</div>
			  </div>
                        
                             <div class="form-group">
				<label for="mod_serie" class="col-sm-3 control-label">Fecha Fabricación</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="date" autocomplete="off" class="form-control" id="mod_fec_fab" name="mod_fec_fab">
					
				</div>
                             </div>
                             <div class="form-group">
				<label for="mod_serie" class="col-sm-3 control-label">Fecha Vencimiento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="date" autocomplete="off" class="form-control" id="mod_fec_vto" name="mod_fec_vto" placeholder="Fecha Vencimiento" required>
					
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_serie" class="col-sm-3 control-label">Cantidad</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="number" min="0" step="1" autocomplete="off" class="form-control" id="mod_cantidad" name="mod_cantidad" placeholder="Cantidad" required>
					
				</div>
			  </div>
			   	
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>