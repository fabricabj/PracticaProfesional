<?php
require("conexion.php");
use BenMajor\ImageResize\Image;
session_start();

require "vendor/autoload.php";
function imagen(){

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
    
        $image->output("imagenesComprobante");
        $image2->output("ImagenesOriginalesComprobante"); // Asegurate que la carpeta donde lo vas a guardar permita lectura y escritura, tambien verifica sus carpetas padres
    
        # Renombrar la imagen genereda por el metodo output
        
        rename($image->getOutputFilename(), 'imagenesComprobante/'.$name);
        rename($image2->getOutputFilename(), 'ImagenesOriginalesComprobante/'.$name2);
        }
    
        if (empty($errores)==true) {
            move_uploaded_file($image, "imagenesComprobante/".$name);
            move_uploaded_file($image2, "ImagenesOriginalesComprobante/".$name2);
            return $name;
        }
        else{
            
            print_r($errores);
            
        }
    
        
    }

if (isset($_POST['enviar']) && !empty($_POST['enviar'])) {
    $nombreImg=imagen();
    $fechapago=$_POST['fechaPago'];
    $tipopago=$_POST['tipoPago'];
    $totalpagar=$_POST['totalpagar'];
    $idusuario=$_SESSION['login'];

    $Insert=mysqli_query($conexion,"INSERT INTO detalle_pago values (00,'$fechapago',NULL,NULL,NULL,NULL,$tipopago)");
    $select=mysqli_query($conexion,"SELECT iddetalle_pago FROM detalle_pago WHERE (SELECT MAX(iddetalle_pago) FROM detalle_pago)"); 
    while($r=mysqli_fetch_array($select)){
        $iddetalle_pago=$r['iddetalle_pago'];
    }
    $Insert2=mysqli_query($conexion,"INSERT INTO ventas values (00,{$_SESSION['login']},$totalpagar,'$fechapago',2,$iddetalle_pago)");
    $select2=mysqli_query($conexion,"SELECT idventa FROM ventas WHERE (SELECT MAX(idventa) FROM ventas)");
    while($r=mysqli_fetch_array($select2)){
        $idventa=$r['idventa'];
    }
    $datos=$_SESSION['carrito'];
    for ($i=0; $i<count($datos);$i++) {
        $Insert3=mysqli_query($conexion,"INSERT INTO venta_detalles values({$datos[$i]['Id']},$idventa,{$datos[$i]['Precio']},2)");
        $cantidadvendida=mysqli_query($conexion,"SELECT cantidad_vendida FROM peliculas Where idpelicula={$datos[$i]['Id']}");
        while($c=mysqli_fetch_array($cantidadvendida)){
            $canti=$c['cantidad_vendida'];
    }
        $cantis=$canti+1;

        $update=mysqli_query($conexion,"UPDATE peliculas SET cantidad_vendida=$cantis Where idpelicula={$datos[$i]['Id']}");
    }
   
    unset($_SESSION['carrito']);

    $Insert=mysqli_query($conexion,"INSERT INTO comprobantes values (00,$idusuario,'$nombreImg','$fechapago',$tipopago,$totalpagar,3,$idventa)");
    header("location:index.php");
}
