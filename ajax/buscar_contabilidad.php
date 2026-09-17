<?php
 include('is_logged.php');
?>
<style>
table tr:nth-child(odd) {background-color: #FBF8EF;}
table tr:nth-child(even) {background-color: #EFFBF5;}
#valor1 {             
border-bottom: 2px solid #F5ECCE;
}  
#valor1:hover {             
background-color: white;
border-bottom: 2px solid #A9E2F3;
} 

    
.dt-button.red {
        color: black;
        
        background:red;
    }
 
    .dt-button.orange {
        color: black;
        background:orange;
    }
 
    .dt-button.green {
        color: black;
        background:green;
    }
    
    .dt-button.green1 {
        color: black;
        background:#01DFA5;
    }
    
    .dt-button.green2 {
        color: black;
        background:#2E9AFE;
    }

</style>


<?php
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	$tienda1=$_SESSION['tienda'];
        $usuario=$_SESSION['user_id'];
        date_default_timezone_set('America/Lima');
        $fecha1  = date("Y-m-d H:i:s");
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
                $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
                $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
                $q3 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q3'], ENT_QUOTES)));
                $q4 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q4'], ENT_QUOTES)));
                $q5 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q5'], ENT_QUOTES)));
                $q6 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q6'], ENT_QUOTES)));
                if($q4=="3"){
                    if($q5=="1"){
                        $text2="and ((facturas.ven_com=1 or facturas.ven_com=2) and facturas.estado_factura=1) ";
                    }
                    if($q5=="2"){
                        $text2="and ((facturas.ven_com=1 or facturas.ven_com=2) and facturas.estado_factura=2) ";
                    }
                    if($q5=="3"){
                        $text2="and ((facturas.ven_com=1 and facturas.estado_factura<=2) or (facturas.ven_com=1 and (facturas.estado_factura=5 or facturas.estado_factura=6)) or (facturas.ven_com=2 and facturas.estado_factura<=2))";
                    
                        
                    }
                    if($q5=="5"){
                        $text2="and ((facturas.ven_com=1 or facturas.ven_com=2) and facturas.estado_factura=5) ";
                    }
                    if($q5=="6"){
                        $text2="and ((facturas.ven_com=1 or facturas.ven_com=2) and facturas.estado_factura=6) ";
                    }
                    
                }
                if($q4=="1"){
                    if($q5=="1"){
                        $text2="and (facturas.ven_com=1 and facturas.estado_factura=1) ";
                    }
                    if($q5=="2"){
                        $text2="and (facturas.ven_com=1 and facturas.estado_factura=2) ";
                    }
                    if($q5=="3"){
                        $text2="and ((facturas.ven_com=1 and facturas.estado_factura<=2) or (facturas.ven_com=1 and (facturas.estado_factura=5 or facturas.estado_factura=6))) ";
                    }
                    if($q5=="5"){
                        $text2="and (facturas.ven_com=1 and facturas.estado_factura=5) ";
                    }
                    if($q5=="6"){
                        $text2="and (facturas.ven_com=1 and facturas.estado_factura=6) ";
                    }
                    
                }
                if($q4=="2"){
                    
                    if($q5=="1"){
                        $text2="and (facturas.ven_com=2 and facturas.estado_factura=1) ";
                    }
                    if($q5=="2"){
                        $text2="and (facturas.ven_com=2 and facturas.estado_factura=2) ";
                    }
                    if($q5=="3"){
                        $text2="and (facturas.ven_com=2 and facturas.estado_factura<=2) ";
                    }
                    if($q5=="5"){
                        $text2="and (facturas.ven_com=2 and facturas.estado_factura=5) ";
                    }
                    if($q5=="6"){
                        $text2="and (facturas.ven_com=2 and facturas.estado_factura=6) ";
                    }
                }
                
		$sTable = "facturas, clientes, users";
		$sWhere = "";
		$sWhere.=" WHERE facturas.id_cliente=clientes.id_cliente and facturas.tienda=$tienda1 and facturas.id_vendedor=users.user_id $text2 and facturas.activo>=0";
                if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' )";
		}
                if ( $_GET['q1'] != "" )
		{
		$sWhere.= " and  (facturas.numero_factura like '%$q1%' )";
		}
                
                if ( $_GET['q2'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')>='$q2' )";
		}
                if ( $_GET['q3'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')<='$q3')";
		}
		$sWhere.=" order by facturas.id_factura desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 1000000; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
                
                //print"$q5 <br>$q4<br>$sql";
                
		if ($numrows>0){
			echo mysqli_error($con);
			?>
                        
			<div class="table-responsive">
			  <table id="example" class="display nowrap" style="width:100%;color:black;">
				<thead>
                              <tr  style="background-color:<?php echo tablas;?>;color:white; ">
                                <th></th>  
                                <th>Nro Doc</th>
                                <th>Tipo Doc</th>
                                <th>Fecha</th>
                                <th>Cliente<br>Proveedor</th>
                                <th>Tipo</th>
                                <th>Moneda</th>
				<th>Total</th>
                                <th><?php echo nom_iva;?>,Exonerada<br>Inafecta</th>
                                <th><?php echo nom_iva;?></th>
                                
                                <th>PDF</th>
                                
                                
				</tr>
                                </thead>
                                <tbody>
                		<?php
                                $suma=0;
                                $suma1=0;
                                $cont=0;
				while ($row=mysqli_fetch_array($query)){
                                    
                                                $activo=$row['activo'];
						//if ($activo==1){
                                                $id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
                                                $ruc=$row['doc'];
						$email_cliente=$row['email_cliente'];
                                                $folio=$row['folio'];
                                                $dni=$row['dni'];
                                                
                                                $tipo=$row['tipo'];
                                                
						$nombre_vendedor=$row['nombres'];
                                                $aceptado=$row['aceptado'];
                                                $estado_factura1=$row['estado_factura'];
 						$estado_factura=$row['condiciones'];
                                                $ven_com=$row['ven_com'];
                                                
                                                if($ven_com==1){
                                                    $tip="ventas";
                                                    $val=$row['total_venta']-$row['obs'];
                                                    $label_class="blue";
                                                    $label_class1="blue";
                                                    if($estado_factura1==6){
                                                        $val=-1*($row['total_venta']-$row['obs']);
                                                        $label_class="red";
                                                    }
                                                    
                                                    
                                                }
                                                if($ven_com==2){
                                                    $tip="Compras";
                                                    $ddd7=$row['obs'];
                                                    if($row['obs']==""){
                                                        $ddd7=0;
                                                    }
                                                    $val=-1*($row['total_venta']-$ddd7);
                                                    $label_class="red";
                                                    $label_class1="red";
                                                }
                                                $suma=$suma+$val;
                                                if($tipo==0){
                                                    $tipo1=nom_iva;
                                                    $val1=$val*iva;
                                                    
                                                    
                                                }
                                                if($tipo==1){
                                                    $tipo1="Exonerada";
                                                    $val1=0;
                                                    
                                                    
                                                }
                                                if($tipo==2){
                                                    $tipo1="Inafecta";
                                                    $val1=0;
                                                }
                                                $suma1=$suma1+$val1;
                                                
                                                $moneda=$row['moneda'];
                                                $mon=moneda;
                                                if($estado_factura1==1){
                                                    $estado1="Factura";
                                                    
                                                }
                                                if($estado_factura1==2){
                                                    $estado1="Boleta";
                                                    
                                                }
                                                if($estado_factura1==3){
                                                    $estado1=doc;
                                                }
                                                if($estado_factura1==5){
                                                    $estado1="Nota de Debito";
                                                    
                                                }
                                                if($estado_factura1==6){
                                                    $estado1="Nota de Credito";
                                               }
                                                //$sql1="SELECT * FROM  servicio;";
                                                //$query1 = mysqli_query($con, $sql1);
                                               
                                                //while ($row1=mysqli_fetch_array($query1)){
                                                //  if($row1['doc_servicio']==$numero_factura && $row1['tip_doc']==$estado_factura1)  {
                                                 //    $guia=$row1['guia'];
                                                // }
                                                //}
                                                $ddd8=$row['obs'];
                                                    if($row['obs']==""){
                                                        $ddd8=0;
                                                    }
                                               
                                               
                                                $total_venta=$row['total_venta']-$ddd8;
                                                $cont=$cont+1;
					?>
					<tr id="valor1">
                                                <td><?php echo $cont; ?></td>
						<td><?php print"$folio $numero_factura" ; ?></td>
                                                <td><?php echo $estado1; ?></td>
                                                <td><?php echo $fecha; ?></td>
						<td><?php echo $nombre_cliente;?></td>
                                                <td><font color=" <?php echo $label_class1;?>"><strong><?php echo $tip;?></strong></font></td>
                                                <td><?php print"$mon";?></td>
                                                <td class='text-right'><font color=" <?php echo $label_class;?>"><strong><?php  echo number_format ($val,2); ?></strong></font></td>					
                                                <td class='text-center'><?php echo $tipo1; ?></td>
                                                <td class='text-right'><font color=" <?php echo $label_class;?>"><strong><?php echo number_format ($val1,2); ?></strong></font></td>
                                               
                                                
                                                
                                                <td>
                                                    <?php
                                                    if($ven_com==1){
                                                    ?>
                                                    <a href="#" class='btn btn-primary btn-xs' title='Descargar pdf' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                    <?php
                                                    } 
                                                    ?>
                                                    <?php
                                                    if($ven_com==2){
                                                    ?>
                                                    <a href="#" class='btn btn-primary btn-xs' title='Descargar pdf' onclick="imprimir_factura1('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                    <?php
                                                    } 
                                                    ?>
                                                </td>
                                                
                                                 
					</tr>
					<?php
                                        
                   		//}
                                }
                                //if($numrows<=100){
				?>
                                <tr style="background:white;">
                                    <td></td><td></td><td></td><td></td><td></td><td></td><td bgcolor="blue" align="center"><strong><font color="white">TOTAL</font></strong></td><td class='text-right' bgcolor="#FE642E"><strong><?php echo number_format($suma,2); ?></strong></td><td bgcolor="blue" align="center"><strong><font color="white">TOTAL <?php echo nom_iva;?></font></strong></td><td class='text-right' bgcolor="#FE642E"><strong><?php echo number_format($suma1,2); ?></strong></td><td></td>
				</tr>        
                                <?php
                                //} 
                                ?>        
                                        
				</tbody>
			  </table>
			</div>
			<?php
		}
                }
	
?>
<script>
 
$(document).ready(function() {
    $('#example').DataTable( {
        language: {
        "url": "/dataTables/i18n/de_de.lang",
                "decimal": "",
        "show": "Mostrar",
        
        "emptyTable": "No hay informacion",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        buttons: {
                copyTitle: 'Copiar filas al portapapeles',
                
                copySuccess: {
                    _: 'Copiado %d fias ',
                    1: 'Copiado 1 fila'
                },
                
                pageLength: {
                _: "Mostrar %d filas",
                '-1': "Mostrar Todo"
            }
            },
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
        
        
        
        
    },
    "order": [[ 0, 'asc' ]],
         bDestroy: true,
            dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        buttons: 
        
        
        [
                
                {
                    extend: 'pageLength',
                    text: 'Mostrar filas',
                    className: 'orange'
                },
                
                {
                    extend: 'copy',
                    text: 'COPIAR',
                    className: 'red'
                },
                
                
                
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    className: 'green'
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'green1'
                },
                {
                    extend: 'print',
                    text: 'IMPRIMIR',
                    className: 'green2'
                }
            ],
        
        
    } );
} );



</script>


  
 
