<?php
include('is_logged.php');
        if (empty($_POST['firstname'])){
            $errors[] = "Nombres vacíos";
	}  elseif (empty($_POST['user_name'])) {
            $errors[] = "Nombre de usuario vacío";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $errors[] = "Contraseña vacía";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $errors[] = "la contraseña y la repetición de la contraseña no son lo mismo";
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $errors[] = "La contraseña debe tener como mínimo 6 caracteres";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $errors[] = "Nombre de usuario no puede ser inferior a 2 o más de 64 caracteres";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $errors[] = "Nombre de usuario no encaja en el esquema de nombre: Sólo aZ y los números están permitidos , de 2 a 64 caracteres";
        } 
        elseif (
            !empty($_POST['user_name'])
            && !empty($_POST['firstname'])	
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            require_once ("../config/db.php");
            require_once ("../config/conexion.php");	
                $firstname = trim(mysqli_real_escape_string($con,(strip_tags($_POST["firstname"],ENT_QUOTES))));
		$user_name = trim(mysqli_real_escape_string($con,(strip_tags($_POST["user_name"],ENT_QUOTES))));
                $user_email = mysqli_real_escape_string($con,(strip_tags($_POST["user_email"],ENT_QUOTES)));
		$user_password = $_POST['user_password_new'];              
                $dni = $_POST['dni'];
                $domicilio = $_POST['domicilio'];
                $telefono = $_POST['telefono'];
                date_default_timezone_set('America/Lima');
		$date_added=date("Y-m-d H:i:s");
          	$tienda1=$_SESSION['tienda'];
                $c1= 0;               
                $c2 = 0;                  
                $c3 = 0;                  
                $c4 = 0; 
                $c5 = 0;    
                $c6 = 0; 
                $c7 = 0; 
                $c8 = 0; 
                $c9 = 0; 
                $c10 = 0; 
                $c11 = 0; 
                $c12 = 0; 
                $c13 = 0; 
                $c14 = 0; 
                $c15 = 0; 
                $c16 = 0; 
                $c17 = 0; 
                $c18 = 0; 
                $c19 = 0;
                $c20 = 0;
                $c21 = 0;
                $c22 = 0;
                $c23 = 0;
                $c24 =0;
                $c25 = 0;
                $c26 = 0;
                $c27 = 0;
                $c28 = 0;
                $c29 = 0;
                $c30 = 0;
                $c31 = 0;
                $c32 = 0;
                $c33 = 0;
                $c34 = 0;
                $c35 = 0;
                $c36 = 0;
                $c37 = 0;
                $c38 = 0;
                $c39 = 0;
                $c40 = 0;
                $c41 = 0;
                $c42 = 0;
                $c43 = 0;
                $c44 = 1;
                $c45 = 0;
                $c46 = 0;
                $c47 = 0;
                $c48 = 0;
                $c49 = 0;
                $c50 = 0;
                $c51 = 0;
                $c52 = 0;
                $c53 = 0;
                $c54 = 0;
                $c55 = 0;
                $c56 = 0;
                $c57 = 0;
                $c58 = 0;
                $c59 = 0;
                $c60 = 0;
                $hora="0";
                $c=$c1.".".$c2.".".$c3.".".$c4.".".$c5.".".$c6.".".$c7.".".$c8.".".$c9.".".$c10.".".$c11.".".$c12.".".$c13.".".$c14.".".$c15.".".$c16.".".$c17.".".$c18.".".$c19.".".$c20.".".$c21.".".$c22.".".$c23.".".$c24.".".$c25.".".$c26.".".$c27.".".$c28.".".$c29.".".$c30.".".$c31.".".$c32.".".$c33.".".$c34.".".$c35.".".$c36.".".$c37.".".$c38.".".$c39.".".$c40.".".$c41.".".$c42.".".$c43.".".$c44.".".$c45.".".$c46.".".$c47.".".$c48.".".$c49.".".$c50.".".$c51.".".$c52.".".$c53.".".$c54.".".$c55.".".$c56.".".$c57.".".$c58.".".$c59.".".$c60;
                $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' or nombres = '" . $firstname . "'";
                $query_check_user_name = mysqli_query($con,$sql);
		$query_check_user=mysqli_num_rows($query_check_user_name);
                if ($query_check_user >= 1) {
                    $errors[] = "Lo sentimos , el nombre de usuario el nombre ya está en uso.";
                }else{
                    $sql = "INSERT INTO users (nombres, clave, user_name,hora, user_email, date_added,accesos,dni,domicilio,telefono,sucursal,foto)
                            VALUES('".$firstname."','".$user_password."','".$user_name."','".$hora."','".$user_email."','".$date_added."','".$c."','".$dni."','".$domicilio."','".$telefono."','".$tienda1."','user.png');";
                    $query_new_user_insert = mysqli_query($con,$sql);

                    if ($query_new_user_insert) {
                        $id=mysqli_insert_id($con);
                        $sql1 = "INSERT INTO clientes (nombre_cliente, telefono_cliente, email_cliente, direccion_cliente, status_cliente, date_added,doc,dni,vendedor,pais,departamento,provincia,distrito,cuenta,tipo1,tienda,users,deuda,debe,documento) VALUES ('$firstname','$telefono','$user_email','$direccion','1','$date_added','0','$dni','$id','Peru','','','','','0','1','0','0','0','$dni')";
                        $query_new_user_insert1 = mysqli_query($con,$sql1);
                        
                        $messages[] = "La cuenta ha sido creada con éxito.";
                    } else {
                        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
                    }
                } 
        } else {
            $errors[] = "Un error desconocido ocurrió.";
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