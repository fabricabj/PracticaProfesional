
<?php
require("conexion.php");
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
                
                $errores=array();
                $file_name=$_FILES['imagen']['name'];
                $file_size=$_FILES['imagen']['size'];
                $file_tmp=$_FILES['imagen']['tmp_name'];
                $file_type=$_FILES['imagen']['type'];
                $file_ext=$_FILES['imagen']['name'];
                $file_ext=explode('.',$file_ext);
                $file_ext=end($file_ext);
                $file_ext=strtolower($file_ext);
                
                $extencionPermitidas= array("jpeg","jpg","png","gif","bmp");
                if (in_array($file_ext, $extencionPermitidas)==false) {
                    $errores[]='archivo no permitido,selecione una imagen...';
                }
                if ($file_size >=2897152) {
                    $errores[]='el archivo debe ser menor a 2Mb..';
                }
                if (empty($errores)==true) {
                    move_uploaded_file($file_tmp, "Imagenes/".$file_name);
                    return $file_name;
                }
                else{
                    
                    print_r($errores);
                    
                }
            }
            
            
        }
    }
    if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {
        $errores=0;
        $file_name=$_FILES['imagen']['name'];
        $file_size=$_FILES['imagen']['size'];
        $file_tmp=$_FILES['imagen']['tmp_name'];
        $file_type=$_FILES['imagen']['type'];
        $file_ext=$_FILES['imagen']['name'];
        $file_ext=explode('.',$file_ext);
        $file_ext=end($file_ext);
        $file_ext=strtolower($file_ext);
        
        $extencionPermitidas= array("jpeg","jpg","png","gif","bmp");
        if (in_array($file_ext, $extencionPermitidas)==false) {
            $errores+=1;
            header("location:altaEstrenos.php?imgEstado=$errores");
        }
        if ($file_size >=2897152) {
            $errores+=2;
            header("location:altaEstrenos.php?imgEstado=$errores");
        }
        if (empty($errores)==true) {
            move_uploaded_file($file_tmp, "Imagenes/".$file_name);
            return $file_name;
        }
        else{
            print_r($errores);
        }
    }
}
if (isset($_POST['guardar']) && !empty($_POST['guardar'])) {
	
	$titulo = $_POST['titulo'];
	$duracion = $_POST['duracion'];
	$puntaje = $_POST['puntaje'];
	$nombreImg=imagen();
	$descripcion = $_POST['descripcion'];
	$anio = $_POST['anio'];
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
		header("location:estrenos.php");         
	}else{
		$selectEstado=mysqli_query($conexion,"SELECT idestado FROM pelicula_estados WHERE descripcion='$estado'");
		while($r=mysqli_fetch_array($selectEstado)){
			$idestado=$r['idestado'];
		}
		$Insert=mysqli_query($conexion,"INSERT INTO peliculas values (00,'$titulo','$descripcion',$anio,$puntaje,null,'$duracion','$nombreImg',$idestado,'$generos',null,null,'$fecha_publicacion')");
		header("location:estrenos.php");

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
			header("location:estrenos.php");     
		}else{
		  if (!is_null($nombreImg)) {	
			$Actualizar = "UPDATE peliculas SET titulo='$titulo',descripcion='$descripcion',anio=$anio,puntaje=$puntaje,duracion='$duracion',imagen='$nombreImg',idestado=$idestado,categorias='$generos',fecha_publicacion='$fecha_publicacion' WHERE titulo='$titulo_anterior'";
			$enviar = mysqli_query($conexion, $Actualizar);
			header("location:estrenos.php");
			
		  }else{
			$Actualizar = "UPDATE peliculas SET titulo='$titulo',descripcion='$descripcion',anio=$anio,puntaje=$puntaje,duracion='$duracion',idestado=$idestado,categorias='$generos',fecha_publicacion='$fecha_publicacion' WHERE titulo='$titulo_anterior'";
			$enviar = mysqli_query($conexion, $Actualizar);
			header("location:estrenos.php"); 
		  }
		}
	}else{
		if (!is_null($nombreImg)) {	
			$Actualizar = "UPDATE peliculas SET titulo='$titulo',descripcion='$descripcion',anio=$anio,puntaje=$puntaje,duracion='$duracion',imagen='$nombreImg',idestado=$idestado,categorias='$generos',fecha_publicacion='$fecha_publicacion' WHERE titulo='$titulo_anterior'";
			$enviar = mysqli_query($conexion, $Actualizar);
			header("location:estrenos.php");
			
		  }else{
			$Actualizar = "UPDATE peliculas SET titulo='$titulo',descripcion='$descripcion',anio=$anio,puntaje=$puntaje,duracion='$duracion',idestado=$idestado,categorias='$generos',fecha_publicacion='$fecha_publicacion' WHERE titulo='$titulo_anterior'";
			$enviar = mysqli_query($conexion, $Actualizar);
			header("location:estrenos.php"); 
		  }
	}
}

//Se Elimina el estreno
if (isset($_POST['idpelicula']) && !empty($_POST['idpelicula'])) {
	$idPelicula = $_POST['idpelicula'];
	$delete=mysqli_query($conexion, "Update peliculas Set idestado = 2 where idpelicula=$idPelicula");
	header("location:estrenos.php");

}
//Se activa estrenosinactivas.php
if (isset($_POST['activar']) && !empty($_POST['activar'])) {
	$idPelicula = $_POST['id'];
	$delete=mysqli_query($conexion, "Update peliculas Set idestado = 3 where idpelicula=$idPelicula");
	header("location:listadoEstrenos.php");

}
//Se elimina listadoEstrenos.php
if (isset($_POST['idPelicula']) && !empty($_POST['idPelicula'])) {
	
	$idPelicula = $_POST['idPelicula'];
	$delete=mysqli_query($conexion, "Update peliculas Set idestado = 2 where idpelicula=$idPelicula");
	header("location:listadoEstrenos.php");

}


?>