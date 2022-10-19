<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Películas</title>
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
      header("location:listarpeliculas.php?pagina=1");
      }
      include "conexion.php";
      
  if (isset($_GET['pagina'])) {
    require("header.php");
    $nombre_pelicula=$_POST['nombre_pelicula'];
    $est=$_POST['estado'];
    $sql = "SELECT * FROM peliculas WHERE (titulo like '%$nombre_pelicula%') AND idestado=$est";
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
        <form action="buscarPelicula.php?pagina=1" method="POST">
             <div class="input-group-prepend">
             <input id="nombre_pelicula" name="nombre_pelicula" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Ingrese título a buscar">
                  <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
                  <div class="input-group-append">
                    <button style="border-color: white" class="btn btn-outline-dark" type="submit" name="Buscar" value="Buscar" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>
            </div>
        </form>
        <table class="table table-light">
          <thead>
            <form action="buscarPelicula.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="idpelicula" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="estado" name="estado" value="<?php echo $_POST['estado'];?>" hidden>
                <input type="text" id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $_POST['nombre_pelicula'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Id</button>
            </form>
            <form action="buscarPelicula.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="titulo" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="estado" name="estado" value="<?php echo $_POST['estado'];?>" hidden>
                <input type="text" id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $_POST['nombre_pelicula'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Titulo</button>
            </form>
            <form action="buscarPelicula.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="anio" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="estado" name="estado" value="<?php echo $_POST['estado'];?>" hidden>
                <input type="text" id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $_POST['nombre_pelicula'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Año</button>
            </form>
            <form action="buscarPelicula.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="precio" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="estado" name="estado" value="<?php echo $_POST['estado'];?>" hidden>
                <input type="text" id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $_POST['nombre_pelicula'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Precio</button>
            </form>
            <form action="buscarPelicula.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="categorias" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="estado" name="estado" value="<?php echo $_POST['estado'];?>" hidden>
                <input type="text" id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $_POST['nombre_pelicula'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Categorías</button>
            </form>
            <th scope ="col">Estado</th>
          </thead> 
<?php
  
    while($fila = $resultado->fetch_assoc()){

      echo "<tr>";
      echo "<td>"; echo $fila['idpelicula']; echo "</td>";
      echo "<td>"; echo $fila['titulo']; echo "</td>";
      echo "<td>"; echo $fila['anio']; echo "</td>";
      echo "<td>"; echo '$' . $fila['precio']; echo "</td>";
      echo "<td>"; echo $fila['categorias']; echo "</td>";
      $tipoestado=mysqli_query($conexion,"SELECT idestado FROM peliculas WHERE idpelicula='{$fila['idpelicula']}'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestado'];
                      } 
      $selectEstado=mysqli_query($conexion,"SELECT idestado,descripcion FROM pelicula_estados WHERE idestado = $idTipoEstado ORDER BY descripcion ASC");
                      while($i=mysqli_fetch_array($selectEstado)){
                        $descripcion=$i['descripcion'];
                      } 
                      echo "<td>"; echo $descripcion; echo "</td>";

      echo "<td><form action='AltaMod.php' method='post'>
                    <input name='titulo' id='titulo' value='".$fila['titulo']."' hidden>
                    <button type='submit' class='btn btn-success'>Modificar</button>
                </form>
            </td>";
      if($est==1){
        echo '<td><input type="text" name="eliminarPelicula" id="eliminarPelicula" value="eliminarPelicula" hidden>
              <input type="text" name="pagina" id="pagina" value="'.$_GET['pagina'].'" hidden>
              <a style="margin: 5px;" href="#" onclick="eliminarPelicula('.$fila['idpelicula'].','.$_GET['pagina'].','.$est.')" class="btn btn-danger">Inactivar</a></td>';
      }else{  
        echo "<td><form action='ABM.php' method='post'>
                <input name='id' id='id' value='".$fila['idpelicula']."'hidden>
                <button class='btn btn-danger' name='activar' id='activar' value='activar'>Activar</button>
              </form>
            </td>";
        }
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
        <form action="buscarPelicula.php?pagina=<?php echo $_GET['pagina'] - 1 ?>" method="POST">
          <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
          <input id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $nombre_pelicula;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2">Anterior</button>
          
        </form>
      </li>
      <?php for ($i = 1; $i <= $paginas; $i++) : ?>
       <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>">
         <form action="buscarPelicula.php?pagina=<?php echo $i ?>" method="POST">
          <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
          <input id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $nombre_pelicula;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2"><?php echo $i ?></button>
        </form>
      </li>
    <?php endfor ?>
    <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>">
     <form action="buscarPelicula.php?pagina=<?php echo $_GET['pagina'] + 1 ?>" method="POST">
      <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
      <input id="nombre_pelicula" name="nombre_pelicula" value="<?php echo $nombre_pelicula;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
      <button name="buscar" value="buscar" class="page-link" id="button-addon2">Siguiente</button>
    </form>
  </li>
</ul>
</nav>
</div>



      <?php

        ?>
        <script>
          function eliminarPelicula(idpelicula,pagina,estado){
              var eliminar = confirm('De verdad desea Inactivar esta película');
              var eliminarPelicula=document.getElementById('eliminarPelicula').value;
              if ( eliminar ) {
                  
                  $.ajax({
                      url: 'ABM.php',
                      type: 'POST',
                      data: { 
                          id: idpelicula,
                          delete: eliminarPelicula,
                          est: estado,
                      
                      },
                  })
                  .done(function(response){
                      $("#result").html(response);
                  })
                  .fail(function(jqXHR){
                      console.log(jqXHR.statusText);
                  });
                  window.location.href ='listarpeliculas.php?pagina='+pagina+'&est='+estado;
              }
          } 
         </script>

</body>

</html>