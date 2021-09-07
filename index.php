<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
    body{
        background: url('pantalla.png') no-repeat fixed center;
        -webkit-background-size:cover;
        -moz-background-size:cover;
        -o-background-size:cover;
        background-size:cover;
        width: 100%;
        height: 100%;
        text-align: center;
    }
    
</style>
<title>Inicio Peliculas AFL cinema</title>
</head>
<body>
<?php
require("header.php");
if (isset($_GET['error'])&& $_GET['error']==1) {
    echo "<script type='text/javascript'>alert('el mail ingresado ya existe, intente con otro.');</script>";
}
if (isset($_GET['error'])&& $_GET['error']==2) {
    echo "<script type='text/javascript'>alert('Usuario o contraseña incorrecto.');</script>";
}
if (isset($_GET['estado'])&& $_GET['estado']==1) {
    echo "<script type='text/javascript'>alert('fue registrado con exito');</script>";
}
?>
</body>
</html>
