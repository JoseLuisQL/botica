<?php
session_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
header("Content-type: application/vnd.ms-excel" ) ; 
header("Content-Disposition: attachment; filename=productos.xls" ) ; 
 $tienda=$_SESSION['tienda'];       
        $sTable = "products,und";
        $suma=0;
        $suma1=0;
		
		$sWhere="where pro_ser=1 and products.und_pro=und.id_und order by b$tienda asc";
                $texto="sum(b1*costo_producto) AS c1,sum(b2*costo_producto) AS c2,sum(b3*costo_producto) AS c3,sum(b4*costo_producto) AS c4,sum(b5*costo_producto) AS c5,sum(b6*costo_producto) AS c6,sum(b7*costo_producto) AS c7,";
                $texto1="sum(b1*precio_producto) AS d1,sum(b2*precio_producto) AS d2,sum(b3*precio_producto) AS d3,sum(b4*precio_producto) AS d4,sum(b5*precio_producto) AS d5,sum(b6*precio_producto) AS d6,sum(b7*precio_producto) AS d7";
                
                $count_query   = mysqli_query($con, "SELECT count(*) AS numrows,$texto $texto1 FROM $sTable $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
                $c1 = round($row['c1'],1);
                $c2 = round($row['c2'],1);
                $c3 = round($row['c3'],1);
                $c4 = round($row['c4'],1);
                $c5 = round($row['c5'],1);
                $c6 = round($row['c6'],1);
                $c7 = round($row['c7'],1);
                
                $d1 = round($row['d1'],1);
                $d2 = round($row['d2'],1);
                $d3 = round($row['d3'],1);
                $d4 = round($row['d4'],1);
                $d5 = round($row['d5'],1);
                $d6 = round($row['d6'],1);
                $d7 = round($row['d7'],1);
                
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
                                        <th>Precio</th>
					<th>Costo</th>
                                        
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
                                            $precio_producto=$row['precio_producto'];
                                            
                                            $und_pro=$row['und_pro'];
                                            $costo_producto=$row['costo_producto'];
                                            $total=$costo_producto*($b1+$b2+$b3+$b4+$b5+$b6);
                                            $total1=$precio_producto*($b1+$b2+$b3+$b4+$b5+$b6);
                                            $suma=$suma+$total;
                                            $suma1=$suma1+$total1;
                                            
                                            $utilidad=$row['precio_producto']-$row['costo_producto'];
                                             
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
                                            <td><span class='pull-right'><?php echo number_format($costo_producto,2);?></span></td>
                                           
					</tr>
                                        
					<?php
                                    }
                                }
				?>
				<tr>
                                    <td></td>
                                    <td style="text-align:right;">COSTO:</td>
                                    <td style="text-align:right;"><?php echo $c1;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c2;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c3;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c4;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c5;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c6;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c7;?>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align:right;">INGRESO:</td>
                                    <td style="text-align:right;"><?php echo $d1;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d2;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d3;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d4;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d5;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d6;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d7;?>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                 <tr>
                                    <td></td>
                                    <td style="text-align:right;">DIF:</td>
                                    <td style="text-align:right;"><?php echo $d1-$c1;?></td>
                                    <td style="text-align:right;"><?php echo $d2-$c2;?></td>
                                    <td style="text-align:right;"><?php echo $d3-$c3;?></td>
                                    <td style="text-align:right;"><?php echo $d4-$c4;?></td>
                                    <td style="text-align:right;"><?php echo $d5-$c5;?></td>
                                    <td style="text-align:right;"><?php echo $d6-$c6;?></td>
                                    <td style="text-align:right;"><?php echo $d7-$c7;?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
			  </table>

			
<?php
                                    }
                              
				?>
