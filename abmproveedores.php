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
             echo "<script>alert('el cuit ingresado ya existe, intente con otro');</script>";
		}
		if(mysqli_num_rows($registros2)>0){
			echo "<script>alert('el mail ingresado ya existe, intente con otro');</script>";
	    }
	}else{
		$selectEstado=mysqli_query($conexion,"SELECT idestado FROM estados_provedores WHERE descripcion='$estado'");
        while($r=mysqli_fetch_array($selectEstado)){
            $idestado=$r['idestado'];
		}
		$Insert=mysqli_query($conexion,"INSERT INTO proveedores values (00,'$razon_social','$cuit','$email',$idestado)");
		echo "<script>alert('registrado con exito');</script>";
       
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
        header("location:proveedores.php");

} 
if (isset($_POST['btnEliminar'])) {

		$cuit = $_POST['cuit'];
		$delete=mysqli_query($conexion, "UPDATE proveedores SET idestado = 2 WHERE cuit='$cuit' ");
		header("location:proveedores.php");
	}

    if (isset($_POST['btnActivar'])) {

		$cuit = $_POST['cuit'];
		$delete=mysqli_query($conexion, "UPDATE proveedores SET idestado = 1 WHERE cuit='$cuit' ");
		header("location:proveedoresinactivos.php");
	}
 
?>
