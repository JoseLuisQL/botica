<?php
	include('is_logged.php');
	
	if (empty($_POST['nombre'])) {
           $errors[] = "Pago vacío";
        } else if (!empty($_POST['pago'])){
		
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
                $ven_com=mysqli_real_escape_string($con,(strip_tags($_POST["ven_com"],ENT_QUOTES)));
                $cliente=mysqli_real_escape_string($con,(strip_tags($_POST["cliente"],ENT_QUOTES)));
		$rr=2;
                //$vendedor=mysqli_real_escape_string($con,(strip_tags($_POST["vendedor"],ENT_QUOTES)));
                $condiciones=mysqli_real_escape_string($con,(strip_tags($_POST["condiciones"],ENT_QUOTES)));
                $pago=mysqli_real_escape_string($con,(strip_tags($_POST["pago"],ENT_QUOTES)));
                $estado_factura=mysqli_real_escape_string($con,(strip_tags($_POST["estado_factura"],ENT_QUOTES)));
                $numero_factura=mysqli_real_escape_string($con,(strip_tags($_POST["numero_factura"],ENT_QUOTES)));
                $obs=mysqli_real_escape_string($con,(strip_tags($_POST["obs"],ENT_QUOTES)));
                $moneda=1;
                $tienda=$_SESSION['tienda'];
                $vendedor=$_SESSION['user_id'];
                date_default_timezone_set('America/Lima');
		$date_added=date("Y-m-d H:i:s");
                
                $fecha333='2018-11-11';
                $sql3="select * from caja where tienda=$tienda and cierre=0 and usuario_inicio=$vendedor ORDER BY caja.id_caja DESC LIMIT 0 , 1";
                $rw3=mysqli_query($con,$sql3);//recuperando el registro
                $rs3=mysqli_fetch_array($rw3);//trasformar el registro en un vector asociativo
                $fecha333=$rs3["fecha"];
                $turno=$rs3["turno"];
                
		$sql="INSERT INTO facturas (numero_factura,fecha_factura,cod_hash,doc_mod,id_cliente,baja,id_vendedor,condiciones,total_venta,deuda_total,estado_factura,tienda,ven_com,activo,servicio,moneda,nombre,obs,cuenta1,fec_eli,dias,folio,des,aceptado,resumen,motivo,tipo,turno) VALUES ('$numero_factura','$date_added','0','0','$cliente','0','$vendedor','$condiciones','$pago','0','$estado_factura','$tienda','$ven_com','1','$rr','1','$nombre','$obs','0','2018-11-11','0','0','0','aceptado','0','','0','$turno')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Pago ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Pago duplicado.";
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