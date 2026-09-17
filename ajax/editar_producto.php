<?php
	include('is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_codigo'])) {
           $errors[] = "Código vacío";
        } 
        

         else if ($_POST['mod_cat']==""){
			$errors[] = "Selecciona la categoria";
		} else if (strlen(trim($_POST['mod_nombre']))<5) {
           $errors[] = "Nombre tiene que tener al menos 5 caracteres";
        }      
          else if (trim($_POST['mod_nombre'])==""){
			$errors[] = "Nombre del producto vacío";
		} 
          else if (trim($_POST['mod_codigo'])==""){
			$errors[] = "Código vacío";
		}      
        else if (empty($_POST['mod_nombre'])){
			$errors[] = "Nombre del producto vacío";
		}  else if (empty($_POST['mod_precio'])){
			$errors[] = "Precio de venta vacío";
		} else if (empty($_POST['mod_costo'])){
			$errors[] = "Precio de costo vacío";
		}
                else if ($_POST['mod_inv']<0){
			$errors[] = "Inventario no valido";
		}
                
                else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_codigo']) &&
			!empty($_POST['mod_nombre']) &&
                        
                        $_POST['mod_cat']!="" &&
			!empty($_POST['mod_precio'])&&
			!empty($_POST['mod_costo'])
		){

		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		include 'barcode.php';


		$nombre=trim(mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES))));

		/*--------------- AGREGADO REGISTRO_SANITARIO --------------*/

		$registrosanitario=trim(mysqli_real_escape_string($con,(strip_tags($_POST["mod_registrosanitario"],ENT_QUOTES))));



                $codigo=trim(mysqli_real_escape_string($con,(strip_tags($_POST["mod_codigo"],ENT_QUOTES))));
		$des1=mysqli_real_escape_string($con,(strip_tags($_POST["mod_des1"],ENT_QUOTES)));
                $des2=mysqli_real_escape_string($con,(strip_tags($_POST["mod_des2"],ENT_QUOTES)));
                $des3=mysqli_real_escape_string($con,(strip_tags($_POST["mod_des3"],ENT_QUOTES)));


               
				




                $barras=mysqli_real_escape_string($con,(strip_tags($_POST["mod_barras"],ENT_QUOTES)));
                $proveedor=mysqli_real_escape_string($con,(strip_tags($_POST["proveedor"],ENT_QUOTES)));
                $mon=$_POST['mod_mon'];
                $min=mysqli_real_escape_string($con,(strip_tags($_POST["mod_min"],ENT_QUOTES)));
                $mon_costo=1;
                $mon_venta=1;
		$precio_venta=floatval($_POST['mod_precio']);
                
                $valor2=floatval($_POST['mod_valor2']);
                $valor3=floatval($_POST['mod_valor3']);
                
                $costo=floatval($_POST['mod_costo']);
                
                $p1=floatval($_POST['mod_precio']);
                $c1=floatval($_POST['mod_costo']);
                
                $p2=floatval($_POST['p2']);
                $c2=floatval($_POST['c2']);
                $p3=floatval($_POST['p3']);
                $c3=floatval($_POST['c3']);
                $d2=floatval($_POST['d2']);
                $d3=floatval($_POST['d3']);
                
                $dolar=1;
                $precio_costo=$costo*$dolar;
                $cat_pro=intval($_POST['mod_cat']);
                $und_pro=intval($_POST['mod_und_pro']);
                $inv=$_POST['mod_inv'];
                $tienda=$_SESSION['tienda'];
                $b="b".$tienda;
                $a="a".$tienda;
                $c="c".$tienda;
		$id_producto=$_POST['mod_id'];
                $barras1="";
                $barras2="";
                $select=mysqli_query($con,"select * from products where id_producto='".$id_producto."'");
                $row7=mysqli_fetch_array($select);
                $user=$_SESSION['user_id'];
                //$motivo=$_POST['motivo'];
                $inv_ini=$row7["b$tienda"];
                if(isset($barras) and strlen($barras)>=2){
                    barcode('codigos/'.$barras.'.png', $barras, 30, 'horizontal', 'code128', true);
                    $barras2="barras='$barras',";
                }
                
                $_SESSION['pag']=$_POST['pagi'];
                date_default_timezone_set('America/Lima');
		$date_added=date("Y-m-d H:i:s");


		/*--------------- AGREGADO REGISTRO_SANITARIO --------------*/
                
		$sql="UPDATE products SET $barras2 cat_pro='".$cat_pro."',blister='$d2',caja='$d3',mon='".$mon."',min='".$min."',nombre_producto='".$nombre."',registro_sanitario='".$registrosanitario."',valor2='".$valor2."',valor3='".$valor3."', codigo_producto='".$codigo."',precio_producto='".$precio_venta."',costo_producto='".$costo."', $a='".$precio_venta."', $c='".$precio_costo."' , des1='".$des1."', des2='".$des2."', des3='".$des3."',$b='".$inv."',mon_costo='".$mon_costo."',mon_venta='".$mon_venta."',und_pro='".$und_pro."',proveedor='".$proveedor."',p1='$c2',p2='$c3' WHERE id_producto='".$id_producto."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Producto ha sido actualizado satisfactoriamente.";
                                
                                $sql1="UPDATE precios SET c2 = '$c2',c1 = '$c1',c3 = '$c3',p2 = '$p2',p1 = '$p1',p3 = '$p3' WHERE id_producto=$id_producto";
                                $query_update1 = mysqli_query($con,$sql1);
                                
                                if($inv<>$inv_ini){
                                   $query_update = mysqli_query($con,"INSERT INTO inventario (id_producto, usuario, fecha,inventario,inv_ini,tienda,motivo) VALUES ('$id_producto','$user','$date_added','$inv','$inv_ini','$tienda','$motivo')");
                                }
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.Codigo Duplicado";
			}
		} else {
			$errors []= "Error desconocido1.";
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