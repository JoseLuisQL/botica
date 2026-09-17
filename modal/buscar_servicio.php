	<?php
        $id_producto=1;
		if (isset($con))
		{
	?>	
			<!-- Modal -->
			<div class="modal fade bs-example-modal-lg" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Descripcion:</h4>
				  </div>
				  <div class="modal-body">
					<form class="form-horizontal">
					  
                                <table class="table" style="width:100%;">
                                <tr  style="background:black;color:white;">
                                        <th><span class="pull-center" style="width:50%;">Detalle de la Descripcion</span></th>
					<th><span class="pull-center" style="width:20%;">Cant.</span></th>
					<th><span class="pull-center" style="width:20%;">Precio</span></th>
					<th class='text-center' style="width:10%;">Agregar</th>
				</tr>
                                <tr>       
                                    <td style="width:50%;">
					
                                        <input type="text" class="form-control" style="text-align:left;width:100%;" id="descripcion_1" autocomplete="off" placeholder="Detalle de la descripción o servicio" >
                                        <input type="hidden" class="form-control" style="text-align:left;" id="stocka_1"  value="100000" >
                                    </td>
                                    <td>
					
                                        <input type="number" min="0.01" step="0.01" class="form-control" style="text-align:center" id="cantidada_1"  value="1" >
					
                                    </td>
                                    <td>
                                        
                                        <input type="number" min="0.01" step="0.01" class="form-control" style="text-align:center" id="precio_ventaa_1"  >  
                                        
                                    </td>
                                    <td class='text-center'><a class='btn btn-info'href="#" onclick="agregar1(1)"><i class="glyphicon glyphicon-plus"></i></a></td>
				</tr>
                                <tr>    
                                    <td style="width:50%;">
					
                                        <select class="form-control" style="text-align:left;" id="descripcion_2" name="descripcion" required>
					<option value="">-- Selecciona servicio --</option>
			
                                         <?php
                                        
                                        $sql3="select * from servicios ";
                                        $rs3=mysqli_query($con,$sql3);
                                        while($row4=mysqli_fetch_array($rs3)){
                                            $nom_servicio=$row4["nom_servicio"];
                                            $id_servicio=$row4["id_servicio"];
                                            $pre_servicio=$row4["pre_servicio"];
                                            //$id_und=$row4["id_und"];
                                        ?>  

                                        <option value="<?php echo $nom_servicio;?>"><?php  echo $nom_servicio;?></option>

                                           <?php
                                        }         
                                        ?> 
                                        </select>  
                                            
                                            <input type="hidden" class="form-control" style="text-align:left;" id="stocka_2"  value="1000" >
                                    </td>
                                    <td>
                                            
                                        <input type="number" min="0.01" step="0.01" class="form-control" style="text-align:center" id="cantidada_2" value="1">
                                            
                                    </td>
                                    <td>
                                        
                                        <input type="number" min="0.01" step="0.01" class="form-control" style="text-align:center" value="" id="precio_ventaa_2">    
                                        
                                    </td>
                                    <td class='text-center'><a class='btn btn-info'href="#" onclick="agregar1(2)"><i class="glyphicon glyphicon-plus"></i></a></td>
				
                                </tr>
                                
                                
                            </table>    
                        </form>
                    </div>
		</div>
            </div>
	</div>
<?php
}
?>