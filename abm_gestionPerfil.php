<?php
require("conexion.php");
if (isset($_POST['guardarPerfil']) && !empty($_POST['guardarPerfil'])) {
	
	$nombre = $_POST['nombre_usuario'];
	$apellido = $_POST['apellido'];
	$telefono=$_POST['telefono'];
	$tipo_documento = $_POST['idtipodocumento'];
	$numero_documento=$_POST['numero_documento']; 
    $sexo=$_POST['sexo'];
    $pais=$_POST['cbxpais'];
    $provincia=$_POST['cbxprovincia'];
    $ciudad=$_POST['cbxciudad'];

	$Insert=mysqli_query($conexion,"INSERT INTO usuarios values (00,'','',$apellido','$telefono','','','$numero_documento','$ciudad',$tipo_documento,$nombre,$sexo)");	
		//echo"$Insert";
		//header("location:noticias.php");
echo $nombre . " ". $apellido." ".$telefono. " ".$tipo_documento." ".$numero_documento." ".$pais." ".$provincia." ".$ciudad;
} 