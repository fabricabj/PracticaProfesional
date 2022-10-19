<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estadísticas</title>
  
</head>

<body>

  <?php
  $asc = 0;

  if (!isset($_GET['pagina'])) {
    header("location:verEstadisticas.php?pagina=1");
  }
  include "conexion.php";
  $sql = "SELECT * FROM peliculas WHERE idestado = 1 OR idestado = 2";
  $consulta = mysqli_query($conexion, $sql);
  if (isset($_GET['orden'])) {
    if (isset($_GET['ascendente'])) {
      if ($_GET['ascendente'] == 1) {
        $sql2 = " ASC";
        $asc = 0;
      } else {
        $sql2 = " DESC";
        $asc = 1;
      }
    }
    $sql .= " ORDER BY " . $_GET['orden'] . $sql2;
  }
  $peliculas_x_pag = 5;
  $total_peliculas = mysqli_num_rows($consulta);
  $paginas = $total_peliculas / $peliculas_x_pag;
  $paginas = ceil($paginas);
  if (isset($_GET['pagina'])) {
    require("header.php");
    $iniciar = ($_GET['pagina'] - 1) * $peliculas_x_pag;
    $resultado = mysqli_query($conexion, $sql . " limit $iniciar,$peliculas_x_pag");
  ?>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Estadísticas</h3>
        <form action="buscarEstadistica.php?pagina=1" method="POST">
          <div class="input-group-prepend">
            <input id="nombre_pelicula" name="nombre_pelicula" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Ingrese título a buscar">
            <div class="input-group-append">
              <button style="border-color: white" class="btn btn-outline-dark" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </form>
        <table class="table table-light">
          <thead>

            <th scope="col"><a href="verEstadisticas.php?pagina=1&orden=titulo&ascendente=<?php echo $asc; ?>">Título</a></th>
            <th scope="col"><a href="verEstadisticas.php?pagina=1&orden=anio&ascendente=<?php echo $asc; ?>">Año</a></th>
            <th scope="col"><a href="verEstadisticas.php?pagina=1&orden=cantidad_vendida&ascendente=<?php echo $asc; ?>">Cant. Vendido</a></th>
            <th scope="col"><a href="verEstadisticas.php?pagina=1&orden=cantidad_visto&ascendente=<?php echo $asc; ?>">Cant. Visto</a></th>
            <th scope="col" class="col-2">Promedio Interacción <span title="(cantidad visto + cantidad vendido) / 2" class="badge badge-pill badge-info">Cálculo</span></th>
            <th scope="col">Estado</th>
          </thead>
          <?php

          while ($fila = $resultado->fetch_assoc()) {

            echo "<tr>";
            echo "<td>";
            echo $fila['titulo'];
            echo "</td>";
            echo "<td>";
            echo $fila['anio'];
            echo "</td>";
            echo "<td>";
            echo $fila['cantidad_vendida'];
            echo "</td>";
            echo "<td>";
            echo $fila['cantidad_visto'];
            echo "</td>";
            echo "<td>";

            // divido la cant de vistas sobre cant vendida, calculo cada cuanto se hizo una venta. 
              // no estoy segura, estoy ebria
            if(($fila['cantidad_visto'] != 0) && ($fila['cantidad_vendida'] != 0)){              
              $numero = (($fila['cantidad_vendida'] * 100) / $fila['cantidad_visto']);
              //formateo dos decimales
              echo number_format($numero, 2, '.', '');
            }else{
              echo 0;
            }
            echo "</td>";
            $tipoestado = mysqli_query($conexion, "SELECT idestado FROM peliculas WHERE idpelicula='{$fila['idpelicula']}'");
            while ($i = mysqli_fetch_array($tipoestado)) {
              $idTipoEstado = $i['idestado'];
            }
            $selectEstado = mysqli_query($conexion, "SELECT idestado,descripcion FROM pelicula_estados WHERE idestado = $idTipoEstado ORDER BY descripcion ASC");
            while ($i = mysqli_fetch_array($selectEstado)) {
              $descripcion = $i['descripcion'];
            }
            echo "<td>";
            echo $descripcion;
            echo "</td>";

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
        <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="verEstadisticas.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>
        <?php for ($i = 1; $i <= $paginas; $i++) : ?>
          <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="verEstadisticas.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
        <?php endfor ?>
        <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="verEstadisticas.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
      </ul>
    </nav>
  </div>

  <?php

  if (isset($_GET['estado']) && $_GET['estado'] == 1) {
    echo "<script type='text/javascript'>alert('El cuit ingresado ya existe, intente con otro.');</script>";
  }
  ?>

</body>

</html>