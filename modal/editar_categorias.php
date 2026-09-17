	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content" style="background: white;">
		  <div class="modal-header" style="background: #58FAAC;color:black;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 style="color:black;" class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Editar categoria</font></h4>
		  </div>
		  <div class="modal-body">
			<form style="color:black;" class="form-horizontal" method="post" id="editar_categoria" name="editar_categoria">
			<div id="resultados_ajax2"></div>
			  <div class="form-group">
				<label for="mod_cat" class="col-sm-3 control-label">Nombre</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" autocomplete="off" class="form-control" id="mod_cat" name="mod_cat" placeholder="Nombre de la categoria" required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_des" class="col-sm-3 control-label">Descripcion</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <textarea class="form-control" autocomplete="off" id="mod_des" name="mod_des" placeholder="Descripcion de la categoria" required></textarea>
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