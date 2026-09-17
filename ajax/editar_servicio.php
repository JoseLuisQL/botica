<?php
	include('is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_nom_servicio'])) {
           $errors[] = "Servicio vacío";
        } else if (trim($_POST['mod_nom_servicio'])=="") {
           $errors[] = "Servicio vacío";
        }else if (trim($_POST['mod_cod_servicio'])=="") {
           $errors[] = "Codigo vacío";
        }else if (strlen(trim($_POST['mod_nom_servicio']))<5) {
           $errors[] = "Nombre tiene que tener al menos 5 caracteres";
        }
        
        else if ($_POST['mod_cod_servicio']==""){
			$errors[] = "Selecciona el codigo de servicio";
		}
        
                else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_nom_servicio']) &&
			!empty($_POST['mod_cod_servicio']) 
                        
                       
		){

		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		
		$nom_servicio=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nom_servicio"],ENT_QUOTES)));
                $cod_servicio=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cod_servicio"],ENT_QUOTES)));
		
		$pre_servicio=floatval($_POST['mod_pre_servicio']);
                
                
		$id_servicio=$_POST['mod_id'];
		$sql="UPDATE servicios SET nom_servicio='".$nom_servicio."',cod_servicio='".$cod_servicio."', pre_servicio='".$pre_servicio."' WHERE id_servicio='".$id_servicio."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Servicio ha sido actualizado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.Codigo Duplicado ";
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