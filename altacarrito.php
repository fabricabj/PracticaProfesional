<?php

session_start();
require("conexion.php");
$categoria=$_POST['genero'];
$pagina=$_POST['pagina'];
if(isset($_SESSION['carrito'])){

       if(isset($_POST['id'])){
        $arreglo=$_SESSION['carrito'];
        $encontro=false;
        $numero=0;
        for ($i=0; $i<count($arreglo) ; $i++) { 
            if ($arreglo[$i]['Id']==$_POST['id']) {
                $encontro=true;
                $numero=$i;
            }
        }
        if ($encontro==true) {
            if(!isset($_POST['pagina'])){
                header("location:index.php?retorno=2");
            }else{
                header("location:peliculas.php?genero=$categoria&pagina=$pagina&estadocarrito=2");
            }
        }else{
            $nombre="";
         $precio=0;
         $img="";
         $registro=mysqli_query($conexion,"select * from peliculas where idpelicula=".$_POST['id'])or die("Problemas en el select:".mysqli_error($conexion));;
         while ($r=mysqli_fetch_array($registro)) {
             $titulo=$r['titulo'];
             $precio=$r['precio'];
    
         }
         $peliNuevo=array('Id'=>$_POST['id'],
                        'Titulo'=>$titulo,
                        'Precio'=>$precio
        );            
         array_push($arreglo, $peliNuevo);
         $_SESSION['carrito']=$arreglo;
         if(!isset($_POST['pagina'])){
            header("location:index.php?retorno=1");
         }else{
            header("location:peliculas.php?genero=$categoria&pagina=$pagina&estadocarrito=1");
         }
        
        }
    }
}else{
     if(isset($_POST['id'])){
         $titulo="";
         $precio=0;
         $registro=mysqli_query($conexion,"select * from peliculas where idpelicula=".$_POST['id'])or die("Problemas en el select:".mysqli_error($conexion));;
         while ($r=mysqli_fetch_array($registro)) {
             $titulo=$r['titulo'];
             $precio=$r['precio'];
 
         }
         $arreglo[]=array('Id'=>$_POST['id'],
                        'Titulo'=>$titulo,
                        'Precio'=>$precio
        );
         $_SESSION['carrito']=$arreglo;
            if(!isset($_POST['pagina'])){
                header("location:index.php?retorno=1");
            }
            else{
                header("location:peliculas.php?genero=$categoria&pagina=$pagina&estadocarrito=1");
            }
         
     }
 }
?>

