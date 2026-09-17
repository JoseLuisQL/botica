	<?php
		if (isset($con))
		{
	?>
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content" style="background:white;">
		  <div class="modal-header" style="background: #58FAAC;color:black;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 style="color:black;" class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> <font color="black">Editar Operación</font></h4>
		  </div>
		  <div class="modal-body">
			<form style="color:black;" class="form-horizontal" method="post" id="editar_otrospagos" name="editar_otrospagos">
			<div id="resultados_ajax2"></div>
                        <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Registrar Operación</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" autocomplete="off" class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Breve descripción de la operación" required>
				  <input type="hidden" name="mod_id" id="mod_id">
				</div>
			</div>
                        <div class="form-group">
				<label for="tipo" class="col-sm-3 control-label">Tipo</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="mod_ven_com" name="mod_ven_com" required>
					<option value="">-- Seleccionar tipo de operación --</option>
					<option value="6">Pagos</option>
                                        <option value="5">Cobros</option>
             
                                </select>
				</div>
			</div>
                        <div class="form-group">
				<label for="cliente" class="col-sm-3 control-label">Destinatario</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="mod_cliente" name="mod_cliente" required>
					<option value="1">-- CLIENTES VARIOS --</option>
                        <?php
                        $sql2="select * from clientes ORDER BY  `clientes`.`nombre_cliente` ASC ";
                        $rs1=mysqli_query($con,$sql2);
                        while($row3=mysqli_fetch_array($rs1)){
                            $nombre=$row3["nombre_cliente"];
                            $id_cliente=$row3["id_cliente"];
                            $id_cliente1=$id_cliente;
                        ?>
                        <option value="<?php  echo $id_cliente1;?>"><?php  echo $nombre;?></option>
                        <?php
                        }
                        ?>
                            </select>
				</div>
			</div>
                        
                        <div class="form-group">
				<label for="tipo" class="col-sm-3 control-label">Medio de Pago</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="mod_condiciones" name="mod_condiciones" required>
					<option value="">-- Elegir medio --</option>
                                        <option value="1">Efectivo</option>
                                        <option value="2">Cheque</option>
                                        <option value="3">Transferencia</option>
                                </select>
				</div>
			</div>
			<div class="form-group">
				<label for="pago" class="col-sm-3 control-label">Cantidad</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_pago" name="mod_pago" placeholder="Cantidad a pagar o cobrar en S/" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			</div>
                        <div class="form-group">
				<label for="vendedor" class="col-sm-3 control-label">Tipo de comprobante</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="mod_estado_factura" name="mod_estado_factura" required>
					<option value="">-- Selecciona Tipo de Comprobante --</option>
                        <?php
                        $sql2="select * from comprobante_pago ";
                        $i=0;
                        $rs1=mysqli_query($con,$sql2);
                        while($row3=mysqli_fetch_array($rs1)){
                            $nom_cat=$row3["des_comprobante"];
                            $id_categoria=$row3["id_comprobante"];
                            ?>
                            <option value="<?php  echo $id_categoria;?>"><?php  echo $nom_cat;?></option>
                            <?php
                            $i=$i+1;
                        }
                        ?>
                                </select>
				</div>
			</div>
                        <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Nro Documento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" class="form-control" id="mod_numero_factura" name="mod_numero_factura" placeholder="Nro del documento" required>
				</div>
			</div> 
			<div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Detalle</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <textarea class="form-control" autocomplete="off" id="mod_obs" name="mod_obs"  placeholder="Detalle"></textarea>
				 
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