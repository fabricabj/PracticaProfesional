<?php

require("conexion.php");

$id=$_POST['idpelicula'];
    echo $id;
    $cantidadvisto=mysqli_query($conexion,"SELECT cantidad_visto FROM peliculas Where idpelicula=$id");
    while($c=mysqli_fetch_array($cantidadvisto)){
        $canti=$c['cantidad_visto'];
    }
        $cantis=$canti+1;

        $update=mysqli_query($conexion,"UPDATE peliculas SET cantidad_visto=$cantis Where idpelicula=$id");
    
    

?>