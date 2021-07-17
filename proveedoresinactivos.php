<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores inactivos</title>
</head>

<body>
    <?php   
    
    if(!isset($_GET['pagina'])){
      header("location:proveedoresinactivos.php?pagina=1");
      }
      include "conexion.php";
  
  $consulta = mysqli_query($conexion, "SELECT * FROM proveedores WHERE idestado = 2");
  $proveedores_x_pag = 2;
  $total_proveedores = mysqli_num_rows($consulta);
  $paginas = $total_proveedores / $proveedores_x_pag;
  $paginas = ceil($paginas);
  if (isset($_GET['pagina'])) {
    require("header.php");
    $iniciar = ($_GET['pagina'] - 1) * $proveedores_x_pag;
    $resultado = mysqli_query($conexion, "SELECT * FROM proveedores WHERE idestado = 2 limit $iniciar,$proveedores_x_pag");
    ?>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Listado de Proveedores Inactivos</h3>
        <table class="table table-light">
          <thead>
          
            <th scope ="col">Id</th>
            <th scope ="col">Razòn Social</th>
            <th scope ="col">Cuit</th>
            <th scope ="col">Mail</th>
            <th scope ="col">Estado</th>
            <th><a href="altaproveedores.php"><button type="button" class="btn btn-warning">Nuevo</button></a></th>
            <th><a href="proveedores.php"><button type="button" class="btn btn-primary">Activos</button></a></th>
            <form action="ordenarlista.php" method="POST">
            <th><select  name="orden" class="form-control">
              <option value="idproveedor"> <?php echo "Id"; ?></option>
              <option value="razon_social"> <?php echo "Razon Social"; ?></option>
              <option value="cuit"> <?php echo "Cuit";  ?> </option>
              <option value="mail"> <?php echo "Mail";  ?> </option>
            </select></th><th>
            <button type="submit" value="ordenarinactivos" name="ordenarinactivos" class="btn btn-info">Ordenar</button></th>
            </form>
</thead> 
<?php
  
    while($fila = $resultado->fetch_assoc()){

      echo "<tr>";
      echo "<td>"; echo $fila['idproveedor']; echo "</td>";
      echo "<td>"; echo $fila['razon_social']; echo "</td>";
      echo "<td>"; echo $fila['cuit']; echo "</td>";
      echo "<td>"; echo $fila['mail']; echo "</td>";
      $tipoestado=mysqli_query($conexion,"SELECT idestado FROM proveedores WHERE cuit='{$fila['cuit']}'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestado'];
                      } 
      $selectEstado=mysqli_query($conexion,"SELECT idestado,descripcion FROM estados_provedores WHERE idestado = $idTipoEstado ORDER BY descripcion ASC");
                      while($i=mysqli_fetch_array($selectEstado)){
                        $descripcion=$i['descripcion'];
                      } 
                      echo "<td>"; echo $descripcion; echo "</td>";
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
  </div>
      <?php }
      ?>
      <div class="container" style="padding-top:40px">
                        <nav arial-label="page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="proveedoresinactivos.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>
                                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="proveedoresinactivos.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                                <?php endfor ?>
                                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="proveedoresinactivos.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>

</body>

</html>