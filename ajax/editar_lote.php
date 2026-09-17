<?php
	include('is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['mod_cantidad'])){
			$errors[] = "Cantidad vacía";
	} 
        else if (
            
            !empty($_POST['mod_cantidad'])
		){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		date_default_timezone_set('America/Lima');
                $tienda=$_SESSION['tienda'];
		$cantidad=$_POST['mod_cantidad'];
                $final=$_POST['mod_final'];
                $lote=$_POST['mod_lote'];
                $fecha2=$_POST['mod_fec_vto'];
                $fecha7=$_POST['mod_fec_fab'];
                $id_producto=$_POST['mod_id_producto'];
                $resto=$cantidad-$final;
                $resto1=$cantidad-$final;
                if($resto>=0){
                    $sig="+";
                    $des=2;
                }else{
                    $sig="-";
                    $resto=-$resto;
                    $des=1;
                }
                
                $count_query1   = mysqli_query($con, "SELECT sum(final) AS numrows1 FROM lote where id_producto=$id_producto and tienda=$tienda");    
		$row2= mysqli_fetch_array($count_query1);
                $numrows1 = $row2['numrows1'];
                
                $count_query   = mysqli_query($con, "SELECT sum(b$tienda) AS numrows FROM products where id_producto=$id_producto");    
		$row1= mysqli_fetch_array($count_query);
                $numrows = $row1['numrows'];
                
                $id_lote=$_POST['mod_id'];
                $fecha=date("Y-m-d  H:i:s" );
                if($numrows1+$resto1<=$numrows){
                
                if($resto1<>0) {   
                $insert_detail=mysqli_query($con, "INSERT INTO lote1 VALUES (NULL,'$id_lote','$fecha','0','$resto','0','$des')");
                   // $lote1=mysqli_query($con, "UPDATE lote SET final=final-$cant2 WHERE id_lote=$id_lote");
                }
		$sql="UPDATE lote SET final=$cantidad,fec_fab='$fecha7',fec_vto='$fecha2',lote='$lote' WHERE id_lote=$id_lote";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Ha sido actualizado satisfactoriamente.";
			} else{
                            $errors []= "Duplicado.";
			}
		}else{
				$errors []= "Error";
			}
                        
                } else {
			$errors []= "Error desconocido.";
		}
                        if (isset($errors)){
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>