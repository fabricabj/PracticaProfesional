<?php
	
	require ('../conexion.php');
	$html="<option>seleccione provincia</option>";
	$id = $_POST['id'];
    $select=mysqli_query($conexion,"SELECT idpais FROM paises WHERE nombre='$id'");
    while($r=mysqli_fetch_array($select)){
        $idPais=$r['idpais'];
    }
	$queryM = "SELECT DISTINCT  idprovincia, nombre_provincia FROM provincias WHERE idpais=$idPais ORDER BY nombre_provincia ASC";
	$resultadoM = $conexion->query($queryM);
	
	
	while($rowM = $resultadoM->fetch_assoc())
	{
		$html.= "<option value='".$rowM['idprovincia']."'>".$rowM['nombre_provincia']."</option>";
	}
	
    echo $html;
    ?>