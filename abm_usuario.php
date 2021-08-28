<?php
require("conexion.php");

if (isset($_POST['btnModificar']) && !empty($_POST['btnModificar'])) {

	$usuario_anterior =$_POST['id'];
	$nombre = $_POST['nombre_usuario'];
	$mail = $_POST['mail'];
	//$nombre_grupo = ['grupo'];
	$estado =['estado'];

	$Insert=mysqli_query($conexion,"UPDATE usuarios SET nombre_usuario='$nombre',mail='$mail',idestado='$estado' WHERE idusuario='$usuario_anterior'");
	echo $usuario_anterior." ".$nombre." ".$mail;
       header("location:listarUsuario.php");

	

}
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