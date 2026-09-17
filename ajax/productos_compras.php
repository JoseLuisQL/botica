<?php
	include('is_logged.php');
	
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
		// $aColumns = array('codigo_producto', 'nombre_producto');
		 $sTable = "products,und";
		$sWhere="";
		 $sWhere.=" WHERE products.und_pro=und.id_und";
		if ( $_GET['q'] != "" and $_GET['q1'] == "")
		{
			$sWhere.= " and  (products.nombre_producto like '%$q%') ORDER BY  `products`.`nombre_producto` ASC";
		}
                if ( $_GET['q1'] != "" and $_GET['q'] == "")
		{
			$sWhere.= " and  (products.codigo_producto like '%$q1%') ORDER BY  `products`.`codigo_producto` ASC";
		}
                if ( $_GET['q1'] == "" and $_GET['q'] == ""){
                $sWhere=$sWhere." ORDER BY  `products`.`nombre_producto` ASC ";
                }
                //print"$sWhere";
		include 'pagination.php';
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			?>
			<div class="table-responsive">
			  <table class="table" style="color:black;background:white;">
				<tr  class="warning">
                                    
					<th>Código</th>
					<th>Producto</th>
                                        <th>Laboratorio</th>
					<th><span class="pull-right">Cant.</span></th>
					<th><span class="pull-right">Costo</span></th>
                                        <th><span class="pull-right">Stock</span></th>
					<th class='text-center' style="width: 36px;">Agregar</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$id_producto=$row['id_producto'];
					$codigo_producto=$row['codigo_producto'];
					$nombre_producto=$row['nombre_producto'];
                                        $foto=$row['foto1'];
                                        $des1=$row['des1'];
                                        $tienda=$_SESSION['tienda'];
                                        $b=$row["b$tienda"];
                                        $c=$row["c$tienda"];
                                        $precio_venta=$c;
					$precio_venta=number_format($precio_venta,2);
					?>
					<tr style="background-color: #CEE3F6;color:black;">
						
                                                <td><?php echo $codigo_producto; ?></td>
						<td><?php echo $nombre_producto; ?></td>
                                                 <td><?php echo $des1 ?></td>
                                                 
						<td class='col-xs-1'>
						<div class="pull-right">
                                                    <input type="text" class="form-control" style="text-align:right" id="cantidad_<?php echo $id_producto; ?>"   >
						</div>
                                                </td>
						<td class='col-xs-2'>
                                                    <div class="pull-right">
                                                        <input type="text" class="form-control" style="text-align:right" id="precio_venta_<?php echo $id_producto; ?>"  value="<?php echo $precio_venta;?>" >
                                                
                                                    </div>
                                                </td>
                                                <td class='col-xs-2'><div class="pull-right"><input type="text" class="form-control" style="text-align:right" disabled id="stock_<?php echo $id_producto; ?>" value="<?php echo $b;?>"></div></td>
						<td class='text-center'><a class='btn btn-info'href="#" onclick="agregar('<?php echo $id_producto ?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=8><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>