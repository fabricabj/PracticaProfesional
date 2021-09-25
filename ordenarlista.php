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

      require("conexion.php");
      if (isset($_POST['ordenar']) && !empty($_POST['ordenar'])) {

        
      
          $orden=$_POST['orden'];
      
          $consulta=mysqli_query($conexion,"SELECT * from proveedores WHERE idestado= 1 ORDER BY $orden ASC");


          require("header.php");
          
    
    $resultado = mysqli_query($conexion, "SELECT * FROM proveedores WHERE idestado = 1 ORDER BY $orden ASC");
    ?>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Listado de Proveedores</h3>
        <table class="table table-light">
          <thead>
          
            <th scope ="col">Id</th>
            <th scope ="col">Razón Social</th>
            <th scope ="col">Cuit</th>
            <th scope ="col">Mail</th>
            <th scope ="col">Estado</th>
            <th><a href="altaproveedores.php"><button type="button" class="btn btn-warning">Nuevo</button></a></th>
            <th><a href="proveedoresinactivos.php"><button type="button" class="btn btn-secondary">Inactivos</button></a></th>
            <form action="ordenarlista.php" method="POST">
            <th><select  name="orden" class="form-control">
            <option value="idproveedor" selected> <?php echo "Id"; ?></option>
              <option value="razon_social"> <?php echo "Razon Social"; ?></option>
              <option value="cuit"> <?php echo "Cuit";  ?> </option>
              <option value="mail"> <?php echo "Mail";  ?> </option>
            </select></th><th>
            <button type="submit" value="ordenar" name="ordenar" class="btn btn-info">Ordenar</button></th>
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
      <?php 
      ?>
      <div class="container" style="padding-top:40px">
                        <nav arial-label="page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="ordenarlista.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>
                                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="ordenarlista.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                                <?php endfor ?>
                                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="ordenarlista.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>
                             <?php  
                             }

if (isset($_POST['ordenarinactivos']) && !empty($_POST['ordenarinactivos'])) {

        
      
$orden=$_POST['orden'];

$consulta=mysqli_query($conexion,"SELECT * from proveedores WHERE idestado= 2 ORDER BY $orden ASC");





require("header.php");

$resultado = mysqli_query($conexion, "SELECT * FROM proveedores WHERE idestado = 2 ORDER BY $orden ASC");
?>
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
  <th><a href="altaproveedores.php"><button type="button" class="btn btn-warning">Nuevo</button></a></th>
  <th><a href="proveedoresinactivos.php"><button type="button" class="btn btn-secondary">Inactivos</button></a></th>
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
<?php 
?>
<div class="container" style="padding-top:40px">
              <nav arial-label="page navigation">
                  <ul class="pagination justify-content-center">
                      <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="ordenarlista.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>
                      <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                          <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="ordenarlista.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                      <?php endfor ?>
                      <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="ordenarlista.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
                  </ul>
              </nav>
          </div>
                   <?php  }  
                   ?>
</body>

</html>