<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
</head>

<body>
    <?php   
    require("header.php");?>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Listado de Proveedores</h3>
        <table class="table table-light">
          <thead>
          
            <th scope ="col">Id</th>
            <th scope ="col">Razòn Social</th>
            <th scope ="col">Cuit</th>
            <th scope ="col">Mail</th>
            <th scope ="col">Estado</th>
            <th><a href="altaproveedores.php"><button type="button" class="btn btn-primary">Nuevo</button></a></th>         
</thead> 
<?php
  include "conexion.php";
  $sentencia = "SELECT * FROM proveedores WHERE idestado = 1";
  $resultado = $conexion->query($sentencia) or die (mysqli_error($conexion));
  while($fila = $resultado->fetch_assoc()){

    echo "<tr>";
    echo "<td>"; echo $fila['idproveedor']; echo "</td>";
    echo "<td>"; echo $fila['razon_social']; echo "</td>";
    echo "<td>"; echo $fila['cuit']; echo "</td>";
    echo "<td>"; echo $fila['mail']; echo "</td>";
    echo "<td>"; echo $fila['idestado']; echo "</td>";
   echo "<td><form action='modificarproveedores.php' method='post'>
                  <input name='cuit' id='cuit' value='".$fila['cuit']."' hidden>
                  <button type='submit' class='btn btn-success'>Modificar</button>
              </form>
          </td>";
            echo "<td><form action='abmproveedores.php' method='post'>
                  <input name='cuit' id='cuit' value='".$fila['cuit']."'hidden>
                  <button type='submit' class='btn btn-danger' name='btnEliminar' id='btnEliminar' value='btnEliminar'>Eliminar</button>
              </form>
          </td>";
   // echo "<td><a href='abmproveedores.php'><button type='button' class='btn btn-danger'>Eliminar</button></a></td>";
  }
?>
        </table>
      </div>
    </div>

</body>

</html>