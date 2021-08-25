<?php
session_start();
require("conexion.php");

$idusuario=$_SESSION['login'];
$idpelicula=$_POST['id'];
$genero=$_POST['genero'];
$pagina=$_POST['pagina'];

$Insert=mysqli_query($conexion,"INSERT INTO carrito VALUES($idpelicula,$idusuario)");
header("location: peliculas.php?genero=$genero&pagina=$pagina&estado=1");

?>