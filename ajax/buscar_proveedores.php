<?php
include('is_logged.php');
?>
<style>
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

</style>

<?php
        //include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$tienda1=$_SESSION['tienda'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_proveedores=intval($_GET['id']);
		$query=mysqli_query($con, "select * from facturas where id_cliente='".$id_proveedores."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM clientes WHERE id_cliente='".$id_proveedores."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar ésta Proveedor.Existen documentos vinculadas a este proveedor. 
			</div>
			<?php
            }
        }
	if($action == 'ajax'){
                $sTable = "clientes";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable WHERE tipo1=2 and tienda=$tienda1 ");
                $row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './clientes.php';
		$sql="SELECT * FROM  $sTable WHERE tipo1=2 and tienda=$tienda1 ";
                $query = mysqli_query($con, $sql);
		if ($numrows>0){
                    ?>
                    <div class="table-responsive">
			<table id="example"  style="width:100%;color:black;">
                           
                            <thead>
				<tr style="background-color:<?php echo tablas;?>;color:white; ">
                                    <th>Nro</th>
                                    <th>Razon Social</th>
                                    <th>Tipo doc</th>
                                    <th>Documento</th>
                                    
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th class='text-right'>Acciones</th>	
				</tr>
                                </thead>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$id_cliente=$row['id_cliente'];
					$nombre_cliente=$row['nombre_cliente'];
					$telefono_cliente=$row['telefono_cliente'];
					$email_cliente=$row['email_cliente'];
					$direccion_cliente=$row['direccion_cliente'];
                                        $doc=$row['doc'];
                                        $dni=$row['dni'];
                                        if($doc>0){
                                                    $doc1=$doc;
                                                    $tipo="RUC";
                                                    $tipo1="2";
                                                }
                                                if($dni>0){
                                                    $doc1=$dni;
                                                    $tipo="DNI";
                                                    $tipo1="1";
                                                }
                                        $departamento=$row['departamento'];
                                        $provincia=$row['provincia'];
                                        $distrito=$row['distrito'];
                                        $cuenta=$row['cuenta'];
                                        $vendedor=$row['vendedor'];
                                        $status_cliente=$row['status_cliente'];
					if ($status_cliente==1){$estado="Activo";}
					else {$estado="Inactivo";}
					$date_added= date('d/m/Y', strtotime($row['date_added']));
                                        ?>
                                        <tr id="valor1">
                                        <input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $telefono_cliente;?>" id="telefono_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $email_cliente;?>" id="email_cliente<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $doc;?>" id="doc<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $vendedor;?>" id="vendedor<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $direccion_cliente;?>" id="direccion_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $status_cliente;?>" id="status_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $dni;?>" id="dni<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $departamento;?>" id="departamento<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $provincia;?>" id="provincia<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $distrito;?>" id="distrito<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $cuenta;?>" id="cuenta<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $tipo;?>" id="tipo<?php echo $id_cliente;?>">    
                                            <td><?php echo $numrows; ?></td>
                                            <td><?php echo $nombre_cliente; ?></td>
                                            <td ><?php echo $tipo; ?></td>
                                            <td ><?php echo $doc; ?></td>
                                            
                                            <td ><?php echo $telefono_cliente; ?></td>
                                            <td><?php echo $email_cliente;?></td>
                                            <td><?php echo $estado;?></td>
                                            <td><span class="pull-right">
                                                <a href="#" class='btn btn-warning btn-xs' title='Editar cliente' onclick="obtener_datos('<?php echo $id_cliente;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
                                                <a href="#" class='btn btn-danger btn-xs' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span>
                                            </td>	
					</tr>
					<?php
                                        $numrows=$numrows-1;
				}
				?>
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
         bDestroy: true,
            dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        buttons: 
        [  
             {
                    extend: 'colvis',
                    text: 'Mostrar columnas',
                    className: 'green2',
                    exportOptions: {
                    columns: ':visible'
                }         
                },   
                          
{
                    extend: 'pageLength',
                    text: 'Mostrar filas',
                    className: 'orange',
                    exportOptions: {
                    columns: ':visible'
                }     
                },
                {
                    extend: 'copy',
                    text: 'COPIAR',
                    className: 'red',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    className: 'green',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'green1',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'print',
                    text: 'IMPRIMIR',
                    className: 'green2',
                    exportOptions: {
                    columns: ':visible'
                }
                },
            ],
         "pageLength": 20,
        
    } );
} );
</script>