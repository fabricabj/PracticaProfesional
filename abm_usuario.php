<?php
require("conexion.php");
if (isset($_POST['idusuario']) && !empty($_POST['idusuario'])) {
	
	$idUsuario = $_POST['idusuario'];
	$delete=mysqli_query($conexion, "Update usuarios Set idestado = 2 where idusuario=$idUsuario");
	header("location:listarUsuario.php");

}

if (isset($_POST['activar']) && !empty($_POST['activar'])) {
	
	$idUsuario = $_POST['id'];
	$delete=mysqli_query($conexion, "Update usuarios Set idestado = 1 where idusuario=$idUsuario");
	header("location:usuariosinactivos.php");

}
?>