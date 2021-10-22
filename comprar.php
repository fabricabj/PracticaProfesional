<?php
require("conexion.php");
session_start();
if (isset($_POST['aceptar']) && !empty($_POST['aceptar'])) {

$cliente =$_POST['cliente'];
$codigo = $_POST['codigo'];
$fechaVto = $_POST['fechaVto'];
$nTarjeta =$_POST['nTarjeta'];
$fechaPago =$_POST['fechaPago'];
$tipoPago =$_POST['tipoPago'];
$totalPagar =$_POST['totalpagar'];
    
$Insert=mysqli_query($conexion,"INSERT INTO detalle_pago values (00,'$fechaPago','$cliente','$fechaVto',$nTarjeta,$codigo,$tipoPago)");
$select=mysqli_query($conexion,"SELECT iddetalle_pago FROM detalle_pago WHERE (SELECT MAX(iddetalle_pago) FROM detalle_pago)");
while($r=mysqli_fetch_array($select)){
    $iddetalle_pago=$r['iddetalle_pago'];
}
$Insert2=mysqli_query($conexion,"INSERT INTO ventas values (00,{$_SESSION['login']},$totalPagar,'$fechaPago',1,$iddetalle_pago)");
$select2=mysqli_query($conexion,"SELECT idventa FROM ventas WHERE (SELECT MAX(idventa) FROM ventas)");
while($r=mysqli_fetch_array($select2)){
    $idventa=$r['idventa'];
}
$datos=$_SESSION['carrito'];
for ($i=0; $i<count($datos);$i++) {
    $Insert3=mysqli_query($conexion,"INSERT INTO venta_detalles values({$datos[$i]['Id']},$idventa,{$datos[$i]['Precio']})");
}
unset($_SESSION['carrito']);



header("location:index.php");
}
?>