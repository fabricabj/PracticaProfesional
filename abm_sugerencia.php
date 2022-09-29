<?php
session_start();
require("conexion.php");
if (isset($_POST['guardarSugerencia']) && !empty($_POST['guardarSugerencia'])) {

    $select4=mysqli_query($conexion,"SELECT * FROM usuarios WHERE idusuario={$_SESSION['login']}");
    $datos=mysqli_fetch_assoc($select4);
	
    $fecha = date('y/m/d');
	$descripcion = $_POST['descripcion'];
    // modificar id estado en caso de poder visualizar sugerencia (1 leido, 2 no leido)
    $idestado = 2;
    $idusuario = $datos['idusuario'];    

	$Insert=mysqli_query($conexion,"INSERT INTO sugerencias VALUES (00,'$fecha','$descripcion','$idestado','$idusuario')");	

	header("location:contactenos.php?estado=1");
} 
?>