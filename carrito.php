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
      
        <th scope ="col">Película</th>
        <th scope ="col">Precio</th>
        <th scope ="col"></th>
        
</thead> 
<tbody class="carrito">

<?php
$cont=0;
   
  $datos=$_SESSION['carrito'];
  for ($i=0; $i<count($datos);$i++) {
    echo "<tr>";

      echo "<td>".$datos[$i]['Titulo']."</td>";
      echo "<td>$".$datos[$i]['Precio']."</td>";
      echo "<td><a href='#' id='btnBaja' class='btn btn-dark eliminar' data-id='{$datos[$i]['Id']}'>Eliminar</a></td>";
      
    echo "</tr>";
    
    $cont+=$datos[$i]['Precio'];

  }


  
 
          
// echo "<td><a href='abmproveedores.php'><button type='button' class='btn btn-danger'>Eliminar</button></a></td>";


?>
  <tr align="center">
     <th colspan="3"><?php echo "TOTAL A PAGAR: $".$cont;?></th>
  </tr>
</tbody>
  </table>
  <div align="center">  
        <form action="elegirMetodoPago.php" method="POST">
            <input type="text" name="total" id="total" value="<?php echo $cont;?>" hidden>
                  <button name="comprar" value="comprar" type="submit" class="btn btn-dark">Comprar</button>
                
        </form>
       </div>
  <?php }else{
       echo "<h3 style='color:white;' align='center'>El carrito esta vacio</h3>";
  }?>    
    </div>
  </div>
</div>
<script>
         
         $('.eliminar').click(function(e){
             e.preventDefault();
             var eliminar = confirm('De verdad desea eliminar esta película del carrito?');
             var id=$(this).attr('data-id');
             if(eliminar){
                  $(this).parentsUntil('.carrito').remove();
                  $.post('bajaCarrito.php',{
                        IdPelicula:id
                  },function(a){
                     if(a=='0'){
                        location.href="carrito.php";
                     }
                  });
            }
         
         });
      </script>
  
       
<?php 
  
    if (isset($_GET['estado'])&& $_GET['estado']==1) {
        echo "<script type='text/javascript'>alert('El cuit ingresado ya existe, intente con otro.');</script>";
    }
    
    ?>

</body>

</html>