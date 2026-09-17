	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
        <script>
  function limpiarFormulario() {
    document.getElementById("guardar_usuario").reset();
  }
</script>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content" style="background: white;" >
		  <div class="modal-header" style="background: #58FAAC;color:black;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 style="color:black;" class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Agregar nuevo usuario</font></h4>
		  </div>
		  <div class="modal-body">
			<form style="color:black;" class="form-horizontal" method="post" id="guardar_usuario" name="guardar_usuario">
			<font color="black">LLenar los campos obligatorios</font> <font style="background-color:#A9F5BC;color:white; "> &nbsp;&nbsp;&nbsp;&nbsp;</font>
                        <div id="resultados_ajax"></div>
			<div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Nombres y Apellidos</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" class="form-control" style="background-color: #A9F5BC;" id="firstname" name="firstname" placeholder="Nombres" required>
				</div>
			</div>
			<div class="form-group">
				<label for="user_name" class="col-sm-3 control-label">Usuario</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" class="form-control" style="background-color: #A9F5BC;" id="user_name" name="user_name" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)"required>
				</div>
			</div>
			<div class="form-group">
				<label for="user_email" class="col-sm-3 control-label">Email</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="email" autocomplete="off" class="form-control" id="user_email" name="user_email" placeholder="Correo electrónico">
				</div>
			</div>
                        <div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Telefonos</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" class="form-control" id="telefono" name="telefono" placeholder="Telefonos" >
				</div>
			</div>
                            
                        <div class="form-group">
				<label for="domicilio" class="col-sm-2 control-label">Domicilio</label>
				<div class="col-md-4 col-sm-4 col-xs-12">
				  <input type="text" autocomplete="off" class="form-control" id="domicilio" name="domicilio" placeholder="Domiclio" >
				</div>
			  
				<label for="dni" class="col-sm-2 control-label">DNI</label>
				<div class="col-md-4 col-sm-4 col-xs-12">
				  <input type="text" autocomplete="off" class="form-control" id="dni" name="dni" placeholder="DNI" >
				</div>
			</div>
			<div class="form-group">
				<label for="user_password_new" class="col-sm-2 control-label">Contraseña</label>
				<div class="col-md-4 col-sm-4 col-xs-12">
				  <input type="password" style="background-color: #A9F5BC;" class="form-control" id="user_password_new" name="user_password_new" placeholder="Contraseña" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>
				</div>
			 
				<label for="user_password_repeat" class="col-sm-2 control-label">Repetir</label>
				<div class="col-md-4 col-sm-4 col-xs-12">
				  <input type="password" style="background-color: #A9F5BC;" class="form-control" id="user_password_repeat" name="user_password_repeat" placeholder="Repite contraseña" pattern=".{6,}" required>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
                      <button type="button" class="btn btn-warning" onclick="limpiarFormulario()">Limpiar</button>
			<button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>