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
</style>
<style type="text/css">
   .thumbnail1{
position: relative;
z-index: 0;
}
.thumbnail1:hover{
background-color: transparent;
z-index: 50;
}
.thumbnail1 span{ /*Estilos del borde y texto*/
position: absolute;
background-color: white;
padding: 5px;
left: -100px;

visibility: hidden;
color: #FFFF00;
text-decoration: none;
}
.thumbnail1 span img{ /*CSS for enlarged image*/
border-width: 0;
padding: 2px;
}
.thumbnail1:hover span{ /*CSS for enlarged image on hover*/
visibility: visible;
top: 17px;
left: 40px; /*position where enlarged image should offset horizontally */
} 

img.imagen2{
padding:4px;
border:3px #0489B1 solid;
margin-left: 2px;
margin-right:5px;
margin-top: 5px;
float:left;

}

table tr:nth-child(odd) {background-color: #F5F6CE;}
table tr:nth-child(even) {background-color: #CEF6E3;}
#valor1:hover {              
background-color: white;
border-bottom: 2px solid #A9E2F3;
}  
#valor2:hover {              
background-color: white;
border-bottom: 2px solid #A9E2F3;
} 
#valor1 {             
background-color: #FBF8EF;
border-bottom: 2px solid #F5ECCE;
}  
#valor2 {             
background-color: #EFFBF5;
border-bottom: 2px solid #F5ECCE;
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
tfoot {
    display: table-header-group;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: none;
  color: black!important;
  border-radius: 4px;
  border: 1px solid #828282;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:active {
  background: none;
  color: black!important;
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
	if (isset($_GET['id'])){
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
                $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
                $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
		$sTable = "facturas, clientes, guia";
		$sWhere = "";
		$sWhere.=" WHERE guia.guia>0 and facturas.id_cliente=clientes.id_cliente and facturas.tienda=$tienda1 and facturas.ven_com=1 and facturas.estado_factura=1 and facturas.id_factura=guia.id_doc";
                if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' )";
		}
                if ( $_GET['q1'] != "" )
		{
		$sWhere.= " and  (guia.guia like '%$q1%' )";
		}
                
                if ( $_GET['q2'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(guia.fecha, '%Y-%m-%d')='$q2' )";
		}
                
		$sWhere.=" order by facturas.id_factura desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
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
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table" style="color:black;">
				<tr  style="background-color:<?php echo tablas;?>;color:white; ">
                                <th>Nro Guia</th>
                                <th>Fecha</th>
				<th>Cliente</th>
				<th>Nro Factura</th>
                                
                                <th>Mensaje</th> 
                                <th>Editar</th>
                                <th>XML</th>
                                <th>CDR</th>
                                <th>PDF</th>
				</tr>
                		<?php
				while ($row=mysqli_fetch_array($query)){
                                    
                                                $id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
                                                $folio=$row['folio'];
                                                $serie=$row['serie'];
                                                $id_guia=$row['id'];
                                                $guia=$row['guia'];
						$fecha=date("d/m/Y", strtotime($row['fecha']));
						$nombre_cliente=$row['nombre_cliente'];
                                                $aceptado=$row['aceptado_guia'];
                                                $doc_guia=$row['doc_guia'].".XML";
                                                $cdr_guia="R-".$row['doc_guia'].".XML";
                                                $pos = strpos($aceptado, "aceptado");
                                                $aceptado2= "";
                                                $color="red";
                                                if ($pos === false) {
                                                    $aceptado1= "No enviada<br>falta editar";
                                                    $aceptado2= "disabled";
                                                }else {
                                                   $aceptado1="Enviado y aceptado";
                                                   $aceptado2= "disabled";
                                                   $color="blue";
                                                }   
                                                
                                                
					?>
					<tr id="valor1">
                                           
						<td><?php print"$serie $guia" ; ?></td>
                                               
                                                <td><?php echo $fecha; ?></td>
						<td><?php echo $nombre_cliente;?></td>
                                              
                                                <td><?php print"$folio $numero_factura"; ?></td>
                                                <td style="width: 15%; "><font color="<?php echo $color;?>"><?php echo $aceptado1;?></font></td>
                                                <td> <a href="guia.php?accion=<?php echo $id_factura;?>" class='btn btn-primary btn-xs' title='Guia de remision' ><i class="glyphicon glyphicon-download"></i></a> </td>
                                                
                                                
                                                 <td><?php
                                                if ($pos==true) {
                                                    ?>
                                                    <a href="#"  class='btn btn-success btn-xs' title='Descargar xml' onclick="imprimir_xmlguia('<?php echo $doc_guia;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                <?php
                                                }else{
                                                   ?>
                                                    <a href="#"  class='btn btn-success btn-xs' title='Xml no generado' ><i class="glyphicon glyphicon-download"></i></a> 
                                                <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($pos==true) {
                                                    ?>
                                                    <a href="#"  class='btn btn-info btn-xs' title='Descargar cdr' onclick="imprimir_cdrguia('<?php echo $cdr_guia;?>');"><i class="glyphicon glyphicon-download"></i></a>
                                               
                                                <?php
                                                }else{
                                                   ?>
                                                    <a href="#"  class='btn btn-info btn-xs' title='cdr no generado' ><i class="glyphicon glyphicon-download"></i></a> 
                                                <?php
                                                }
                                                ?> 
                                                </td>
                                                <td>
                                               
                                                    <a href="#"  class='btn btn-warning btn-xs' title='Descargar guia' onclick="imprimir_guia('<?php echo $id_guia;?>');"><i class="glyphicon glyphicon-download"></i></a>
                                               
                                                </td>
                                                   
                                                
					</tr>
					<?php
                                        $numrows=$numrows-1;
                   		
                                }
				?>
				<tr style="background:white;">
					<td colspan=13><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
                }
	
?>

