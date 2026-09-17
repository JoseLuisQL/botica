	<!doctype html>
<html lang="en">
<head>
   <script>
  function limpiarFormulario() {
    document.getElementById("guardar_cliente").reset();
  }
</script>
</head>
<?php
//
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document" style="width:70%;">
		<div class="modal-content" style="background: white;">
		  <div class="modal-header" style="background: #58FAAC;color:black;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 style="color:black;" class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Agregar nuevo cliente</font></h4>
		  </div>
                     <font color="black">LLenar los campos obligatorios</font> <font style="background-color:#A9F5BC;color:white; "> &nbsp;&nbsp;&nbsp;&nbsp;</font>
                    
                  <div id="resultados_ajax"></div> 
		  <div class="modal-body" style="height:450px;overflow-y: scroll;">  
			<form style="color:black;" class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente">
                             <div class="form-group">
				<label for="doc" class="col-sm-3 control-label">Documento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" style="background-color:#A9F5BC;" class="form-control"  id="doc" name="doc" placeholder="Nro de Documento" >
				</div>
			  </div>
                         <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Tipo de doc</label>
				<div class="col-md-4 col-sm-4 col-xs-12">
				 <select class="form-control" id="tipo" name="tipo" required>
					<option value="">-- Tipo de doc --</option>
					<option value="2">RUC</option>
					<option value="1">DNI</option>
				  </select>
				</div>
                                 <div class="col-md-4 col-sm-4 col-xs-12">
                                      <input  type="button" class="btn btn-success"  id="btn-ingresar" value="Buscar Ruc/Dni" />
                                </div>
                                  
                                
                                
			  </div>
                            
                             <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Razon Social</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" style="background-color:#A9F5BC;" class="form-control"  id="nombre" name="nombre" placeholder="Razon Social" required>
				</div>
			  </div> 
			  <div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" class="form-control" id="telefono" name="telefono" placeholder="Teléfono">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Email</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="email" autocomplete="off" class="form-control" id="email" name="email" placeholder="Email">
				  
				</div>
			  </div>
                          <div class="form-group">
				<label for="departamento" class="col-sm-3 control-label">Departamento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" autocomplete="off" class="form-control" id="departamento" name="departamento" placeholder="Departamento">
				  
				</div>
			  </div> 
                           <div class="form-group">
				<label for="provincia" class="col-sm-3 control-label">Provincia</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text"  autocomplete="off" class="form-control" id="provincia" name="provincia" placeholder="Provincia">
				  
				</div>
			  </div> 
                          <div class="form-group">
				<label for="distrito" class="col-sm-3 control-label">Distrito</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" autocomplete="off" class="form-control" id="distrito" name="distrito" placeholder="Distrito">
				  
				</div>
			  </div>  
			  <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control" autocomplete="off" id="direccion" name="direccion"   maxlength="255" placeholder="Dirección"></textarea>
				  
				</div>
			  </div>
                          <div class="form-group">
				<label for="cuenta" class="col-sm-3 control-label">Cuenta Bancaria</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control" autocomplete="off" id="cuenta" name="cuenta"   maxlength="255" placeholder="Cuenta Bancaria"></textarea>
				  
				</div>
			  </div> 
                           <div class="form-group">
				<label for="ven" class="col-sm-3 control-label">Vendedor</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" autocomplete="off" id="ven" name="ven" placeholder="Vendedor">
				</div>
			  </div>   
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>	
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-warning" onclick="limpiarFormulario()">Limpiar</button>
                      <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" onclick="nif()" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
        <script>
        function rucValido(ruc) {
    //11 dígitos y empieza en 10,15,16,17 o 20
        if (!(ruc >= 1e10 && ruc < 11e9
            || ruc >= 15e9 && ruc < 18e9
            || ruc >= 2e10 && ruc < 21e9))
            return false;
    
            for (var suma = -(ruc%10<2), i = 0; i<11; i++, ruc = ruc/10|0)
                suma += (ruc % 10) * (i % 7 + (i/7|0) + 1);
                return suma % 11 === 0;
    
        }
        function nif() {
            var doc1=document.getElementById("doc").value
            var tipo=document.getElementById("tipo").value
             var n = doc1.length;
                    
            if ((n == 11 && tipo==2) |  (n == 8 && tipo==1) ) {
            }else{
                alert('El dni o ruc es erroneo');
                event.preventDefault();
                return false;
            }
        }
         $(document).on('ready',function(){

                        $('#btn-ingresar').click(function(){
                        var url = "busqueda4.php";                                      
        
                        $.ajax({                        
                        type: "POST",                 
                        url: url,                    
                        data: $("#guardar_cliente").serialize(),
                        success: function(data)            
                        {
                            $('#doc').html(data);
                            porciones = data.split('|');
                            document.getElementById("nombre").value = porciones[0];
                            document.getElementById("direccion").value = porciones[1];
                            
                        }
                        });
         
                        });
                    });
        </script>
        
      
	<?php
		}
	?>



