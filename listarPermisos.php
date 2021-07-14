<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos</title>
</head>

<body>
    <?php   
    require("header.php");?>
    <div class="container">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <h3 class="text-center text-white">Listado de Grupos</h3>
            <table class="table table-light">
                    <th scope ="col">Grupo</th>
                    <th><a href="asignarpermisos.php"><button type="button" class="btn btn-primary">Nuevo</button></a></th>         
                    <?php
                      include "conexion.php";
                      $sentencia = "SELECT * FROM grupo";
                      $resultado = $conexion->query($sentencia) or die (mysqli_error($conexion));
                      while($fila = $resultado->fetch_assoc()){

                        echo "<tr>
                                  <td>".$fila['nombre_grupo']."</td>
                                   <td>
                                      <form action='FormModPermisos.php' method='post'>
                                          <input name='idgrupo' id='idgrupo' value='".$fila['idgrupo']."' hidden>
                                          <button type='submit' id='modificar' name='modificar' value='modificar' class='btn btn-success'>Modificar</button>
                                      </form>
                                   </td>
                                   <td>
                                      <form action='permisos.php' method='post'>
                                         <input name='idgrupo' id='idgrupo' value='".$fila['idgrupo']."' hidden>
                                         <button type='submit' id='modificar' name='baja' value='baja' class='btn btn-danger'>Eliminar</button>
                                      </form>
                                  </td>
                              </tr>";
                      }
                    ?>
            </table>
        </div>
    </div>
</body>
</html>