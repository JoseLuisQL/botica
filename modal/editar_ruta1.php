	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="width:100%;">
	  <div class="modal-dialog" role="document" style="width:80%;">
		<div class="modal-content" style="color:black;">
		  <div class="modal-header" style="background: #58FAAC;color:black;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Productos alternativos</font></h4>
		  </div>
		  <div class="modal-body" style="height:500px;overflow-y: scroll;">
			<form style='color:black;' class="form-horizontal" method="post" id="editar_ruta" name="editar_ruta">
			<div id="resultados_ajax2"></div>
                        <input type="hidden" name="mod_id" id="mod_id">
			
                        <div id="loader1" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
			<div class="outer_div1" ></div>
                        
                        
                         
                       
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