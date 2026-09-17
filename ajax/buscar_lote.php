<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	$id_producto=$_SESSION['id_producto'];
        $tienda=$_SESSION['tienda'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_lote=intval($_GET['id']);
		$query=mysqli_query($con, "select * from lote1 where id_lote='".$id_lote."' and id_detalle>0");
		$count=mysqli_num_rows($query);
                
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM lote WHERE id_lote='".$id_lote."'" )){
			
                          $delete2=mysqli_query($con,"DELETE FROM lote1 WHERE id_lote='".$id_lote."' and id_detalle=0"); 
                            ?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar. 
			</div>
			<?php
		}
	
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
          
          
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES))); 
                $q3 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q3'], ENT_QUOTES))); 
                $q4 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q4'], ENT_QUOTES)));
		 $sTable = "lote,products";
		 $sWhere = "";
		$sWhere.=" WHERE products.id_producto=lote.id_producto and lote.id_producto=$id_producto and lote.tienda=$tienda";
                if ( $_GET['q'] != "" )
		{
			$sWhere .= " and (lote.lote LIKE '%".$q."%')";
			
		}
                if ( $_GET['q2'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(lote.fec_vto, '%Y-%m-%d')>='$q2' )";
		}
                if ( $_GET['q3'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(lote.fec_vto, '%Y-%m-%d')<='$q3')";
		}
                if ( $_GET['q4'] != "" )
		{
		$sWhere.= " and  (lote.final$q4)";
		}
		$sWhere.=" ORDER BY lote.fec_vto ASC";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './pack.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
                //print"$sql";
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table" style="color:black;">
				<tr  style="background-color:<?php echo tablas;?>;color:white; ">
					<th>Lote</th>
                                        <th>Fecha Fabricacion</th>
					<th>Fecha Vencimiento</th>
                                        
					<th>Inv Inicial</th>
                                        <th>Inv Final</th>
                                        <th>Acciones</th>
				</tr>
				<?php
                                
				while ($row=mysqli_fetch_array($query)){
						$id_lote=$row['id_lote'];
                                                $id_producto=$row['id_producto'];
						$fec_vto=$row['fec_vto'];
                                                //$fec_fab=$row['fec_fab'];
                                                $fec_fab=$row['fec_fab'];
                                                $lote=$row['lote'];
                                                $inicial=$row['inicial'];
                                                $final=$row['final'];
					?>
					
					<input type="hidden" value="<?php echo $lote;?>" id="lote<?php echo $id_lote;?>">
                                        <input type="hidden" value="<?php echo $fec_vto;?>" id="fec_vto<?php echo $id_lote;?>">
                                        <input type="hidden" value="<?php echo $fec_fab;?>" id="fec_fab<?php echo $id_lote;?>">
                                        <input type="hidden" value="<?php echo $final;?>" id="final<?php echo $id_lote;?>">
                                        
					 
                                         <input type="hidden" value="<?php echo $id_producto;?>" id="id_producto<?php echo $id_lote;?>">
                                        <tr>
						
						<td><?php echo $lote; ?></td>
                                                <td><?php echo $fec_fab; ?></td>
                                                <td><?php echo $fec_vto; ?></td>
                                                <td><?php echo round($inicial,2); ?></td>
                                                <td><?php echo round($final,2); ?></td>
                                                <td><span class="pull-right">
                                                                               
					<!--<a href="#" class='btn btn-warning btn-xs' title='Editar' onclick="obtener_datos('<?php echo $id_lote;?>');" data-toggle="modal" data-target="#myModal2" readonly><i class="fa fa-pencil"></i>Editar</a> -->
                                        <a href="#" class='btn btn-danger btn-xs' title='Borrar' onclick="eliminar('<?php echo $id_lote; ?>')"><i class="glyphicon glyphicon-trash"></i> Borrar</a></span>
                                         <a href="#" class='btn btn-warning btn-xs' title='Editar' onclick="obtener_datos('<?php echo $id_lote;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					   
                                                </td>
					
                                           
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=6><span class="pull-right"><?PHP
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>