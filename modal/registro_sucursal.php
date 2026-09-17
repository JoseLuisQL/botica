	<!doctype html>
<html lang="en">
<head>
<script>
  function limpiarFormulario() {
    document.getElementById("guardar_sucursal").reset();
  }
</script>
 <style type="text/css"> 
.thumb {
            height: 100px;
            width:170px;
            border: 1px solid #000;
            margin: 10px 5px 0 0;
          }
</style> 
</head>

<?php
       
        if (isset($con))
	{
	?>
  
          <body>  
            
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	     
            <div class="modal-dialog" role="document">
              
		<div class="modal-content" style="background: white;">
                   
		  <div class="modal-header" style="background: #58FAAC;color:black;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 style="color:black;" class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nueva Sucursal</h4>
		  </div>
		  <div class="modal-body">
			<form style="color:black;" class="form-horizontal" action="" enctype="multipart/form-data" method="post" id="guardar_sucursal" name="guardar_sucursal">
			<font color="black">LLenar los campos obligatorios</font> <font style="background-color:#A9F5BC;color:white; "> &nbsp;&nbsp;&nbsp;&nbsp;</font>
                        
                            <div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" class="form-control" autocomplete="off" id="nom_cat" name="nombre" placeholder="Nombre de la sucursal" required style="background-color: #A9F5BC;">
				</div>
			  </div>
                          <?php
                        $doc="";
                        $read="";
                        $sql2="select * from sucursal ORDER BY sucursal.tienda DESC LIMIT 0,1";
                        $rs1=mysqli_query($con,$sql2);
                        $row3=mysqli_fetch_array($rs1);
                        $tienda=$row3["tienda"]+1;
                        $doc=$row3["ruc"];
                        if($doc<>""){
                            //$read="readonly";
                        }
                        
                        ?>  
			  <div class="form-group">
				<label for="ruc" class="col-sm-3 control-label">Ruc</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="ruc" name="ruc" autocomplete="off" value="<?php echo $doc;?>" placeholder="ruc" required style="background-color: #A9F5BC;">
				  
				</div>
			  </div>
                        
                        
                        <input type="hidden" nombre="mod_tienda" id="mod_tienda" value="<?php echo $tienda;?>" >
                      
                        <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Direccion</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="direccion" name="direccion" placeholder="direccion" autocomplete="off" >
				  
				</div>
			  </div>
                        <div class="form-group">
				<label for="correo" class="col-sm-3 control-label">Correo</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text"  autocomplete="off" class="form-control" id="correo" name="correo" placeholder="correo" >
				  
				</div>
			  </div>
			 
			<div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Telefono</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" autocomplete="off" class="form-control" id="telefono" name="telefono" placeholder="telefono" >
				  
				</div>
			  </div>
                         <div class="form-group">
				<label for="ubigeo" class="col-sm-3 control-label">Departamento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" autocomplete="off" class="form-control" id="departamento" name="departamento" placeholder="Departamento" >
				  
				</div>
			  </div>
                         <div class="form-group">
				<label for="ubigeo" class="col-sm-3 control-label">Provincia</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" autocomplete="off" class="form-control" id="provincia" name="provincia" placeholder="Provincia" >
				  
				</div>
			  </div>
                         <div class="form-group">
				<label for="ubigeo" class="col-sm-3 control-label">Distrito</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" autocomplete="off" class="form-control" id="distrito" name="distrito" placeholder="Distrito" >
				  
				</div>
			  </div>
                        
                        
                        <div class="form-group">
				<label for="ubigeo" class="col-sm-3 control-label">Ubigeo</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text"  autocomplete="off" class="form-control" id="ubigeo" name="ubigeo" placeholder="ubigeo" readonly>
				  
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
        <script>
        
         function archivo(evt) {
			var files = evt.target.files; // FileList object
		
			// Obtenemos la imagen del campo "file".
			for (var i = 0, f; f = files[i]; i++) {
			  //Solo admitimos imágenes.
			  if (!f.type.match('image.*')) {
				continue;
			  }
		
			  var reader = new FileReader();
		
			  reader.onload = (function(theFile) {
				return function(e) {
				  // Insertamos la imagen
				 document.getElementById("list").innerHTML = ['<img  class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
				};
			  })(f);
		
			  reader.readAsDataURL(f);
			}
		  }
        document.getElementById('files').addEventListener('change', archivo, false);
        </script>    
</html>