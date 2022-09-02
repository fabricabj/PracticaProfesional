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
    $Insert3=mysqli_query($conexion,"INSERT INTO venta_detalles values({$datos[$i]['Id']},$idventa,{$datos[$i]['Precio']},1)");
    $cantidadvendida=mysqli_query($conexion,"SELECT cantidad_vendida FROM peliculas Where idpelicula={$datos[$i]['Id']}");
    while($c=mysqli_fetch_array($cantidadvendida)){
        $canti=$c['cantidad_vendida'];
    }
        $cantis=$canti+1;

        $update=mysqli_query($conexion,"UPDATE peliculas SET cantidad_vendida=$cantis Where idpelicula={$datos[$i]['Id']}");
}
$_SESSION['venta']=$idventa;
unset($_SESSION['carrito']);

header("location:altafactura.php");

}

if (isset($_POST['enviar']) && !empty($_POST['enviar'])) {

$fechaPago =$_POST['fechaPago'];
$tipoPago =$_POST['tipoPago'];
$totalPagar =$_POST['totalpagar'];
$comprobante =$_POST['comprobante'];
$idventa =$_POST['idventa'];
    
$Update=mysqli_query($conexion,"UPDATE comprobantes SET idestado=1 WHERE idcomprobante=$comprobante");

$Update1=mysqli_query($conexion,"UPDATE ventas SET idestados=1 WHERE idventa = $idventa");

$Update2=mysqli_query($conexion,"UPDATE venta_detalles SET idestado=1 WHERE idventa = $idventa");

$_SESSION['venta']=$idventa;

header("location:altafactura.php");

}
?>