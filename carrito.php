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

?>
<div class="container">
  <div class="col-sm-12 col-md-12 col-lg-12" style="padding-top:40px">
  <?php if(isset($_SESSION['carrito'])){?>
    <h3 class="text-center text-white">Listado de Carrito</h3>
    <table class="table table-dark table-striped">
      <thead>
      
        <th scope ="col">pelicula</th>
        <th scope ="col">Precio</th>
        <th scope ="col"></th>
        
</thead> 
<?php
$cont=0;
   
  $datos=$_SESSION['carrito'];
  for ($i=0; $i<count($datos);$i++) {
    echo "<tr>";

      echo "<td>".$datos[$i]['Titulo']."</td>";
      echo "<td>$".$datos[$i]['Precio']."</td>";
      echo "<td><a href='#' class='btn btn-dark'>Eliminar</a></td>";
      
    echo "</tr>";
    $cont+=$datos[$i]['Precio'];

  }


  
 
          
// echo "<td><a href='abmproveedores.php'><button type='button' class='btn btn-danger'>Eliminar</button></a></td>";


?>
  <tr align="center">
     <th colspan="3"><?php echo "TOTAL A PAGAR: $".$cont;?></th>
  </tr>
  </table>
  <div align="center">  
           <a class="btn btn-dark" href="#">
                 Comprar
           </a>
       </div>
  <?php }else{
       echo "<h3 style='color:white;' align='center'>El carrito esta vacio</h3>";
  }?>    
    </div>
  </div>
</div>

  
       
<?php 
  
    if (isset($_GET['estado'])&& $_GET['estado']==1) {
        echo "<script type='text/javascript'>alert('el cuit ingresado ya existe, intente con otro.');</script>";
    }
    
    ?>

</body>

</html>