<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estadisticas</title>
    <style>
      .ordenButton{
         border: none;
         color:#2979ff;
         font-weight: bold;
       
       }
       .ordenButton:hover{
         color:#1565c0;
         text-decoration: underline;
       }
       
    </style>
</head>

<body>
    <?php   
    $asc = 0;
    
    if(!isset($_GET['pagina'])){
      header("location:buscarEstadistica.php?pagina=1");
      }
      include "conexion.php";
      
  if (isset($_GET['pagina'])) {
    require("header.php");
    $nombre_pelicula=$_POST['nombre_pelicula'];
    $sql = "SELECT * FROM peliculas WHERE (titulo like '%$nombre_pelicula%') AND idestado=1";
  $consult = mysqli_query($conexion,$sql);
  if(isset($_POST['orden'])){
    if(isset($_POST['ascendente'])){
      if($_POST['ascendente']==1){
        $sql2 = " ASC";
        $asc = 0;
      }else{
        $sql2 = " DESC";
        $asc = 1;
      }
    }
    $sql.=" ORDER BY " . $_POST['orden'] . $sql2;
  }
  $peliculas_x_pag = 5;
  $total_peliculas = mysqli_num_rows($consult);
  $paginas = $total_peliculas / $peliculas_x_pag;
  $paginas = ceil($paginas);
    $iniciar = ($_GET['pagina'] - 1) * $peliculas_x_pag;
    $resultado = mysqli_query($conexion,$sql . " limit $iniciar,$peliculas_x_pag");
    ?>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Listado de Películas</h3>
        <form action="buscarEstadistica.php?pagina=1" method="POST">
             <div class="input-group-prepend">
             <input id="nombre_pelicula" name="nombre_pelicula" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Ingrese título a buscar">
                  <div class="input-group-append">
                    <button style="border-color: white" class="btn btn-outline-dark" type="submit" name="Buscar" value="Buscar" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>
            </div>
        </form>
        <table class="table table-light">
          <thead>
            <form action="buscarEstadistica.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="titulo" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $_POST['nombre_pelicula'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Titulo</button>
            </form>
            <form action="buscarEstadistica.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="anio" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $_POST['nombre_pelicula'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Año</button>
            </form>
            <form action="buscarEstadistica.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="cantidad_visto" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $_POST['nombre_pelicula'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Cant. Visto</button>
            </form>
            <form action="buscarEstadistica.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="cantidad_vendida" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $_POST['nombre_pelicula'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Cant. Vendido</button>
            </form>
            <th scope="col" class="col-2">Promedio Interacción <span title="(cantidad visto + cantidad vendido) / 2" class="badge badge-pill badge-info">Cálculo</span></th>
            <th scope ="col">Estado</th>
          </thead> 
<?php
  
    while($fila = $resultado->fetch_assoc()){

      echo "<tr>";
      echo "<td>"; echo $fila['titulo']; echo "</td>";
      echo "<td>"; echo $fila['anio']; echo "</td>";
      echo "<td>"; echo $fila['cantidad_visto']; echo "</td>";
      echo "<td>"; echo $fila['cantidad_vendida']; echo "</td>";
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
      $tipoestado=mysqli_query($conexion,"SELECT idestado FROM peliculas WHERE idpelicula='{$fila['idpelicula']}'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestado'];
                      } 
      $selectEstado=mysqli_query($conexion,"SELECT idestado,descripcion FROM pelicula_estados WHERE idestado = $idTipoEstado ORDER BY descripcion ASC");
                      while($i=mysqli_fetch_array($selectEstado)){
                        $descripcion=$i['descripcion'];
                      } 
                      echo "<td>"; echo $descripcion; echo "</td>";

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
      <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>">
        <form action="buscarEstadistica.php?pagina=<?php echo $_GET['pagina'] - 1 ?>" method="POST">
          <input id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $nombre_pelicula;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2">Anterior</button>
          
        </form>
      </li>
      <?php for ($i = 1; $i <= $paginas; $i++) : ?>
       <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>">
         <form action="buscarEstadistica.php?pagina=<?php echo $i ?>" method="POST">
          <input id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $nombre_pelicula;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2"><?php echo $i ?></button>
        </form>
      </li>
    <?php endfor ?>
    <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>">
     <form action="buscarEstadistica.php?pagina=<?php echo $_GET['pagina'] + 1 ?>" method="POST">
      <input id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $nombre_pelicula;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
      <button name="buscar" value="buscar" class="page-link" id="button-addon2">Siguiente</button>
    </form>
  </li>
</ul>
</nav>
</div>



      <?php

        ?>

</body>

</html>