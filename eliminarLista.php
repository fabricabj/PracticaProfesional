<?php
session_start();
require("conexion.php");
$id=$_POST['id'];

$delete=mysqli_query($conexion,"DELETE FROM favoritos WHERE idpelicula='$id' AND idusuario='{$_SESSION['login']}'");

?>