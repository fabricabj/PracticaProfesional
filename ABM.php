
<?php
require("conexion.php");
use BenMajor\ImageResize\Image;

require "vendor/autoload.php";
function imagen(){
	require("conexion.php");
    if (isset($_POST['Modificar'])) {
        $titulo=$_POST['titulo'];
        $consulta= "SELECT imagen from peliculas where titulo='$titulo'";
        $query=mysqli_query($conexion,$consulta);
       //     $imgBD=$query->fetch_array(MYSQL_ASSOC);
        
        if (empty($_FILES['imagen'])) {
            return $imgBD['imagen'];
        }else{
            if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {
                
                $errores=0;
       
				$extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
				$name = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME).".".$extension;
				$mimeType = $_FILES['imagen']['type'];

				$extension2 = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
				$name2 = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME).".".$extension;
				$mimeType2 = $_FILES['imagen']['type'];

				# Generate a new image resize object using a upload image:
				$image = new Image($_FILES['imagen']['tmp_name']);
				$image2 = new Image($_FILES['imagen']['tmp_name']);

				if ($mimeType == "imagen/png" || $mimeType == "imagen/gif" || $mimeType == "imagen/svg+xml" || $mimeType == "imagen/svg") {
					
					$image->setTransparency(true); // agregar transparencia si el formato de imagen acepta transparencia
				} else {
					$image->setTransparency(false); // no agregar transparencia si el formato de la imagen no acepta transparencia
				}
				
					

				# Set the background to white:
				$image->setBackgroundColor('#212121');

				# Contain the image:
				$image->contain(200);

				$image->output("imagenes");
				$image2->output("ImagenesOriginales"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres

				# Renombrar la imagen genereda por el metodo output
				
				rename($image->getOutputFilename(), 'imagenes/'.$name);
				rename($image2->getOutputFilename(), 'ImagenesOriginales/'.$name2);
				}

				if (empty($errores)==true) {
					move_uploaded_file($image, "Imagenes/".$name);
					move_uploaded_file($image2, "ImagenesOriginales/".$name2);
					return $name;
				}
				else{
					
					print_r($errores);
					
				}
            }
            
            
	}
    
    if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {

    $errores=0;
       
	$extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $name = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME).".".$extension;
    $mimeType = $_FILES['imagen']['type'];

	$extension2 = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $name2 = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME).".".$extension;
    $mimeType2 = $_FILES['imagen']['type'];

    # Generate a new image resize object using a upload image:
    $image = new Image($_FILES['imagen']['tmp_name']);
    $image2 = new Image($_FILES['imagen']['tmp_name']);

    if ($mimeType == "imagen/png" || $mimeType == "imagen/gif" || $mimeType == "imagen/svg+xml" || $mimeType == "imagen/svg") {
	      
        $image->setTransparency(true); // agregar transparencia si el formato de imagen acepta transparencia
    } else {
        $image->setTransparency(false); // no agregar transparencia si el formato de la imagen no acepta transparencia
    }
	
		

    # Set the background to white:
    $image->setBackgroundColor('#212121');

    # Contain the image:
    $image->contain(200);

    $image->output("imagenes");
	$image2->output("ImagenesOriginales"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres

    # Renombrar la imagen genereda por el metodo output
    
    rename($image->getOutputFilename(), 'imagenes/'.$name);
	rename($image2->getOutputFilename(), 'ImagenesOriginales/'.$name2);
    }

	if (empty($errores)==true) {
		move_uploaded_file($image, "Imagenes/".$name);
		move_uploaded_file($image2, "ImagenesOriginales/".$name2);
		return $name;
	}
	else{
		
		print_r($errores);
		
	}

	
}
if (isset($_POST['guardar']) && !empty($_POST['guardar'])) {
	
	$titulo = $_POST['titulo'];
	$duracion = $_POST['duracion'];
	$puntaje = $_POST['puntaje'];
	$nombreImg=imagen();
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
		$Insert=mysqli_query($conexion,"INSERT INTO peliculas values (00,'$titulo','$descripcion',$anio,$puntaje,$precio,'$duracion','$nombreImg',$idestado,'$generos',0,0,'$fecha_publicacion')");
		header("location:categorias.php?genero=$generos&estado=1");

	}
}
if (isset($_POST['Modificar']) && !empty($_POST['Modificar'])) {
	
	$titulo = $_POST['titulo'];
	$titulo_anterior = $_POST['titulo_anterior'];
	$duracion = $_POST['duracion'];
	$puntaje = $_POST['puntaje'];
	$nombreImg=imagen();
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
		  if (!is_null($nombreImg)) {	
			$Actualizar = "UPDATE peliculas SET titulo='$titulo',descripcion='$descripcion',anio=$anio,puntaje=$puntaje,precio=$precio,duracion='$duracion',imagen='$nombreImg',idestado=$idestado,categorias='$generos',fecha_publicacion='$fecha_publicacion' WHERE titulo='$titulo_anterior'";
			$enviar = mysqli_query($conexion, $Actualizar);
			header("location:categorias.php?genero=$generos&estado=2");
			
		  }else{
			$Actualizar = "UPDATE peliculas SET titulo='$titulo',descripcion='$descripcion',anio=$anio,puntaje=$puntaje,precio=$precio,duracion='$duracion',idestado=$idestado,categorias='$generos',fecha_publicacion='$fecha_publicacion' WHERE titulo='$titulo_anterior'";
			$enviar = mysqli_query($conexion, $Actualizar);
			header("location:categorias.php?genero=$generos&estado=2"); 
		  }
		}
	}else{
		if (!is_null($nombreImg)) {	
			$Actualizar = "UPDATE peliculas SET titulo='$titulo',descripcion='$descripcion',anio=$anio,puntaje=$puntaje,precio=$precio,duracion='$duracion',imagen='$nombreImg',idestado=$idestado,categorias='$generos',fecha_publicacion='$fecha_publicacion' WHERE titulo='$titulo_anterior'";
			$enviar = mysqli_query($conexion, $Actualizar);
			header("location:categorias.php?genero=$generos&estado=2");
			
		  }else{
			$Actualizar = "UPDATE peliculas SET titulo='$titulo',descripcion='$descripcion',anio=$anio,puntaje=$puntaje,precio=$precio,duracion='$duracion',idestado=$idestado,categorias='$generos',fecha_publicacion='$fecha_publicacion' WHERE titulo='$titulo_anterior'";
			$enviar = mysqli_query($conexion, $Actualizar);
			header("location:categorias.php?genero=$generos&estado=2"); 
		  }
	}
}


if (isset($_POST['delete']) && !empty($_POST['delete'])) {
	
	$idPelicula = $_POST['id'];
	$delete=mysqli_query($conexion, "Update peliculas Set idestado = 2 where idpelicula=$idPelicula");
	header("location:peliculas.php?genero=$nombre_genero&estado=4");

}
if (isset($_POST['deleteEstreno']) && !empty($_POST['deleteEstreno'])) {
	
	$idPelicula = $_POST['id'];
	$delete=mysqli_query($conexion, "Update peliculas Set idestado = 4 where idpelicula=$idPelicula");
	header("location:estrenos.php");

}


if (isset($_POST['activar']) && !empty($_POST['activar'])) {
	
	$idPelicula = $_POST['id'];
	$delete=mysqli_query($conexion, "Update peliculas Set idestado = 1 where idpelicula=$idPelicula");
	header("location:listarpeliculas.php?pagina=1&est=2&estado=2");

}


?>