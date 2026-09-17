<?php
	include('is_logged.php');
        $ruc=trim($_POST["mod_ruc"],ENT_QUOTES);
        $razon_social="";
	$data = @file_get_contents("https://dniruc.apisperu.com/api/v1/ruc/$ruc?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNnX3ZlbGF6Y29AaG90bWFpbC5jb20ifQ.RugrMlW0IAwCuAcnHWucHbvpwmt9QA0ebm4CIJ11rwc");
        $info = json_decode($data, true);
        $razon_social = $info['razonSocial'];

        if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty(trim($_POST['mod_nombre']))){
			$errors[] = "Nombre de la sucursal vacía";
		} else if (trim($_POST['mod_nombre'])==""){
			$errors[] = "Ruc erroneo";
		} 
                else if (
			
			!empty($_POST['mod_nombre'])
		){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$nombre=trim(mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES))));
		$ruc=trim(mysqli_real_escape_string($con,(strip_tags($_POST["mod_ruc"],ENT_QUOTES))));
		$direccion=trim(mysqli_real_escape_string($con,(strip_tags($_POST["mod_direccion"],ENT_QUOTES))));
                $correo=mysqli_real_escape_string($con,(strip_tags($_POST["mod_correo"],ENT_QUOTES)));
                $telefono=mysqli_real_escape_string($con,(strip_tags($_POST["mod_telefono"],ENT_QUOTES)));
                $ubigeo=mysqli_real_escape_string($con,(strip_tags($_POST["mod_ubigeo"],ENT_QUOTES)));
                
                $departamento=trim(mysqli_real_escape_string($con,(strip_tags($_POST["mod_departamento"],ENT_QUOTES))));
                $provincia=trim(mysqli_real_escape_string($con,(strip_tags($_POST["mod_provincia"],ENT_QUOTES))));
                $distrito=trim(mysqli_real_escape_string($con,(strip_tags($_POST["mod_distrito"],ENT_QUOTES))));
                
		$id_sucursal=$_POST['mod_id'];
		$sql="UPDATE sucursal SET nombre='".$nombre."',ruc='".$ruc."',dep_suc='".$departamento."',pro_suc='".$provincia."',dis_suc='".$distrito."',direccion='".$direccion."',correo='".$correo."',telefono='".$telefono."',ubigeo='".$ubigeo."' WHERE id_sucursal='".$id_sucursal."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
                            
                            $sql1="UPDATE sucursal SET ruc='".$ruc."'";
                            $query_update = mysqli_query($con,$sql1);
                            
                            $messages[] = "Producto ha sido actualizado satisfactoriamente.";
			} else{
                            $errors []= "Categoria duplicada.";
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