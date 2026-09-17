<?php
$producto = array();
$sql2="select * from products ";
$i=0;
$rs1=mysqli_query($con,$sql2);
while($row3=mysqli_fetch_array($rs1)){  
    $nom[$i]=$row3["nombre_producto"];
    $i=$i+1;
}
?>
  
	<div class="modal fade" id="nuevoProducto1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	   <div class="modal-dialog" role="document">
        	<div class="modal-content" style="background: #F5ECCE;">
		  <div class="modal-header" style="background: #58FAAC;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black" >Detalle Servicio</font></h4>
		  </div>
		  <div class="modal-body">
           
                      <div class="form-group">
				<label for="tipo" class="col-sm-3 control-label">Tipo de Equipo</label>
				<div class="col-sm-8">
                                    <input type="text" class="form-control" id="mod_equipo" name="mod_equipo"  ></textarea>
				</div>
			  </div>
                      <div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripcion</label>
				<div class="col-sm-8">
                                    <textarea class="form-control" id="mod_descripcion" name="mod_descripcion"  ></textarea>
				</div>
			  </div>
                        
                          <div class="form-group">
				<label for="mod_des_ser" class="col-sm-3 control-label">Diagnostico</label>
				<div class="col-sm-8">
                                    <textarea class="form-control" id="mod_des_ser" name="mod_des_ser"  ></textarea>
				</div>
			  </div>
                      
                         
                         <script>
      
                        var tags8 = [];
                        <?php
                            for($i = 0 ;$i<count($nom);$i++){
                        ?>
                            tags8.push("<?php echo $nom[$i];?>");
                        <?php } ?>
      
                        $("#producto1" ).autocomplete({
                        source: function( request, response ) {
                        var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
                        response( $.grep( tags8, function( item ){
                        return matcher.test( item );
                        }) );
                        }
                        });

                    </script>    
                    <div class="form-group">
				<label for="mod_com_ser" class="col-sm-3 control-label">Comentario Servicio</label>
				<div class="col-sm-8">
                                    <textarea class="form-control" id="mod_com_ser" name="mod_com_ser"  ></textarea>
				</div>
			  </div>
                </div>
		  
	</div>
    </div>
</div>
	