<?php
require("conexion.php");
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
            header("location:altaNoticia.php?imgEstado=$errores");
        }
        if ($file_size >=2897152) {
            $errores+=2;
            header("location:altaNoticia.php?imgEstado=$errores");
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
if (isset($_POST['guardarNoticia']) && !empty($_POST['guardarNoticia'])) {
	
	$nombre_noticia = $_POST['nombre_noticia'];
	$descripcion = $_POST['descripcion'];
	$fecha=$_POST['fecha'];
	$nombreImg=imagen();
	$estado=$_POST['estado']; 
    $idproveedor=$_POST['idproveedor'];
	
	$Insert=mysqli_query($conexion,"INSERT INTO noticias values (00,'$nombre_noticia','$descripcion','$fecha','$nombreImg',$estado,$idproveedor)");	
		//echo"$Insert";
		header("location:noticias.php");

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
            header("location:noticias.php");   		
	}else{
		$Actualizar = "UPDATE noticias SET nombre_noticia='$nombre_noticia',descripcion='$descripcion',fecha='$fecha',idestado=$idestado,idproveedor='$idproveedor' WHERE idnoticia=$idnoticia";
			$enviar = mysqli_query($conexion, $Actualizar);
            header("location:noticias.php");   
	}
	}



	if (isset($_POST['idnoticia']) && !empty($_POST['idnoticia'])) {
		
		$idNoticia = $_POST['idnoticia'];
		$delete=mysqli_query($conexion, "update noticias set idestado = 2 where idnoticia='$idNoticia'");
		header("location:listarNoticias.php");
	}

	if (isset($_POST['activar']) && !empty($_POST['activar'])) {
	
	$idNoticia = $_POST['id'];
	$delete=mysqli_query($conexion, "Update noticias Set idestado = 1 where idnoticia=$idNoticia");
	header("location:noticiasinactivas.php");
	

}

?>