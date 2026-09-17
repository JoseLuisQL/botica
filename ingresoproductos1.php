<?php
ob_start();
session_start();
include('menu.php');
include 'ajax/barcode.php';
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
date_default_timezone_set('America/Lima');
$fecha  = date("Y-m-d H:i:s");
$codigo=trim($_POST['codigo']);
$nombre=trim($_POST['nombre']);

$nombresanitario=trim($_POST['nombresanitario']);



$cat_pro=$_POST['cat_pro'];
$estado=0;
$pre_pro=$_POST['precio'];
$precio1=$_POST['precio1'];
$precio2=$_POST['precio2'];
$cos_pro=$_POST['costo'];
$proveedor=$_POST['proveedor'];
$valor32=$_POST['valor3'];
$valor22=$_POST['valor2'];

$p1=$_POST['precio'];
$c1=$_POST['costo'];
$tipo7=$_POST['tipo7'];
$s1=$_POST['inventario'];
$p2=$_POST['p2'];
$c2=$_POST['c2'];
$s2=$_POST['s2'];
$p3=$_POST['p3'];
$c3=$_POST['c3'];
$s3=$_POST['s3'];

$a2=$_POST['a2'];

if($a2==0 or $a2==""){
    $tipo7="";
}

$a3=$_POST['a3'];

$multiplicando=$_POST['multiplicando'];
$cos_pro1=$cos_pro*$multiplicando;
$mon_costo=$multiplicando;
$mon_venta=1;
$des1=$_POST['des1'];
$des2=$_POST['des2'];
$und_pro=$_POST['und_pro'];
$des3=$_POST['des3'];
$inventario=$_POST['inventario']+$a2*$s2+$a3*$s3;
$tienda=$_SESSION['tienda'];
$barras=$_POST['barras'];
$min=$_POST['min'];
$mon=$_POST['mon'];
$prod = array();
    for($i=1 ;$i<=7;$i++){
        if($i==$tienda){
          $prod[$i]=$inventario;
            
        }else{
           $prod[$i]=0; 
        }
        
    }
$aa=0;
$id_producto=0; 
$consulta2 = "SELECT * FROM products ";
$result2 = mysqli_query($con, $consulta2);



/* QUITAR VALIDACION DUPLICADO */

 while ($valor2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
    if($valor2['codigo_producto']==$codigo){
    
    $aa=1;
   
    }
    $id_producto=$valor2['id_producto']+1;
    if($valor2['codigo_producto']==$codigo /* or $valor2['nombre_producto']==$nombre */){
        $mensaje="Codigo del producto duplicado ";
    }
}




if(trim($nombre)=="" or trim($codigo)==""){
    $mensaje="Codigo o nombre del producto vacio";
}

 if($mensaje<>"") {
    ?>

<?php
    header("location:ingresoproductos.php?mensaje=$mensaje");
}else{

if($aa==1){
   ?>
<script language="JavaScript" type="text/javascript">
alert("este texto es el que modificas");
</script>
<?php
    header("location:ingresoproductos.php"); 
    
}else{
    
    $namefinal="nuevo.jpg";
    if(is_uploaded_file($_FILES['files']['tmp_name'])) {
    $ruta_destino = "fotos/";
        $namefinal="producto".$id_producto.".jpg"; //linea nueva devuelve la cadena sin espacios al principio o al final
        $uploadfile=$ruta_destino.$namefinal;
    if(move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
        if(isset($barras) and strlen($barras)>=2){
            barcode('ajax/codigos/'.$barras.'.png', $barras, 30, 'horizontal', 'code128', true);
            
        }else{
            $barras="";
        }
        $consulta = "INSERT INTO products
            values (NULL, '$codigo', '$nombre',  '$nombresanitario', '$estado','$fecha','$pre_pro','$cos_pro1','$mon_costo','$mon_venta','$des1','$des2','$des3','$prod[1]','$prod[2]','$prod[3]','$prod[4]','$prod[5]','$prod[6]','$prod[7]','$cat_pro','1','$namefinal','nuevo.jpg','nuevo.jpg','nuevo.jpg','0','$pre_pro','','','0','0','$valor22','$valor32','$und_pro','$pre_pro','$pre_pro','$pre_pro','$pre_pro','$pre_pro','$pre_pro','$pre_pro','$min','$barras','$mon','$cos_pro','$cos_pro','$cos_pro','$cos_pro','$cos_pro','$cos_pro','$cos_pro','$proveedor','$a2','$a3','$c1','$c2','$tipo7')";
        if (mysqli_query($con, $consulta)) {
            $id1=mysqli_insert_id($con);
            if(is_numeric($codigo) and $codigo>0){
                $insert=mysqli_query($con, "INSERT INTO ultimo (id_ultimo,ultimo) VALUES (NULL, '$codigo');");
            }
            
            $ingreso=mysqli_query($con,"INSERT INTO precios VALUES (NULL,'$id1','$p1','$p2','$p3','$c1','$c2','$c3','$s1','$s2','$s3','$s1','$s2','$s3','$tienda')");
           
            header("location:productos.php");
        } else {
              die("No se pudo insertar1..");
        }
      }
      }else{
        if(isset($barras) and strlen($barras)>=2){
            barcode('ajax/codigos/'.$barras.'.png', $barras, 30, 'horizontal', 'code128', true);
            
        }else{
            $barras="";
        }
          $consulta = "INSERT INTO products
            values (NULL, '$codigo', '$nombre',  '$nombresanitario',  '$estado','$fecha','$pre_pro','$cos_pro1','$mon_costo','$mon_venta','$des1','$des2','$des3','$prod[1]','$prod[2]','$prod[3]','$prod[4]','$prod[5]','$prod[6]','$prod[7]','$cat_pro','1','$namefinal','nuevo.jpg','nuevo.jpg','nuevo.jpg','0','$pre_pro','','','0','0','$valor22','$valor32','$und_pro','$pre_pro','$pre_pro','$pre_pro','$pre_pro','$pre_pro','$pre_pro','$pre_pro','$min','$barras','$mon','$cos_pro','$cos_pro','$cos_pro','$cos_pro','$cos_pro','$cos_pro','$cos_pro','$proveedor','$a2','$a3','$c1','$c2','$tipo7')";
        if (mysqli_query($con, $consulta)) {
            $id1=mysqli_insert_id($con);
            if(is_numeric($codigo) and $codigo>0){
                $insert=mysqli_query($con, "INSERT INTO ultimo (id_ultimo,ultimo) VALUES (NULL, '$codigo');");
            }
            $ingreso=mysqli_query($con,"INSERT INTO precios VALUES (NULL,'$id1','$p1','$p2','$p3','$c1','$c2','$c3','$s1','$s2','$s3','$s1','$s2','$s3','$tienda')");
           
            header("location:productos.php");
        } else {
              die("No se pudo insertar2..$consulta");
        } 
        
      }
        
        if($multiplicando>1){
            $consulta1 = "UPDATE datosempresa SET dolar=".$multiplicando;
            
            if (mysqli_query($con, $consulta1)) {
                header("location:productos.php");
            } else {
              die("No se pudo insertar..");
            }        
       }
        
}
}
ob_end_flush(); 
?>



