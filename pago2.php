<?php
ob_start();
include('ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['spTotal'])) {
           $errors[] = "Pago vacío";
        } else if ($_POST['spTotal']>$_POST['mod_deuda'] && $_POST['mod_pago']>0){
			$errors[] = "La cantidad a pagar debe ser menor a la deuda y positiva";
		} 
        else if (!empty($_POST['spTotal'])){
		
                $id=$_POST["mod_id"];
                $numero_factura=$_POST["numero_factura"];
                $estado_factura=$_POST["estado_factura"];
		$pago=$_POST["spTotal"];
                $pago1=$_POST["spTotal"];
                $obs=$_POST["mod_obs"];
                $condiciones=$_POST["condiciones"];
                $deuda=$_POST["mod_deuda"];
                $t=$_POST["cantidad"];   
                $mon1=1;
                $g = array();
                $f = array();
                for($i =1; $i<=$t; $i++){
                    $f[$i]=$_POST["deuda$i"];
                    $g[$i]=$_POST["id$i"];
                }
                for ($i =1; $i <=$t; $i++ ){
                if($pago-$f[$i]>0){        
                $dml = "UPDATE facturas SET cuenta1=cuenta1+$f[$i] WHERE id_factura=$g[$i] ORDER BY  `facturas`.`id_factura` ASC";
                if(!mysqli_query($con,$dml)){
                    die("No se pudo actualizar12..");
                }else{
                    header("location:pagos.php");
            
                }
                }
                if($pago-$f[$i]<=0 and $pago>0){        
                $dml = "UPDATE facturas SET cuenta1=cuenta1+$pago WHERE id_factura=$g[$i] ORDER BY  `facturas`.`id_factura` ASC";
                if(!mysqli_query($con,$dml)){
                    die("No se pudo actualizar12..");
                }else{
                    header("location:pagos.php");
                }
        
                }
                $pago=$pago-$f[$i];
                }           
  
                $cliente=$_POST["mod_cliente"];
                $vendedor=$_SESSION['user_id'];
                $tienda=$_SESSION['tienda'];
                date_default_timezone_set('America/Lima');
		$date_added=date("Y-m-d H:i:s");
                $cuenta="Se pagan las compras";
                
                
                $sql3="select * from caja where tienda=$tienda and cierre=0 and usuario_inicio=$vendedor ORDER BY caja.id_caja DESC LIMIT 0 , 1";
                $rw3=mysqli_query($con,$sql3);//recuperando el registro
                $rs3=mysqli_fetch_array($rw3);//trasformar el registro en un vector asociativo
                
                $turno=$rs3["turno"];
                
                
                $dato=mysqli_query($con, "UPDATE clientes SET debe=debe-$pago1 WHERE id_cliente=$id");
		$sql="INSERT INTO facturas (numero_factura,fecha_factura,cod_hash,doc_mod,id_cliente,baja,id_vendedor,condiciones,total_venta,deuda_total,estado_factura,tienda,ven_com,activo,servicio,moneda,nombre,obs,cuenta1,fec_eli,dias,folio,des,aceptado,resumen,motivo,tipo,turno) VALUES ('$numero_factura','$date_added','0','0','$id','0','$vendedor','$condiciones','$pago1','0','$estado_factura','$tienda','4','1','$deuda','$mon1','$cuenta','$obs','0','2018-11-11','0','0','0','','0','','0','$turno')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$sql2="select * from facturas ORDER BY  `facturas`.`id_factura` DESC limit 0,1";
                                $rs2=mysqli_query($con,$sql2);
                                $row2=mysqli_fetch_array($rs2);
                                $id_factura=$row2["id_factura"];
                                
                                for ($i=1;$i<=$t;$i++ ){
                                  if($pago1-$f[$i]>0){ 
                                    $dml1=mysqli_query($con,"INSERT INTO pagos (id_pago,id_factura,pago) VALUES ('$id_factura','$g[$i]','$f[$i]')");
                                    
                                    
                                  }
                                  if($pago1-$f[$i]<=0 and $pago1>0){
                                      $dml1=mysqli_query($con,"INSERT INTO pagos (id_pago,id_factura,pago) VALUES ('$id_factura','$g[$i]','$pago1')");
                                      
                                  }
                                  $pago1=$pago1-$f[$i];
                               }
                                
                                
                                $messages[] = "Pago ha sido ingresado satisfactoriamente.";
                                header("location:pagos.php");
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
ob_end_flush(); 
?>