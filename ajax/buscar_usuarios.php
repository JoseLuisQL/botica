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
tfoot {
    display: table-header-group;
}
</style>
<?php

	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$user_id=intval($_GET['id']);
		$query=mysqli_query($con, "select * from users where user_id='".$user_id."'");
		$rw_user=mysqli_fetch_array($query);
		$count=$rw_user['user_id'];
                $query1=mysqli_query($con, "select * from detalle_factura where id_vendedor='".$user_id."'");
		$count1=mysqli_num_rows($query1);
                $query3=mysqli_query($con, "select * from facturas where id_vendedor='".$user_id."'");
		$count3=mysqli_num_rows($query3);
                $query4=mysqli_query($con, "select * from servicio where user_id='".$user_id."'");
		$count4=mysqli_num_rows($query4);
		if ($count>1 && $count1==0 && $count3==0 && $count4==0){
			if ($delete1=mysqli_query($con,"DELETE FROM users WHERE user_id='".$user_id."'")){
			
                         $delete2=mysqli_query($con,"DELETE FROM clientes WHERE vendedor='".$user_id."'");   
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
			  <strong>Error!</strong> No se puede eliminar el usuario porque esta enlazado a otros datos . 
			</div>
			<?php
		}
        }
	if($action == 'ajax'){
		$aColumns = array('nombres', 'user_name');//Columnas de busqueda
		$sTable = "users";
		$sWhere = "";
		$sWhere.=" order by user_id desc";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './usuarios.php';
		$sql="SELECT * FROM  $sTable $sWhere";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table id="example" class="display nowrap" style="width:100%;color:black;" >
                               
                              <thead>
				<tr  style="background-color:<?php echo tablas;?>;color:white; ">
					<th></th>
					<th>Nombres</th>
					<th>Usuario</th>
					<th>Email</th>
                                        <th>DNI</th>
					<th><span class="pull-right">Acciones</span></th>
					
				</tr>
                                </thead>
				<?php
				while ($row=mysqli_fetch_array($query)){
                                    $user_id=$row['user_id'];
                                    $fullname=$row['nombres'];
                                    $user_name=$row['user_name'];
                                    $user_email=$row['user_email'];
                                    $dni=$row['dni'];
                                    $dom=$row['domicilio'];
                                    $tel=$row['telefono'];
                                    $hora=$row['hora'];
                                    $sucursal=$row['sucursal'];
                                    $foto=$row['foto'];
                                    $date_added= date('d/m/Y', strtotime($row['date_added']));
                                    $accesos=$row['accesos'];
                                    $a=explode(".",$accesos);
                             	?>
				<tr id="valor1">
                                        <input type="hidden" value="<?php echo $row['nombres'];?>" id="nombres<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $user_name;?>" id="usuario<?php echo $user_id;?>">
					<input type="hidden" value="<?php echo $user_email;?>" id="email<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $dni;?>" id="dni<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $dom;?>" id="dom<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $tel;?>" id="tel<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $hora;?>" id="hora<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $sucursal;?>" id="sucursal<?php echo $user_id;?>">
                                        <td> 
                                            <img src="images/<?php echo $foto;?>" class="avatar" alt="Avatar">
                                        </td>
						<td><?php echo $fullname; ?></td>
						<td ><?php echo $user_name; ?></td>
						<td ><?php echo $user_email; ?></td>
						 <td><?php echo $dni;?></td>
						
					<td ><span class="pull-right">
					<a href="acceso.php?usuario=<?php echo $fullname;?>" class='btn btn-info btn-xs' title='Acceso'><i class="fa fa-pencil"></i>Acceso</a>        
                                        <a href="user2.php?accion=<?php echo $user_id;?>" class='btn btn-success btn-xs' title='Editar foto'><i class="fa fa-pencil"></i>Foto</a>        
                                        <a href="#" class='btn btn-warning btn-xs' title='Editar usuario' onclick="obtener_datos('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i>Editar</a> 
					<a href="#" class='btn btn-primary btn-xs' title='Cambiar contraseña' onclick="get_user_id('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal3"><i class="glyphicon glyphicon-cog">Clave</i></a>
					
                                        <a href="#" class='btn btn-danger btn-xs' title='Borrar usuario' onclick="eliminar('<?php echo $user_id; ?>')"><i class="glyphicon glyphicon-trash"></i> Borrar</a></span>
                                        
                                        </td>
                                    </tr>
                                    <?php
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