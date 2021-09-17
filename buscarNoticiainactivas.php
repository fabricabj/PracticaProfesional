<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
</head>

<body>
    <?php   
    $asc = 0;

    if(!isset($_GET['pagina'])){
      header("location:buscarNoticiainactivas.php?pagina=1");
      }
      include "conexion.php";
      if (isset($_GET['pagina'])) {
        require("header.php");
      $nombre_noticia=$_POST['nombre_noticia']; 
  $sql = "SELECT * FROM noticias WHERE (nombre_noticia like '%$nombre_noticia%') AND idestado=2";
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
  $noticias_x_pag = 2;
  $total_noticias = mysqli_num_rows($consulta);
  $paginas = $total_noticias / $noticias_x_pag;
  $paginas = ceil($paginas);
  
    $iniciar = ($_GET['pagina'] - 1) * $noticias_x_pag;
    $resultado = mysqli_query($conexion,$sql . " limit $iniciar,$noticias_x_pag");
      }
    ?>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Listado de Noticias</h3>
        <form action="buscarNoticiainactivas.php?pagina=1" method="POST">
         
             <div class="input-group-prepend">
                  <input id="nombre_noticia" name="nombre_noticia" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="ingrese el titulo a buscar">
                  <div class="input-group-append">
                    <button style="border-color: white" class="btn btn-outline-dark" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>
            </div>
        </form>
        <table class="table table-light">
          <thead>
          
            <th scope ="col"><a href="listarNoticias.php?pagina=1&orden=idnoticia&ascendente=<?php echo $asc; ?>" >Id</a></th>
            <th scope ="col"><a href="listarNoticias.php?pagina=1&orden=nombre_noticia&ascendente=<?php echo $asc; ?>" >Nombre Noticia</a></th>
            <th scope ="col"><a href="listarNoticias.php?pagina=1&orden=descripcion&ascendente=<?php echo $asc; ?>" >Descripciòn</a></th>
            <!--<th scope ="col"><a href="listarNoticias.php?pagina=1&orden=mail&ascendente=<?php echo $asc; ?>" > Mail</a></th>-->
            <th scope ="col">Estado</th>
            <th><form action="altaNoticia.php" method="POST"> <button name='alta' value='alta' class="btn btn-warning">Nuevo</button></form></th>
          <th><a href="listarNoticias.php"><button type="button" class="btn btn-primary">Activas</button></a></th>
 
   
</thead> 
<?php
  
    while($fila = $resultado->fetch_assoc()){

      echo "<tr>";
      echo "<td>"; echo $fila['idnoticia']; echo "</td>";
      echo "<td>"; echo $fila['nombre_noticia']; echo "</td>";
      echo "<td>"; echo $fila['descripcion']; echo "</td>";
      //echo "<td>"; echo $fila['idestado']; echo "</td>";
      $tipoestado=mysqli_query($conexion,"SELECT idestado FROM noticias WHERE idnoticia='{$fila['idnoticia']}'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestado'];
                      } 
      $selectEstado=mysqli_query($conexion,"SELECT idestado,descripcion FROM estados_noticias WHERE idestado = $idTipoEstado ORDER BY descripcion ASC");
                      while($i=mysqli_fetch_array($selectEstado)){
                        $descripcion=$i['descripcion'];
                      } 
                      echo "<td>"; echo $descripcion; echo "</td>";

      echo "<td><form action='altaNoticia.php' method='post'>
                    <input name='idnoticia' id='idnoticia' value='".$fila['idnoticia']."' hidden>
                    <button type='submit' class='btn btn-success'>Modificar</button>
                </form>
            </td>";
              echo "<td><form action='abm_noticias.php' method='post'>
                    <input name='id' id='id' value='".$fila['idnoticia']."'hidden>
                    <button class='btn btn-danger' name='activar' id='activar' value='activar'>Activar</button>
                </form>
            </td>";
     
    }

  ?>
          </table>
          
        </div>
      </div>
  </div>
  <div class="container" style="padding-top:40px">
  <nav arial-label="page navigation">
    <ul class="pagination justify-content-center">
      <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>">
        <form action="buscarNoticiainactivas.php?pagina=<?php echo $_GET['pagina'] - 1 ?>" method="POST">
          <input id="nombre_noticia" name="nombre_noticia" value="<?php echo $nombre_noticia;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2">Anteriror</button>
          
        </form>
      </li>
      <?php for ($i = 1; $i <= $paginas; $i++) : ?>
       <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>">
         <form action="buscarNoticiainactivas.php?pagina=<?php echo $i ?>" method="POST">
          <input id="nombre_noticia" name="nombre_noticia" value="<?php echo $nombre_noticia;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2"><?php echo $i ?></button>
        </form>
      </li>
    <?php endfor ?>
    <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>">
     <form action="buscarNoticiainactivas.php?pagina=<?php echo $_GET['pagina'] + 1 ?>" method="POST">
      <input id="nombre_noticia" name="nombre_noticia" value="<?php echo $nombre_noticia;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
      <button name="buscar" value="buscar" class="page-link" id="button-addon2">Siguiente</button>
    </form>
  </li>
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