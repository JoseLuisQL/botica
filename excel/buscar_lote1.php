<?php
    include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//$id_producto=$_SESSION['id_producto'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	header("Content-type: application/vnd.ms-excel" ) ; 
        header("Content-Disposition: attachment; filename=lote.xls" ) ;
	
	//if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
          
          
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
                $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
                $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
                date_default_timezone_set('America/Lima');
                $fecha = date('Y-m-d');
                $nuevafecha = strtotime ( "+$q1 day" , strtotime ( $fecha ) ) ;
                $nuevafecha1 = date ( 'Y-m-d' , $nuevafecha );
                $tienda=$_SESSION["tienda"];
                $nuevafecha2 = date ( 'Y-m-d');
                
                
		$sTable = "lote,products";
		$sWhere = "";
		$sWhere.=" WHERE products.id_producto=lote.id_producto and lote.tienda=$tienda";
                if ( $_GET['q'] != "" )
		{
			$sWhere .= " and (lote.lote LIKE '%".$q."%')";
			
		}
                 if ( $_GET['q1'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(fec_vto, '%Y-%m-%d')<='$nuevafecha1' ) and  (DATE_FORMAT(fec_vto, '%Y-%m-%d')>'$nuevafecha2' ) and lote.final>0";
		}
                if ( $_GET['q2'] != "" and $q2==1)
		{
		$sWhere.= " and  (DATE_FORMAT(fec_vto, '%Y-%m-%d')<='$fecha' ) and lote.final>0";
		}
                
                if ( $_GET['q2'] != "" and $q2==0)
		{
		$sWhere.= " and  (DATE_FORMAT(fec_vto, '%Y-%m-%d')>'$fecha' )";
		}
                ////else
		//{
		//$sWhere.= " and  (DATE_FORMAT(fec_vto, '%Y-%m-%d')<='$fecha' )";
		//}
                //print"$sWhere";
		$sWhere.=" ORDER BY lote.fec_vto ASC";
		
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere ";
		$query = mysqli_query($con, $sql);
                
                
                //print"$sql";
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
                            <table class="table" style="color:black;">
				<tr  style="background-color:<?php echo tablas;?>;color:white; ">
					<th>Lote</th>
                                        <th>Producto</th>
                                        <th>Fecha Fabricacion</th>
					<th>Fecha Vencimiento</th>
                                        
					<th>Inv Inicial</th>
                                        <th>Inv Final</th>
                                        
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_lote=$row['id_lote'];
						$fec_vto=$fecha=date("d/m/Y", strtotime($row['fec_vto']));
                                                $color="";
                                                $fec_vto1=date("Y-m-d", strtotime($row['fec_vto']));
                                                
                                                $nombre_producto=$row['nombre_producto'];
                                                //$fec_fab=$row['fec_fab'];
                                                $fec_fab=$fecha=date("d/m/Y", strtotime($row['fec_fab']));
                                                $lote=$row['lote'];
                                                $inicial=$row['inicial'];
                                                $final=$row['final'];
                                                
                                                if(strtotime($fec_vto1)<=strtotime($fecha) and $final>0){
                                                    $color="red";
                                                   // echo strtotime($fec_vto1);
                                                    //print"<br>";
                                                  //  echo strtotime($fecha);
                                                }
                                                if(strtotime($fec_vto1)<=strtotime($nuevafecha1) and strtotime($fec_vto1)>strtotime($fecha) and $final>0){
                                                    $color="orange";
                                                   // echo strtotime($fec_vto1);
                                                    //print"<br>";
                                                  //  echo strtotime($fecha);
                                                }
                                                //if($fec_vto>=$fecha and $final>0){
                                                //    $color="#FAAC58";
                                                //}
					?>
					
					<input type="hidden" value="<?php echo $lote;?>" id="lote<?php echo $id_lote;?>">
					
                                        <tr style="background:<?php echo $color;?>">
						
						<td><?php echo $lote; ?></td>
                                                <td><?php echo $nombre_producto; ?></td>
                                                <td><?php echo $fec_fab; ?></td>
                                                <td><?php echo $fec_vto; ?></td>
                                                <td><?php echo $inicial; ?></td>
                                                <td><?php echo $final; ?></td>
                                                
					
                                           
					</tr>
					<?php
				}
				?>
				
			  </table>
			</div>
			<?php
		}
	//}
?>