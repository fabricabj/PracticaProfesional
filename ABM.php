
<?php
require("conexion.php");
if (isset($_POST['guardar']) && !empty($_POST['guardar'])) {
	
	$titulo = $_POST['titulo'];
	$duracion = $_POST['duracion'];
	$puntaje = $_POST['puntaje'];
	$imagen = $_POST['imagen'];
	$descripcion = $_POST['descripcion'];
	$anio = $_POST['anio'];
	$precio = $_POST['precio'];
	$fecha_publicacion=$_POST['fecha_publicacion'];
	$estado=$_POST['estado'];
	$generos='';
	if(isset($_POST['nombre_genero'])){
	   foreach($_POST['nombre_genero'] as $selected){
		  $generos=$generos.' '.$selected;
	   }
	}
	$registros=mysqli_query($conexion,"SELECT titulo from peliculas WHERE titulo='$titulo'");
	if(mysqli_num_rows($registros)>0){  
		$select=mysqli_query($conexion,"SELECT categorias FROM peliculas WHERE titulo='$titulo'");
		while($r=mysqli_fetch_array($select)){$nombre_genero=$r['categorias'];}
		header("location:peliculas.php?genero=$nombre_genero&estado=3");         
	}else{
		$selectEstado=mysqli_query($conexion,"SELECT idestado FROM pelicula_estados WHERE descripcion='$estado'");
		while($r=mysqli_fetch_array($selectEstado)){
			$idestado=$r['idestado'];
		}
		$Insert=mysqli_query($conexion,"INSERT INTO peliculas values (00,'$titulo','$descripcion',$anio,$puntaje,$precio,'$duracion','$imagen',$idestado,'$generos',null,null,'$fecha_publicacion')");
		header("location:categorias.php?genero=$generos&estado=1");
	}
}
if (isset($_POST['Modificar']) && !empty($_POST['Modificar'])) {
	
	$titulo = $_POST['titulo'];
	$titulo_anterior = $_POST['titulo_anterior'];
	$duracion = $_POST['duracion'];
	$puntaje = $_POST['puntaje'];
	$imagen = $_POST['imagen'];
	$descripcion = $_POST['descripcion'];
	$anio = $_POST['anio'];
	$precio = $_POST['precio'];
	$fecha_publicacion=$_POST['fecha_publicacion'];
	$idestado = $_POST['estado'];
	$generos='';
	if(isset($_POST['nombre_genero'])){
	   foreach($_POST['nombre_genero'] as $selected){
		  $generos=$generos.' '.$selected;
	   }
    }
	if ($titulo!=$titulo_anterior){
	$registros=mysqli_query($conexion,"SELECT titulo from peliculas WHERE titulo='$titulo'");
	if(mysqli_num_rows($registros)>0){  
			$select=mysqli_query($conexion,"SELECT categorias FROM peliculas WHERE titulo='$titulo'");
			while($r=mysqli_fetch_array($select)){$nombre_genero=$r['categorias'];}
			header("location:peliculas.php?genero=$nombre_genero&estado=3");     
		}else{
			$Actualizar = "UPDATE peliculas SET titulo='$titulo',descripcion='$descripcion',anio=$anio,puntaje=$puntaje,precio=$precio,duracion='$duracion',imagen='$imagen',idestado=$idestado,categorias='$generos',fecha_publicacion='$fecha_publicacion' WHERE titulo='$titulo_anterior'";
			$enviar = mysqli_query($conexion, $Actualizar);
			header("location:categorias.php?genero=$generos&esatado=2");
		}
	}else{
		$Actualizar = "UPDATE peliculas SET descripcion='$descripcion',anio=$anio,puntaje=$puntaje,precio=$precio,duracion='$duracion',imagen='$imagen',idestado=$idestado,categorias='$generos',fecha_publicacion='$fecha_publicacion' WHERE titulo='$titulo_anterior'";
		$enviar = mysqli_query($conexion, $Actualizar);
		header("location:categorias.php?genero=$generos&esatado=2");
	}
}
if (isset($_POST['idpelicula']) && !empty($_POST['idpelicula'])) {
	
	$idPelicula = $_POST['id'];
	$delete=mysqli_query($conexion, "Update peliculas Set idestado = 2 where idpelicula=$idPelicula");
	header("location:categorias.php");

	echo $idPelicula;
}

/*if(isset($_POST['delete']) && !empty($_POST['delete'])){ 
    require("conexion.php");
    $idproducto=$_POST['id'];
    $categoria=$_POST['categ'];
    $pagina=$_POST['pag'];
    $estado=mysqli_query($conexion,"SELECT idestado FROM pelicula_estados WHERE descripcion='inactivo'");
    while($r=mysqli_fetch_array($estado)){$idEstado=$r['idestado'];}
    $actualizar=mysqli_query($conexion,"UPDATE peliculas SET idestado=$idEstado WHERE idProducto=$idproducto");
    
    echo "<script>window.location.href ='productos.php?categoria=$categoria&pagina=$pagina';</script>";
}
?>*/
?>