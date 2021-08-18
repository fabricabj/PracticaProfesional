<?php
	
	require ('../conexion.php');
	
	$id_ciudad = $_POST['id_ciudad'];
 
	$queryM = "SELECT DISTINCT  idciudad, nombre_ciudad FROM ciudades WHERE idprovincia=$id_ciudad ORDER BY nombre_ciudad ASC";
	$resultadoM = $conexion->query($queryM);
	
	$html= "<option value='0'>Seleccionar Ciudad</option>";
	
	while($rowM = $resultadoM->fetch_assoc())
	{
		$html.= "<option value='".$rowM['idciudad']."'>".$rowM['nombre_ciudad']."</option>";
	}
	
	echo $html;
?>
