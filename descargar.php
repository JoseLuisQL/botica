<?php
session_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
header("Content-type: application/vnd.ms-excel" ) ; 
header("Content-Disposition: attachment; filename=productos.xls" ) ; 
 $tienda=$_SESSION['tienda'];       
        $sTable = "products,und";
        
        
		
		$sWhere="where pro_ser=1 and products.und_pro=und.id_und order by b$tienda asc";
                $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
                $sql="SELECT * FROM  $sTable $sWhere ";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			?>
			
                           
			 <table id="example" class="display nowrap" style="width:100%">
                            <thead>
				<tr >
                                       
					<th>Código</th>
					<th>Producto</th>
                                        
                                        <th>S1</th>
					<th>S2</th>
                                        <th>S3</th>
                                        <th>S4</th>
                                        <th>S5</th>
                                        <th>S6</th>
                                        <th>S7</th>
                                        <th><?php echo des1;?></th>
                                        <th><?php echo des2;?></th>
                                        <th><?php echo des3;?></th>
                                        <th>Precio<br><?php echo moneda;?></th>
					<th>Monedero<br><?php echo moneda;?></th>
                                        
				</tr>
                                </thead>
				<?php
                                $i=0;
				while ($row=mysqli_fetch_array($query)){
					$pro_ser=$row['pro_ser'];
                                        if ($pro_ser==1){
                                            
                                            if($i%2==0){
                                                $table="valor1";
                                            }else{
                                                $table="valor2";
                                            }
                                            $i=$i+1;
                                            $id_producto=$row['id_producto'];
                                            $codigo_producto=$row['codigo_producto'];
                                            $nombre_producto=$row['nombre_producto'];
                                            $status_producto=$row['status_producto'];
                                            $des1=$row['des1'];
                                            $des2=$row['des2'];
                                            $des3=$row['des3'];
                                            $cat_pro=$row['cat_pro'];
                                            $pro_ser=$row['pro_ser'];
                                            $foto=$row['foto1'];
                                               
                                            $b1=$row["b1"];
                                            $b2=$row["b2"];
                                            $b3=$row["b3"];
                                            $b4=$row["b4"];
                                            $b5=$row["b5"];
                                            $b6=$row["b6"];
                                            $b7=$row["b7"];
                                            
                                            $mon_venta=$row['mon_venta'];
                                            $dolar=$row['mon_costo'];
                                            $mon_costo=1;
                                            $nom_und=$row["nom_und"];
                                            
                                            $label_class='label-success';
                                            if ($status_producto==1){$estado="Nuevo";}
                                            if ($status_producto==0){$estado="Segunda";}
                                            if ($status_producto==2){$estado="Repuesto";}
                                            $mon="S/";
                                            $date_added= date('d/m/Y', strtotime($row['date_added']));
                                            $precio_producto=$row["a$tienda"];
                                            
                                            $und_pro=$row['und_pro'];
                                            $costo_producto=$row['costo_producto']/$row['mon_costo'];
                                            $costo=$row['costo_producto'];
                                            $utilidad=$row['precio_producto']-$row['costo_producto'];
                                            $mon1=$row['mon']; 
					?>
                                        <tr id="<?php echo $table;?>">
                                        
                                          	
                                            <td><?php echo $codigo_producto; ?></td>
                                            <td width="50px"><?php echo $nombre_producto; ?></td>
                                            
                                            <td ><span class="label <?php echo $label_class;?>"><?php echo $b1; ?></span></td>
                                            <td ><span class="label <?php echo $label_class;?>"><?php echo $b2; ?></span></td>
                                            <td ><span class="label <?php echo $label_class;?>"><?php echo $b3; ?></span></td>
                                            <td ><span class="label <?php echo $label_class;?>"><?php echo $b4; ?></span></td>
                                            <td ><span class="label <?php echo $label_class;?>"><?php echo $b5; ?></span></td>
                                            <td ><span class="label <?php echo $label_class;?>"><?php echo $b6; ?></span></td>
                                            <td ><span class="label <?php echo $label_class;?>"><?php echo $b7; ?></span></td>
                                            <td><?php echo $des1;?></td>
                                            <td><?php echo $des2;?></td>
                                            <td><?php echo $des3;?></td>
                                            <td><span class='pull-right'><?php echo number_format($precio_producto,2);?></span></td>
                                            <td><span class='pull-right'><?php echo number_format($mon1,2);?></span></td>
                                           
                                           
					</tr>
					<?php
                                    }
                                }
				?>
				
			  </table>

			
<?php
                                    }
                              
				?>
