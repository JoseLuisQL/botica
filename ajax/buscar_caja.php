<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
	if($action == 'ajax'){
	$tienda=$_SESSION['tienda'];	// escaping, additionally removing everything that could be (html/javascript-) code
         $user_id=$_SESSION['user_id'];
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
        $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
		 $aColumns = array('nom_cat');//Columnas de busqueda
		 $sTable = "caja";
                 $sWhere = "";
		 $sWhere.=" WHERE caja.tienda=$tienda";
		 if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(fecha, '%Y-%m-%d')>='$q' )";
		}
                if ( $_GET['q1'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(fecha, '%Y-%m-%d')<='$q1')";
		}
                if ( $_GET['q2'] != "" )
		{
		$sWhere.= " and  (caja.usuario_inicio=$q2)";
			
		}
		$sWhere.=" order by id_caja desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './caja.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
                $inicio1=0;
                $entrada1=0;                           
		$salida1=0;				
                $faltante1=0;                                
                $fin1=0;                                
                
                
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table" style="color:black;" border="1">
				<tr  style="background-color:<?php echo tablas;?>;color:white; ">
					<th class='text-center'>Fecha<br>Hora</th>
					<th class='text-right'>Inicio <?php echo moneda;?></th>
                                        <th class='text-right'><font color=red>Usuario Inicia.</font></th>
                                        <?php
                                        if($_SESSION["caja"]==1){
                                        ?>
                                        <th class='text-right'>Entradas <br><?php echo moneda;?></th>
                                        <th class='text-right'>Salidas <br><?php echo moneda;?></th>
                                        <th class='text-right'>Cierre Optimo <br><?php echo moneda;?></th>
                                        <?php
                                        }
                                        ?>
                                        <th class='text-right'>Cierre Real <br><?php echo moneda;?></th>
                                        <th class='text-right'><font color=red>Usuario Cierre.</font></th>
                                        <th class='text-right'>Turno</th>
                                        <th class='text-right'>Faltante <br><?php echo moneda;?></th>
                                        <th>Acciones</th>
                                        <th>Detalle</th>
					
				</tr>
				<?php
                                
                                $r=0;
				while ($row=mysqli_fetch_array($query)){
						$id_caja=$row['id_caja'];
                                                $turno=$row['turno'];
                                                $fecha=date("d/m/Y", strtotime($row['fecha']));
                                                $fecha3=date("d-m-Y", strtotime($row['fecha']));
						$fecha2=date("Y-m-d", strtotime($row['fecha']));
                                                $fec_reg=date("H:i:s", strtotime($row['fec_reg']));
                                                $fec_cie=date("d/m/Y H:i:s", strtotime($row['fecha_cierre']));
                                                if($row['fecha_cierre']=="0000-00-00 00:00:00"){
                                                    $fec_cie="";    
                                                }
                                                
                                                
                                                
                                                date_default_timezone_set('America/Lima');
                                                $fecha4=date("d/m/Y");
                                                $nombres1="";
                                                $nombres2="";
                                                $usuario_inicio=$row['usuario_inicio'];
                                                $usuario1= mysqli_query($con, "SELECT*FROM users  where user_id=$usuario_inicio");
                                                $row6= mysqli_fetch_array($usuario1);
                                                $nombres1 = $row6['nombres'];
                                                
                                                $usuario_cierre=$row['usuario_cierre'];
                                                $usuario2= mysqli_query($con, "SELECT*FROM users  where user_id=$usuario_cierre");
                                                $row7= mysqli_fetch_array($usuario2);
                                                $nombres2 = $row7['nombres'];
                                                //$fecha=$row['fecha'];
						$inicio=$row['inicio'];
                                                $faltante=$row['faltante'];
						$fin=$row['cierre'];
                
                                                
                                                if($usuario_cierre>0){
                                                    $entrada=$row['entrada'];
                                                    $salida=$row['salida'];
                                                }else{
                                                    $suma1= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total1 FROM facturas  where turno='$turno' and condiciones=1 and (estado_factura<=3 or estado_factura=5) and activo=1 and ven_com=1 and tienda=$tienda and id_vendedor=$usuario_inicio and (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
                                                    $row1= mysqli_fetch_array($suma1);
                                                    $total1 = $row1['total1'];
                                                    
                                                    $suma4= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total4 FROM facturas  where  turno='$turno' and condiciones=1 and activo=1 and (ven_com=5 or ven_com=3) and tienda=$tienda and id_vendedor=$usuario_inicio and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
                                                    $row4= mysqli_fetch_array($suma4);
                                                    $total4 = $row4['total4'];
                                                    
                                                    $suma2= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total2 FROM facturas  where turno='$turno' and condiciones=1 and estado_factura=6 and motivo<>'01' and motivo<>'02' and activo=1 and ven_com=1 and tienda=$tienda and id_vendedor=$usuario_inicio and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
                                                    $row2= mysqli_fetch_array($suma2);
                                                    $total2 = $row2['total2'];
                                                    
                                                    $suma3= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total3 FROM facturas  where turno='$turno' and condiciones=1 and activo=1 and (ven_com=2 or ven_com=4) and tienda=$tienda and id_vendedor=$usuario_inicio and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
                                                    $row3= mysqli_fetch_array($suma3);
                                                    $total3 = $row3['total3'];
                                                    
                                                    $suma5= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total5 FROM facturas  where turno='$turno' and condiciones=1 and activo=1 and ven_com=6 and tienda=$tienda and id_vendedor=$usuario_inicio and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
                                                    $row5= mysqli_fetch_array($suma5);
                                                    $total5 = $row5['total5'];
                                                    //PRINT"SELECT SUM(total_venta) AS total5 FROM facturas  where condiciones=1 and activo=1 and ven_com=6 and tienda=$tienda and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )";
                                                    //PRINT"$total5";
                                                    $entrada=$total1+$total4;
                                                    $salida=$total2+$total3+$total5;
                                                    
                                                }
						$color="white";
                                                $mensaje="";
                                              if($fecha==$fecha4) {
                                                  $color="#81F79F";
                                                  $mensaje="<font color=red><strong>(Hoy día)</strong></font>";
                                              }
                                               $read="";
                                              //if($usuario_inicio<>$user_id){
                                              //   $read="style=visibility:hidden "; 
                                              //} 
                                          $faltante=$inicio+$entrada-$salida;      
					?>
					
					<input type="hidden" value="<?php echo $entrada;?>" id="entrada<?php echo $id_caja;?>">
                                        <input type="hidden" value="<?php echo $salida;?>" id="salida<?php echo $id_caja;?>">
                                        <input type="hidden" value="<?php echo $faltante;?>" id="faltante<?php echo $id_caja;?>">
                                        <input type="hidden" value="<?php echo $inicio;?>" id="inicio<?php echo $id_caja;?>">
					
                                        <tr style="background:<?php echo $color;?>">
						<td><?php echo $fecha; print"$mensaje";?><br><font color="blue"><strong><?php echo $fec_reg;?></strong></font></td>
						<td align="right"><?php echo $inicio; ?></td>
                                                <td align="right"><?php echo $nombres1; ?></td>
                                                
                                                <?php
                                                if($_SESSION["caja"]==1){
                                                ?>
						<td align="right"><?php echo $entrada; ?></td>
                                                <td align="right"><?php echo $salida; ?></td>
                                                <td align="right"><?php echo $faltante; ?></td>
                                                <?php
                                                }
                                                ?>
                                                
                                                
                                                <td align="right"><font color="red"><strong><?php echo $fin; ?></strong></font></td>
                                                 <td align="center"><?php echo $nombres2; ?><br><font color="blue"><strong><?php echo $fec_cie;?></strong></font></td>
                                                 <td align="right"><?php echo $turno; ?></td> 
                                                <td align="right"><font color="blue"><strong><?php echo round($fin-$faltante,2); ?></strong></font></td>
						<td align="right"><span class="pull-center">
                                                <?php
                                                if($usuario_cierre==0 ){
                                                    //if($mensaje<>"<font color=red><strong>(Hoy día)</strong></font>"){
                                                    ?>
                                                    <a href="#" class='btn btn-warning btn-xs' <?php echo $read;?> title='Cerrar' onclick="obtener_datos('<?php echo $id_caja;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil"></i>Cerrar</a> 
                                                    <?php
                                                    
                                                        
                                                }else{
                                                    if($usuario_cierre>0){
                                                     if($_SESSION["caja"]==1){
                                                        ?>
                                                    <a href="#" class='btn btn-warning btn-xs' title='Reabrir caja' onclick="abrir('<?php echo $id_caja;?>');"><i class="glyphicon glyphicon-download">Reabrir</i></a>
                                                    <?php
                                                    }
                                                    }else{
                                                    print"<font color=red><strong>Cerrado</strong></font>";
                                                    }
                                                }
                                                ?>
                                                        
                                                </td>
                                                <td>
                                                    
                                                    <?php
                                                    if($_SESSION["caja"]==1){
                                                    ?>
                                                    
                                                    <a href="#" class='btn btn-warning btn-xs' title='Detalle Entradas y Salidas' onclick="caja('<?php echo $fecha3;?>','<?php echo $tienda;?>','<?php echo $usuario_inicio;?>','<?php echo $turno;?>');"><i class="glyphicon glyphicon-download"></i></a>
                                                    <a href="#" class='btn btn-info btn-xs' title='Detalle Ventas' onclick="caja1('<?php echo $fecha3;?>','<?php echo $tienda;?>','<?php echo $usuario_inicio;?>','<?php echo $turno;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
					</tr>
					<?php
                                        $r=$r+1;
                                         $inicio1=$inicio1+$inicio;
                                        $entrada1=$entrada1+$entrada;                           
                                        $salida1=$salida1+$salida;				
                                        $faltante1=$faltante1+$faltante;                                
                                        $fin1=$fin1+$fin; 
                                        
				}
				?>
                                <tr>
                                    <td align="right">TOTAL:</td>
                                    <td align="right"><?php echo $inicio1;?></td><td></td>
                                     <?php
                                                if($_SESSION["caja"]==1){
                                                ?>
                                    
                                    <td align="right"><?php echo $entrada1;?></td>
                                      <td align="right"><?php echo $salida1;?></td>
                                       <td align="right"><?php echo $faltante1;?></td>
                                       <?php
                                                }
                                                ?>
                                       <td align="right"><?php echo $fin1;?></td><td></td><td></td>
                                       <td align="right"><font color="blue"><strong><?php echo round($fin1-$faltante1,2); ?></strong></font></td><td></td><td></td>
                                        
				</tr>        
				<tr>
					<td colspan=12><span class="pull-right"><?PHP
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>