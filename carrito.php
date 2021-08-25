<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carrito</title>
</head>

<body>
<?php
require("header.php");
$usuario=$_SESSION['login'];
  include "conexion.php";
$consult=mysqli_query($conexion,"SELECT p.titulo,p.precio FROM peliculas AS p
                                 JOIN carrito AS c ON c.idpelicula=p.idpelicula  
                                 WHERE c.idusuario = $usuario");
?>
<div class="container">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <h3 class="text-center text-white">Listado de Carrito</h3>
    <table class="table table-light">
      <thead>
      
        <th scope ="col">pelicula</th>
        <th scope ="col">Precio</th>
        <th scope ="col"></th>
        
</thead> 
<?php
$cont=0;
while($fila=mysqli_fetch_array($consult)){
  
  echo "<tr>";
  echo "<td>"; echo $fila['titulo']; echo "</td>";
  echo "<td>"; echo $fila['precio']; echo "</td>";
  echo "</tr>";
  $cont+=$fila['precio'];
 
          
// echo "<td><a href='abmproveedores.php'><button type='button' class='btn btn-danger'>Eliminar</button></a></td>";


?>
      
  <?php }?>

  </table>
      
    </div>
  </div>
</div>

  
       <div align="center">  
           <a class="btn btn-primary" href="#">
                 <?php echo "total: ".$cont;?>
           </a>
       </div>
<?php 
  
    if (isset($_GET['estado'])&& $_GET['estado']==1) {
        echo "<script type='text/javascript'>alert('el cuit ingresado ya existe, intente con otro.');</script>";
    }
    ?>

</body>

</html>