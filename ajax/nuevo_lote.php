<?php
        include('is_logged.php');
	
	if (empty($_POST['lote'])) {
           $errors[] = "Lote vacía";
        } else if (empty($_POST['lote'])){
			$errors[] = "Lote vacía";
		} 
                else if (
			!empty($_POST['lote']) 
			
		){
		
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		//$id_producto1=$_POST["id_producto1"];
                $fec_vto=$_POST["fec_vto"];
                $fec_fab=$_POST["fec_fab"];
                $cantidad=$_POST["cantidad"];
                $lote=trim($_POST["lote"]);
                $id_producto=$_SESSION['id_producto'];
                $tienda=$_SESSION['tienda'];
                
                $count_query   = mysqli_query($con, "SELECT sum(b$tienda) AS numrows FROM products where id_producto=$id_producto");    
		$row1= mysqli_fetch_array($count_query);
                $numrows = $row1['numrows'];
                
                $count_query1   = mysqli_query($con, "SELECT sum(final) AS numrows1 FROM lote where id_producto=$id_producto and tienda=$tienda");    
		$row2= mysqli_fetch_array($count_query1);
                $numrows1 = $row2['numrows1'];
                date_default_timezone_set('America/Lima');
		$date_added=date("Y-m-d H:i:s");
                if($cantidad>$numrows-$numrows1){
                    $lote1="Cantidad excede stock total lote";
                }
                
                $query=mysqli_query($con, "select * from lote where lote='$lote' and id_producto='".$id_producto."'");
		$count=mysqli_num_rows($query);
                if($count==0 and $cantidad<=$numrows-$numrows1){
		$sql="INSERT INTO lote (id_producto,fec_vto,fec_fab,lote,tienda,inicial,final) VALUES ('$id_producto','$fec_vto','$fec_fab','$lote','$tienda','$cantidad','$cantidad')";
		$query_new_insert = mysqli_query($con,$sql);
                $id_lote=mysqli_insert_id($con);
                $insert_lote1=mysqli_query($con, "INSERT INTO lote1 VALUES (NULL,'$id_lote','$date_added','0','$cantidad','0','0')");
		//$query_new_insert1 = mysqli_query($con,$sql1);
                
			if ($query_new_insert){
				$messages[] = "Lote ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Error. ";
			}
		}else{
				$errors []= "Error. ";
			}
                        
                } else {
			print"$sql";
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