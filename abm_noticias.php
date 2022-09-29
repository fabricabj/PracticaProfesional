<?php
require("conexion.php");
use BenMajor\ImageResize\Image;

require "vendor/autoload.php";

function imagen(){
    require("conexion.php");
    if (isset($_POST['Modificar'])) {
        $idnoticia=$_POST['idnoticia'];
        $consulta= "SELECT imagen from noticias where idnoticia='$idnoticia'";
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
if (isset($_POST['guardarNoticia']) && !empty($_POST['guardarNoticia'])) {
	
	$nombre_noticia = $_POST['nombre_noticia'];
	$descripcion = $_POST['descripcion'];
	$fecha=$_POST['fecha'];
	$nombreImg=imagen();
	$estado=$_POST['estado']; 
    $idproveedor=$_POST['idproveedor'];
	
	$Insert=mysqli_query($conexion,"INSERT INTO noticias values (00,'$nombre_noticia','$descripcion','$fecha','$nombreImg',$estado,$idproveedor)");	
		//echo"$Insert";
		header("location:noticias.php?pagina=1&estado=1");

} 
 if (isset($_POST['Modificar']) && !empty($_POST['Modificar'])) {
	
	$idnoticia = $_POST['id'];
	$nombre_noticia = $_POST['nombre_noticia'];
	$descripcion = $_POST['descripcion'];
	$fecha=$_POST['fecha'];
	$nombreImg=imagen();
	$idestado=$_POST['idestado'];
    $idproveedor=$_POST['idproveedor'];

	if (!is_null($nombreImg)) {
			$Actualizar = "UPDATE noticias SET nombre_noticia='$nombre_noticia',descripcion='$descripcion',fecha='$fecha',imagen='$nombreImg',idestado=$idestado,idproveedor='$idproveedor' WHERE idnoticia=$idnoticia";
			$enviar = mysqli_query($conexion, $Actualizar);
            header("location:noticias.php?pagina=1&estado=2");   		
	}else{
		$Actualizar = "UPDATE noticias SET nombre_noticia='$nombre_noticia',descripcion='$descripcion',fecha='$fecha',idestado=$idestado,idproveedor='$idproveedor' WHERE idnoticia=$idnoticia";
			$enviar = mysqli_query($conexion, $Actualizar);
            header("location:noticias.php?pagina=1&estado=2");   
	}
	}



	if (isset($_POST['delete']) && !empty($_POST['delete'])) {
		
		$idNoticia = $_POST['id'];
		$delete=mysqli_query($conexion, "update noticias set idestado = 2 where idnoticia='$idNoticia'");
	}

	if (isset($_POST['activar']) && !empty($_POST['activar'])) {
	
	$idNoticia = $_POST['id'];
	$delete=mysqli_query($conexion, "Update noticias Set idestado = 1 where idnoticia=$idNoticia");
	header("location:listarNoticias.php?pagina=1&est=2&estado=2");
	

}

?>