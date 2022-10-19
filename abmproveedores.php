<?php
require("conexion.php");
if (isset($_POST['btnGuardar']) && !empty($_POST['btnGuardar'])) {

    $razon_social = $_POST['razon'];
    $cuit = $_POST['cuit'];
    $email=$_POST['email'];
    $estado=$_POST['estado'];
    //echo $razon_social." ".$cuit." ".$email." ".$estado;
    $registros=mysqli_query($conexion,"SELECT cuit from proveedores WHERE cuit='$cuit'");
	$registros2=mysqli_query($conexion,"SELECT mail from proveedores WHERE mail='$email'");
	if(mysqli_num_rows($registros)>0 || mysqli_num_rows($registros2)>0){  
		if(mysqli_num_rows($registros)>0){
             header("proveedores.php?pagina=1&est=$estado&estado=5");
		}
		if(mysqli_num_rows($registros2)>0){
			header("proveedores.php?pagina=1&est=$estado&estado=6");
	    }
	}else{
		$selectEstado=mysqli_query($conexion,"SELECT idestado FROM estados_provedores WHERE descripcion='$estado'");
        while($r=mysqli_fetch_array($selectEstado)){
            $idestado=$r['idestado'];
		}
		$Insert=mysqli_query($conexion,"INSERT INTO proveedores values (00,'$razon_social','$cuit','$email',$idestado)");
		header("proveedores.php?pagina=1&est=$estado&estado=1");
       
    }
}
 if (isset($_POST['btnModificar']) && !empty($_POST['btnModificar'])) {
	$cuit_anterior=$_POST['cuit_anterior'];
	$razon_social = $_POST['razon_social'];
	$cuit = $_POST['cuit'];
	$email=$_POST['email'];
	$idestado=$_POST['estado'];

    $Insert=mysqli_query($conexion,"UPDATE proveedores SET razon_social='$razon_social',cuit='$cuit',mail='$email',idestado=$idestado WHERE cuit='$cuit_anterior'");
	//echo $razon_social." ".$cuit." ".$email." ".$idestado;
        header("location:proveedores.php?pagina=1&est=$idestado&estado=2");

} 
if (isset($_POST['Delete'])  && !empty($_POST['Delete'])) {
		$est = $_POST['est'];
		$id = $_POST['id'];
		$delete=mysqli_query($conexion, "UPDATE proveedores SET idestado = 2 WHERE idproveedor=$id ");
		header("location:proveedores.php?pagina=1&est=$est&estado=3");
	}

    if (isset($_POST['activar'])) {
		$idproveedor = $_POST['id'];
		$activar=mysqli_query($conexion, "UPDATE proveedores SET idestado = 1 WHERE idproveedor='$idproveedor' ");
		header("location:proveedores.php?pagina=1&est=2&estado=4");
	}
 
?>
