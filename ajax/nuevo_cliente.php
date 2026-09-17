<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre'])) {
           $errors[] = "Nombre vacío";
        }else if (trim($_POST['nombre'])=="") {
           $errors[] = "Nombre vacío";
           
        } else if (strlen(trim($_POST['nombre']))<5) {
           $errors[] = "Nombre tiene que tener al menos 5 caracteres";
        }else if (!empty($_POST['nombre'])){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$doc=mysqli_real_escape_string($con,(strip_tags($_POST["doc"],ENT_QUOTES)));
                $tipo=mysqli_real_escape_string($con,(strip_tags($_POST["tipo"],ENT_QUOTES)));
                if($tipo==2){
                    $doc1=$doc;
                    $dni=0;
                }
                if($tipo==1){
                    $doc1=0;
                    $dni=$doc;
                }
                $documento=$doc;
                $ven=mysqli_real_escape_string($con,(strip_tags($_POST["ven"],ENT_QUOTES)));
                
                
                $telefono=mysqli_real_escape_string($con,(strip_tags($_POST["telefono"],ENT_QUOTES)));
		$email=mysqli_real_escape_string($con,(strip_tags($_POST["email"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));
		
                $departamento=mysqli_real_escape_string($con,(strip_tags($_POST["departamento"],ENT_QUOTES)));
                $provincia=mysqli_real_escape_string($con,(strip_tags($_POST["provincia"],ENT_QUOTES)));
                $distrito=mysqli_real_escape_string($con,(strip_tags($_POST["distrito"],ENT_QUOTES)));
                $cuenta=mysqli_real_escape_string($con,(strip_tags($_POST["cuenta"],ENT_QUOTES)));
                
              
                $tienda1=$_SESSION['tienda'];
                
                $estado=intval($_POST['estado']);
                date_default_timezone_set('America/Lima');
		$date_added=date("Y-m-d H:i:s");
                
                $sql1 = "SELECT * FROM clientes WHERE doc = '" . $doc . "' OR dni = '" . $doc . "';";
                $query_check_user_name = mysqli_query($con,$sql1);
		$query_check_user=mysqli_num_rows($query_check_user_name);
                if ($query_check_user == 1) {
                    $errors[] = "Lo sentimos , el ruc o dni esta registrado.";
                }else{
                    $sql="INSERT INTO clientes (nombre_cliente, telefono_cliente, email_cliente, direccion_cliente, status_cliente, date_added,doc,dni,vendedor,pais,departamento,provincia,distrito,cuenta,tipo1,tienda,users,deuda,debe,documento) VALUES ('$nombre','$telefono','$email','$direccion','$estado','$date_added','$doc1','$dni','$ven','Peru','$departamento','$provincia','$distrito','$cuenta','1','$tienda1','0','0','0','$documento')";
                    $query_new_insert = mysqli_query($con,$sql);
                            if ($query_new_insert){
                                    $messages[] = "Cliente ha sido ingresado satisfactoriamente.";
                            } else{
                                    $errors []= "Cliente duplicado. $sql";
                            }
                    }
                }else {
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