<?php


// include the configs / constants for the database connection
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
   
   
   include('menu.php');
  
   $sql1="select * from users where user_id=$_SESSION[user_id]";
    $rw1= mysqli_query($con, $sql1);//recuperando el registro
    $rs1= mysqli_fetch_array($rw1);
    $modulo=$rs1["accesos"];
    $b = explode(".", $modulo);
   $c=0;
  if($b[47]==1){
        $_SESSION['tienda']=5; 
        $c=1;
        } 
  if($b[46]==1){
        $_SESSION['tienda']=4; 
        $c=1;
        }
        
  if($b[45]==1){
        $_SESSION['tienda']=3; 
        $c=1;
        }
  if($b[44]==1){
        $_SESSION['tienda']=2;
        $c=1;
        }
        
   if($b[43]==1){
        $_SESSION['tienda']=1;  
        $c=1;
        }
        
       
   if($c>0){
     $_SESSION['doc_ventas']=2;
     
     
 $_SESSION['tipo']=0;
     $_SESSION['tabla']=1;
   $_SESSION['servicio1']="0";
       header("location: resumen.php");   
   }else{
     header("location: login.php");   
   }
   
    
    

} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    ?>
	<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Sistema de Facturación Online, Tienda Online y Facturación Electrónica.</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <!-- CSS  -->
   <link href="css/login.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
 <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="img/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form method="post" accept-charset="utf-8" action="login.php" name="loginform" autocomplete="off" role="form" class="form-signin">
			<?php
				// show potential errors / feedback (from login object)
				if (isset($login)) {
					if ($login->errors) {
						?>
						<div class="alert alert-danger alert-dismissible" role="alert">
						    <strong>Error!</strong> 
						
						<?php 
						foreach ($login->errors as $error) {
							echo $error;
						}
						?>
						</div>
						<?php
					}
					if ($login->messages) {
						?>
						<div class="alert alert-success alert-dismissible" role="alert">
						    <strong>Aviso!</strong>
						<?php
						foreach ($login->messages as $message) {
							echo $message;
						}
						?>
						</div> 
						<?php 
					}
				}
				?>
                <span id="reauth-email" class="reauth-email"></span>
                Usuario:
                <input class="form-control" placeholder="Usuario" name="user_name" type="text" value="" autofocus="" required>
                Contraseña:
                <input class="form-control" placeholder="Contraseña" name="user_password" type="password" value="" autocomplete="off" required>
                <button type="submit" class="btn btn-lg btn-success btn-block btn-signin" name="login" id="submit">Iniciar Sesión</button>
            </form><!-- /form -->
            
        </div><!-- /card-container -->
    </div><!-- /container -->
  </body>
</html>

	<?php
}


