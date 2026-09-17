<?php
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$servicio=$_GET['id'];
		$query=mysqli_query($con, "select * from detalle_factura where id_producto='".$servicio."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM servicios WHERE nom_servicio='".$servicio."'")){
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
			  <strong>Error!</strong> No se puede eliminar.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  servicio. Existen datos vinculadas a éste servicio. 
			</div>
			<?php
		}
        }
	if($action == 'ajax'){
	
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $aColumns = array('cod_servicio', 'nom_servicio');//Columnas de busqueda
        $sTable = "servicios";
        $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by id_servicio desc";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
                if($q==""){
                $count_query= mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable WHERE id_servicio>0 $sWhere");}
                else
                {
                $count_query= mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");    
                }
               
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './servicio.php';
		if($q==""){
                $sql="SELECT * FROM  $sTable WHERE id_servicio>0 $sWhere LIMIT $offset,$per_page";}
                else{  
                $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";}
		$query = mysqli_query($con, $sql);
                
		if ($numrows>0){
			?>
			<div class="table-responsive">
                           
			 <table id="example" class="display nowrap" style="width:100%;color:black;">
                            <thead>
				<tr style="background-color:<?php echo tablas;?>;color:white; ">
                                        
					<th>Código</th>
					<th>Nombre del servicio</th>
                                        
                                        <th>Precio del servicio<br>S/.</th>
					
                                        <th class='text-right'>Acciones</th>
				</tr>
                                </thead>
				<?php
                                $i=0;
				while ($row=mysqli_fetch_array($query)){
					
                                            
                                           
                                            $id_servicio=$row['id_servicio'];
                                            $nom_servicio=$row['nom_servicio'];
                                            $cod_servicio=$row['cod_servicio'];
                                            $pre_servicio=$row['pre_servicio'];
                                            
                                             
					?>
                                        <tr>
                                        <input type="hidden" value="<?php echo $nom_servicio?>" id="nom_servicio<?php echo $id_servicio;?>">
					<input type="hidden" value="<?php echo $cod_servicio;?>" id="cod_servicio<?php echo $id_servicio;?>">
					<input type="hidden" value="<?php echo $pre_servicio;?>" id="pre_servicio<?php echo $id_servicio;?>">
                                       
                                            	
                                            
                                            <td><?php echo $cod_servicio; ?></td>
                                            <td><?php echo $nom_servicio; ?></td>
                                            <td><?php echo $pre_servicio; ?></td>
                                            
                                         <td><span class="pull-right">
                                                <a href="#" class='btn btn-warning btn-xs' title='Editar servicio' onclick="obtener_datos('<?php echo $id_servicio;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil"></i></a> 
                                                <a href="#" class="btn btn-danger btn-xs" title='Borrar servicio' onclick="eliminar('<?php echo $nom_servicio; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
                                            
					</tr>
					<?php
                                    
                                }
				?>
				<tr>
					<td colspan=5><span class="pull-right"><?PHP
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>

			</div>
			<?php
		}
	}
?>

