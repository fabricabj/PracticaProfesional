<?php
if(isset($_POST['delete']) && !empty($_POST['delete'])){ 
    require("conexion.php");
    $idpelicula=$_POST['idpelicula'];
    $idusuario=$_POST['idusuario'];
    $categoria=$_POST['categ'];
    $pagina=$_POST['pag'];
    
    $eliminar=mysqli_query($conexion,"DELETE FROM favoritos WHERE idusuario=$idusuario AND idpelicula=$idpelicula");
    echo "<script>window.location.href ='peliculas.php?genero=$categoria&pagina=$pagina&estado=2';</script>";
}
if(isset($_POST['alta']) && !empty($_POST['alta'])){ 
    require("conexion.php");
    $idpelicula=$_POST['idpelicula'];
    $idusuario=$_POST['idusuario'];
    $categoria=$_POST['categ'];
    $pagina=$_POST['pag'];
    
    $insert=mysqli_query($conexion,"INSERT INTO favoritos VALUES($idusuario,$idpelicula)");
    echo "<script>window.location.href ='peliculas.php?genero=$categoria&pagina=$pagina&estado=1';</script>";
}

?>