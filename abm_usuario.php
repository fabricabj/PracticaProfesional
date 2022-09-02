<?php
require("conexion.php");

if (isset($_POST['btnModificar']) && !empty($_POST['btnModificar'])) {

	$usuario_anterior =$_POST['id'];
	$nombre = $_POST['nombre_usuario'];
	$mail = $_POST['mail'];
	$idestado =$_POST['estado'];
	$rol =$_POST['rol'];
		
	$Insert=mysqli_query($conexion,"UPDATE usuarios SET nombre_usuario='$nombre',mail='$mail',idestado='$idestado' WHERE idusuario='$usuario_anterior'");
	echo $usuario_anterior." ".$nombre." ".$mail." ".$idestado;

	$update=mysqli_query($conexion,"UPDATE grupo_usuarios SET idgrupo=$rol WHERE idusuario=$usuario_anterior");
   header("location:listarUsuario.php");

	

}
if (isset($_POST['idusuario']) && !empty($_POST['idusuario'])) {
	
	$idUsuario = $_POST['idusuario'];
	$delete=mysqli_query($conexion, "Update usuarios set idestado = 2 where idusuario=$idUsuario");
	header("location:listarUsuario.php");

}

if (isset($_POST['activar']) && !empty($_POST['activar'])) {
	
	$idUsuario = $_POST['id'];
	$delete=mysqli_query($conexion, "Update usuarios set idestado = 1 where idusuario=$idUsuario");
	header("location:usuariosinactivos.php");

}
if (isset($_POST['Cancelar']) && !empty($_POST['Cancelar'])) {
	header("location:listarUsuario.php");
}
?>