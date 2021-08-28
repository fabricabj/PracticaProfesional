<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estrenos</title>
</head>

<body>
    <?php   
    $asc = 0;
    
    if(!isset($_GET['pagina'])){
      header("location:listadoEstrenos.php?pagina=1");
      }
      include "conexion.php";
  $sql = "SELECT * FROM peliculas WHERE idestado=3 ";
  $consulta = mysqli_query($conexion,$sql);
  if(isset($_GET['orden'])){
    if(isset($_GET['ascendente'])){
      if($_GET['ascendente']==1){
        $sql2 = " ASC";
        $asc = 0;
      }else{
        $sql2 = " DESC";
        $asc = 1;
      }
    }
    $sql.=" ORDER BY " . $_GET['orden'] . $sql2;
  }
  $estrenos_x_pag = 2;
  $total_estrenos = mysqli_num_rows($consulta);
  $paginas = $total_estrenos / $estrenos_x_pag;
  $paginas = ceil($paginas);
  if (isset($_GET['pagina'])) {
    require("header.php");
    $iniciar = ($_GET['pagina'] - 1) * $estrenos_x_pag;
    $resultado = mysqli_query($conexion,$sql . " limit $iniciar,$estrenos_x_pag");
    ?>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Listado de Estrenos</h3>
        <table class="table table-light">
          <thead>
          
            <th scope ="col"><a href="listadoEstrenos.php?pagina=1&orden=idpelicula&ascendente=<?php echo $asc; ?>" >Id</a></th>
            <th scope ="col"><a href="listadoEstrenos.php?pagina=1&orden=titulo&ascendente=<?php echo $asc; ?>" >Titulo</a></th>
            <th scope ="col"><a href="listadoEstrenos.php?pagina=1&orden=descripcion&ascendente=<?php echo $asc; ?>" >Descripciòn</a></th>
            <<th scope ="col"><a href="listadoEstrenos.php?pagina=1&orden=anio&ascendente=<?php echo $asc; ?>" > Año</a></th>
            <th scope ="col">Estado</th>
            <th><form action="altaEstrenos.php" method="POST"> <button name='alta' value='alta' class="btn btn-warning">Nuevo</button></form></th>
          <th><a href="estrenosinactivas.php"><button type="button" class="btn btn-secondary">Inactivos</button></a></th>
</thead> 
<?php
  
    while($fila = $resultado->fetch_assoc()){

      echo "<tr>";
      echo "<td>"; echo $fila['idpelicula']; echo "</td>";
      echo "<td>"; echo $fila['titulo']; echo "</td>";
      echo "<td>"; echo $fila['descripcion']; echo "</td>";
      echo "<td>"; echo $fila['anio']; echo "</td>";
      $tipoestado=mysqli_query($conexion,"SELECT idestado FROM peliculas WHERE idpelicula='{$fila['idpelicula']}'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestado'];
                      } 
      $selectEstado=mysqli_query($conexion,"SELECT idestado,descripcion FROM pelicula_estados WHERE idestado = $idTipoEstado ORDER BY descripcion ASC");
                      while($i=mysqli_fetch_array($selectEstado)){
                        $descripcion=$i['descripcion'];
                      } 
                      echo "<td>"; echo $descripcion; echo "</td>";

      echo "<td><form action='altaEstrenos.php' method='post'>
                    <input name='titulo' id='titulo' value='".$fila['titulo']."' hidden>
                    <button type='submit' class='btn btn-success'>Modificar</button>
                </form>
            </td>";
              echo "<td><form action='abm_estrenos.php' method='post'>
                    <input name='idpelicula' id='idpelicula' value='".$fila['idpelicula']."'hidden>
                    <button type='submit' class='btn btn-danger' name='btnEliminar' id='btnEliminar' value='btnEliminar'>Eliminar</button>
                </form>
            </td>";
    
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
                                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="listadoEstrenos.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>
                                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="listadoEstrenos.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                                <?php endfor ?>
                                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="listadoEstrenos.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>

      <?php
        if (isset($_GET['estado'])&& $_GET['estado']==1) {
            echo "<script type='text/javascript'>alert('el cuit ingresado ya existe, intente con otro.');</script>";
        }
        ?>

</body>

</html>