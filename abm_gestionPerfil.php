<?php
session_start();
require("conexion.php");
if (isset($_POST['guardarPerfil']) && !empty($_POST['guardarPerfil'])) {
	
	$nombre = $_POST['nombre_usuario'];
	$apellido = $_POST['apellido'];
	$telefono=$_POST['telefono'];
	$mail=$_POST['mail'];
	$tipo_documento = $_POST['idtipodocumento'];
	$numero_documento=$_POST['numero_documento']; 
    $sexo=$_POST['sexo'];
    $ciudad=$_POST['cbxciudad'];

	$Insert=mysqli_query($conexion,"UPDATE usuarios SET apellido='$apellido',telefono='$telefono',mail='$mail',numero_documento='$numero_documento',nombre='$nombre',idciudad=$ciudad,idgenero=$sexo,idtipodocumento=$tipo_documento WHERE idusuario={$_SESSION['login']}");
		

	header("location:gestionPerfil.php?estado=1");
} 