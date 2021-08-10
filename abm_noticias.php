<?php
require("conexion.php");
if (isset($_POST['guardarNoticia']) && !empty($_POST['guardarNoticia'])) {
	
	$nombre_noticia = $_POST['nombre_noticia'];
	$descripcion = $_POST['descripcion'];
	$fecha=$_POST['fecha'];
	$imagen = $_POST['imagen'];
	$estado=$_POST['estado']; 
    $idproveedor=$_POST['idproveedor'];
	//  $registros=mysqli_query($conexion,"SELECT nombre_noticia from noticias WHERE nombre_noticia='$nombre_noticia'");
	/* if(mysqli_num_rows($estado)>0){  
		 $selectEstado=mysqli_query($conexion,"SELECT idestado FROM estados_noticias WHERE descripcion='$estado'");
		 while($r=mysqli_fetch_array($selectEstado)){
			$idestado=$r['idestado'];
		 }
		
	}  */
	$Insert=mysqli_query($conexion,"INSERT INTO noticias values (00,'$nombre_noticia','$descripcion','$fecha','$imagen',$estado,$idproveedor)");	
		//echo"$Insert";
		header("location:noticias.php");

} 
 if (isset($_POST['Modificar']) && !empty($_POST['Modificar'])) {
	
	$titulo_anterior = $_POST['nombre_anterior'];
	$nombre_noticia = $_POST['nombre_noticia'];
	$descripcion = $_POST['descripcion'];
	$fecha=$_POST['fecha'];
	$imagen = $_POST['imagen'];
	$idestado=$_POST['idestado'];
    $idproveedor=$_POST['idproveedor'];
	
	
	if ($nombre_noticia!=$titulo_anterior){
	 $registros=mysqli_query($conexion,"SELECT nombre_noticia from noticias WHERE nombre_noticia='$nombre_noticia'");
		if(mysqli_num_rows($registros)>0){  
			$Actualizar = "UPDATE noticias SET nombre_noticia='$nombre_noticia',descripcion='$descripcion',fecha='$fecha',imagen='$imagen',idestado=$idestado,idproveedor='$idproveedor' WHERE nombre_noticia='$titulo_anterior'";
			$enviar = mysqli_query($conexion, $Actualizar);
			header("location:noticias.php");   		
		}else{
			//arrreglar estoooooooooo
			$Actualizar = "UPDATE noticias SET nombre_noticia='$nombre_noticia',descripcion='$descripcion',fecha='$fecha',imagen='$imagen',idestado=$idestado,idproveedor='$idproveedor' WHERE nombre_noticia='$titulo_anterior'";
			$enviar = mysqli_query($conexion, $Actualizar);
			header("location:noticias.php");
		} 
	}else{
		$Actualizar = "UPDATE noticias SET descripcion='$descripcion',fecha='$fecha',imagen='$imagen',idestado=$idestado,idproveedor='$idproveedor' WHERE nombre_noticia='$titulo_anterior'";
		$enviar = mysqli_query($conexion, $Actualizar);
		header("location:noticias.php");
	}
} 
	if (isset($_POST['idnoticia'])) {
		
		$idNoticia = $_POST['idnoticia'];
		$delete=mysqli_query($conexion, "update noticias set idestado = 2 where idnoticia='$idNoticia'");
		header("location:noticias.php");
	}

?>