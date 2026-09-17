<?php
        include('is_logged.php');
	$ruc=trim($_POST["ruc"],ENT_QUOTES);
        $razon_social="";
	$data = @file_get_contents("https://dniruc.apisperu.com/api/v1/ruc/$ruc?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNnX3ZlbGF6Y29AaG90bWFpbC5jb20ifQ.RugrMlW0IAwCuAcnHWucHbvpwmt9QA0ebm4CIJ11rwc");
        $info = json_decode($data, true);
        $razon_social = $info['razonSocial'];
	if (empty($_POST['nombre'])) {
           $errors[] = "Sucursal vacía";
        } else if (empty(trim($_POST['nombre']))){
			$errors[] = "Nombre de la sucursal vacía";
		} else if (trim($_POST['nombre'])==""){
			$errors[] = "Ruc erroneo";
		} 
                else if (
			!empty($_POST['nombre']) 
		){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$nombre=trim(mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES))));
		$ruc=trim(mysqli_real_escape_string($con,(strip_tags($_POST["ruc"],ENT_QUOTES))));
		$direccion=trim(mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES))));
                $correo=mysqli_real_escape_string($con,(strip_tags($_POST["correo"],ENT_QUOTES)));
                $telefono=mysqli_real_escape_string($con,(strip_tags($_POST["telefono"],ENT_QUOTES)));
                $departamento=trim(mysqli_real_escape_string($con,(strip_tags($_POST["departamento"],ENT_QUOTES))));
                $provincia=trim(mysqli_real_escape_string($con,(strip_tags($_POST["provincia"],ENT_QUOTES))));
                $distrito=trim(mysqli_real_escape_string($con,(strip_tags($_POST["distrito"],ENT_QUOTES))));
                $ubigeo=mysqli_real_escape_string($con,(strip_tags($_POST["ubigeo"],ENT_QUOTES)));
                $tienda=mysqli_query($con,"select * from sucursal ORDER BY  `sucursal`.`tienda` DESC ");
                $row1=mysqli_fetch_array($tienda);
                $tienda1=$row1["tienda"]+1;
                if($tienda1<=7){
                $sql="INSERT INTO sucursal (tienda,nombre,ruc,direccion,correo,telefono,foto,ubigeo,caja,dep_suc,pro_suc,dis_suc) VALUES ('$tienda1','$nombre','$ruc','$direccion','$correo','$telefono','logo.jpg','$ubigeo','0','$departamento','$provincia','$distrito')";
                $query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$sql1="UPDATE sucursal SET ruc='".$ruc."'";
                                $query_update = mysqli_query($con,$sql1);
                                $messages[] = "Sucursal ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Sucursal duplicada.";
			}
		}else{
                    $errors []= "Esta permitido maximo 7 sucursales consulte con el programador para agregar una sucursal mas.";
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