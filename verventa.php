<?php
require("conexion.php");
session_start();

$idventa =$_POST['venta'];

$_SESSION['venta']=$idventa;

header("location:verfactura.php");



?>