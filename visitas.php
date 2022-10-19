<?php

require("conexion.php");
session_start();
$idgrupo = $_SESSION['grupo'];
if($idgrupo==2){

    $id=$_POST['idpelicula'];
    $cantidadvisto=mysqli_query($conexion,"SELECT cantidad_visto FROM peliculas Where idpelicula=$id");
    while($c=mysqli_fetch_array($cantidadvisto)){
        $canti=$c['cantidad_visto'];
    }
        $cantis=$canti+1;
        $update=mysqli_query($conexion,"UPDATE peliculas SET cantidad_visto=$cantis Where idpelicula=$id");
}

?>