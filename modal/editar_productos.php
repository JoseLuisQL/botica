<?php  
if (isset($con))
{
$sql3="select * from datosempresa ";
$rs2=mysqli_query($con,$sql3);
while($row4=mysqli_fetch_array($rs2)){
    $dolar=$row4["dolar"];
}        
?>
<head>

<script>
var mostrarValor = function(x){
    if (x>0){
        x1=1;                 
                        }
    else{
        x1=<?php echo $dolar;?>;                  
    }
     
   
   
};                         
</script>
<script type="text/javascript">
$(document).ready(function() {
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
});
</script>
</head>
    <body>  
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content" style="background: white;">
		  <div class="modal-header" style="background: #58FAAC;color:black;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 style="color:black;" class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Editar producto</font></h4>
		  </div>
                  <div id="resultados_ajax2"></div>
		  <div class="modal-body" style="height:500px;overflow-y: scroll;">
			<form style="color:black;" class="form-horizontal" method="post" id="editar_producto" name="editar_producto">
			
			  <div class="form-group">
				<label for="mod_codigo" class="col-sm-3 control-label">Código</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" class="form-control" id="mod_codigo" name="mod_codigo" placeholder="Código del producto" required>  
                                  <input type="hidden" name="mod_id" id="mod_id">
                                  <input type="hidden" name="pagi" id="pagi">
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Nombre del producto" required>
				</div>
			  </div>
			<div class="form-group">
				<label for="mod_cat" class="col-sm-3 control-label">Categoria</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="mod_cat" name="mod_cat" >
					<option value="">-- Selecciona categoria de producto --</option>
					
                                         <?php
                                        $nom = array();
                                        $sql2="select * from categorias ";
                                        $rs1=mysqli_query($con,$sql2);
                                        while($row3=mysqli_fetch_array($rs1)){
                                            $nom_cat=$row3["nom_cat"];
                                            $id_categoria=$row3["id_categoria"];
                                        ?>

                                        <option value="<?php echo $id_categoria;?>"><?php  echo $nom_cat;?></option>

                                        <?php
                                        }         
                                        ?>              
				  </select>
				</div>
			  </div>
                          <div class="form-group">
				<label for="mod_cat" class="col-sm-3 control-label">Und/Medida</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="mod_und_pro" name="mod_und_pro" required>
					<option value="">-- Selecciona und/medida de producto --</option>
					
                                         <?php
                                        
                                        $sql3="select * from und ";
                                        $rs3=mysqli_query($con,$sql3);
                                        while($row4=mysqli_fetch_array($rs3)){
                                            $nom_und=$row4["nom_und"];
                                            $id_und=$row4["id_und"];
                                        ?>

                                        <option value="<?php echo $id_und;?>"><?php  echo $nom_und;?></option>

                                        <?php
                                        }         
                                        ?>              
				  </select>
				</div>
			  </div>  
                            
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Unitario</strong>
                        <div class="form-group">
				<label for="mod_costo" class="col-sm-1 control-label">Costo</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
				  <input type="number" min="0.01" step="0.01" autocomplete="off" class="form-control"  id="mod_costo" name="mod_costo" placeholder="Precio de costo del producto" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			
				<label for="mod_precio" class="col-sm-1 control-label">Precio</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="number" min="0.01" step="0.01" class="form-control" id="mod_precio" name="mod_precio" placeholder="Precio 1" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" >
				</div>
                                <label for="mod_precio" class="col-sm-2 control-label">Contiene</label>
				<div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="number" min="0" step="1" class="form-control" id="d7" name="d7" value="1" readonly >
				</div>
			</div>
                         
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Blister y otros</strong>
                        <div class="form-group">
				<label for="mod_costo" class="col-sm-1 control-label">Costo</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
				  <input type="number" min="0" step="0.01" autocomplete="off" class="form-control"  id="c2" name="c2" placeholder="Precio"  pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			
				<label for="mod_precio" class="col-sm-1 control-label">Precio</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="number" min="0" step="0.01" class="form-control" id="p2" name="p2" placeholder="Precio"  pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" >
				</div>
                                <label for="mod_precio" class="col-sm-2 control-label">Contiene</label>
				<div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="number" min="0" step="1" class="form-control" id="d2" name="d2" placeholder="Contiene"  pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$"  >
				</div>
                                 <label for="mod_precio" class="col-sm-1 control-label">Tipo</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" min="0" step="1" class="form-control" id="tipo7" name="tipo7" placeholder="tipo" readonly   >
				</div>
			</div>
                        
                        
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Caja</strong>
                        <div class="form-group">
				<label for="mod_costo" class="col-sm-1 control-label">Costo</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
				  <input type="number" min="0" step="0.01" autocomplete="off" class="form-control"  id="c3" name="c3" placeholder="Precio " pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			
				<label for="mod_precio" class="col-sm-1 control-label">Precio</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="number" min="0" step="0.01" class="form-control" id="p3" name="p3" placeholder="Precio 1"  pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" >
				</div>
                                <label for="mod_precio" class="col-sm-2 control-label">Contiene</label>
				<div class="col-md-2 col-sm-2 col-xs-12">
                                    <input type="number" min="0" step="1" class="form-control" id="d3" name="d3" placeholder="Contiene"  pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$"  >
				</div>
			</div>
                        
                         <?php 
                        $aa="";
                        $sql1="select * from users where user_id=$_SESSION[user_id]";
                        $rw1=mysqli_query($con,$sql1);//recuperando el registro
                        $rs1=mysqli_fetch_array($rw1);
                        $modulo=$rs1["accesos"];
                        $a = explode(".", $modulo); 
                        if($a[3]==0){
                            $aa="readonly";
                        }
                        ?>
                        
                         <div class="form-group">
				<label for="mod_inv" class="col-sm-3 control-label">Inventario</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="number" min="0" step="0.01" <?php echo "$aa";?> class="form-control" id="mod_inv" name="mod_inv" placeholder="Precio" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" >
				</div>
			  </div>
                            <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">Stock minimo</label>
				<div class="col-sm-8">
				  <input type="number" min="0" step="0.01" class="form-control" id="mod_min" name="mod_min" placeholder="Stock minimo del producto" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			  </div>




			  <!-- AGREGADO REGISTRO_SANITARIO -->

			  <div class="form-group">
				<label for="mod_registrosanitario" class="col-sm-3 control-label">Registro Sanitario</label>
				<div class="col-sm-8">
				  <input type="text"  class="form-control" id="mod_registrosanitario" name="mod_registrosanitario" placeholder="Registro Sanitario"  >
				</div>
			  </div>

			  <!-- <div class="form-group">
				<label for="mod_color" class="col-sm-3 control-label">Registro Sanitario</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text"  autocomplete="off" class="form-control" id="mod_registrosanitario" name="mod_registrosanitario" placeholder="Registro Sanitario">
				</div>
			  </div> 
			   -->









                            <div class="form-group">
                                <label for="mod_color" class="col-sm-3 control-label"><font color='red'><strong>Cantidad incentivo</strong></font></label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="number" min="0.00" step="0.01" class="form-control" <?php echo "$aa";?> id="mod_valor2" name="mod_valor2" placeholder="Cantidad Alternativo" readonly>
				</div>
			  </div>
                            <div class="form-group">
				<label for="mod_color" class="col-sm-3 control-label"><font color='red'><strong>Valor a pagar incentivo</strong></font></label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="number" min="0.00" step="0.01" class="form-control" <?php echo "$aa";?> id="mod_valor3" name="mod_valor3" placeholder="Valor de comision" readonly>
				</div>
			  </div>
                              <div class="form-group">
				<label for="mod_marca" class="col-sm-3 control-label">Proveedor</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text"  autocomplete="off" class="form-control" id="proveedor" name="proveedor" placeholder="Nombre del proveedor">
				</div>
                            </div>
                             <div class="form-group">
				<label for="mod_marca" class="col-sm-3 control-label"><?php echo des1;?></label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text"  autocomplete="off" class="form-control" id="mod_des1" name="mod_des1" placeholder="<?php echo des1;?>">
				</div>
			</div>
                        <div class="form-group">
				<label for="mod_modelo" class="col-sm-3 control-label"><?php echo des2;?></label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text"  autocomplete="off" class="form-control" id="mod_des2" name="mod_des2" placeholder="<?php echo des2;?>">
				</div>
			  </div>
                        <div class="form-group">
				<label for="mod_color" class="col-sm-3 control-label"><?php echo des3;?></label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text"  autocomplete="off" class="form-control" id="mod_des3" name="mod_des3" placeholder="<?php echo des3;?>">
				</div>
			  </div>
                           <div class="form-group">
				<label for="mod_color" class="col-sm-3 control-label">Barras</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text"  autocomplete="off" class="form-control" id="mod_barras" name="mod_barras" placeholder="Barras">
				</div>
			  </div> 
                           <div class="form-group">
				<label for="mod_precio" class="col-sm-3 control-label">Monedero</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="number" min="0.00" step="0.01"  autocomplete="off" class="form-control" id="mod_mon" name="mod_mon" placeholder="Monedero" readonly >
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
</body>