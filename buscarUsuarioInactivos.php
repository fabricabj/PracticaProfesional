<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario inactivos</title>
</head>

<body>
    <?php   
    $asc = 0;
    
    if(!isset($_GET['pagina'])){
      header("location:buscarUsuariosInactivos.php?pagina=1");
      }
      include "conexion.php";

      if (isset($_GET['pagina'])) {
        require("header.php");
       $nombre_usuario=$_POST['nombre_usuario']; 
  $sql = "SELECT * FROM usuarios WHERE (nombre_usuario like '%$nombre_usuario%') AND idestado=2";
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
  $usuarios_x_pag = 2;
  $total_usuarios = mysqli_num_rows($consulta);
  $paginas = $total_usuarios / $usuarios_x_pag;
  $paginas = ceil($paginas);
    
    $iniciar = ($_GET['pagina'] - 1) * $usuarios_x_pag;
    $resultado = mysqli_query($conexion,$sql . " limit $iniciar,$usuarios_x_pag");
    ?>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Listado de Usuarios Inactivos</h3>
        <form action="buscarUsuarioInactivos.php?pagina=1" method="POST">
             <div class="input-group-prepend">
                  <input id="nombre_usuario" name="nombre_usuario" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="ingrese el titulo a buscar">
                  <div class="input-group-append">
                    <button style="border-color: white" class="btn btn-outline-dark" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>
            </div>
        </form>
        <table class="table table-light">
          <thead>
          
            <th scope ="col"><a href="usuariosinactivos.php?pagina=1&orden=idnoticia&ascendente=<?php echo $asc; ?>" >Id</a></th>
            <th scope ="col"><a href="usuariosinactivos.php?pagina=1&orden=nombre_usuario&ascendente=<?php echo $asc; ?>" >Nombre Usuario</a></th>
            <th scope ="col"><a href="usuariosinactivos.php?pagina=1&orden=mail&ascendente=<?php echo $asc; ?>" >Mail</a></th>
            <!--<th scope ="col"><a href="listarNoticias.php?pagina=1&orden=mail&ascendente=<?php echo $asc; ?>" > Mail</a></th>-->
            <th scope ="col">Estado</th>
            <!--<th><form action="altaNoticia.php" method="POST"> <button name='alta' value='alta' class="btn btn-warning">Nuevo</button></form></th>-->
          <th><a href="listarUsuario.php"><button type="button" class="btn btn-primary">Activas</button></a></th>
</thead> 
<?php
  
    while($fila = $resultado->fetch_assoc()){

      echo "<tr>";
      echo "<td>"; echo $fila['idusuario']; echo "</td>";
      echo "<td>"; echo $fila['nombre_usuario']; echo "</td>";
      echo "<td>"; echo $fila['mail']; echo "</td>";
      //echo "<td>"; echo $fila['idestado']; echo "</td>";
      $tipoestado=mysqli_query($conexion,"SELECT idestado FROM usuarios WHERE idusuario='{$fila['idusuario']}'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestado'];
                      } 
      $selectEstado=mysqli_query($conexion,"SELECT idestado,descripcion FROM usuario_estados WHERE idestado = $idTipoEstado ORDER BY descripcion ASC");
                      while($i=mysqli_fetch_array($selectEstado)){
                        $descripcion=$i['descripcion'];
                      } 
                      echo "<td>"; echo $descripcion; echo "</td>";
                        echo "<td><form action='modificarUsuario.php' method='post'>
                    <input name='idusuario' id='idusuario' value='".$fila['idusuario']."' hidden>
                    <button type='submit' class='btn btn-success'>Modificar</button>
                </form>
            </td>";
              echo "<td><form action='abm_usuario.php' method='post'>
                    <input name='id' id='id' value='".$fila['idusuario']."'hidden>
                    <button class='btn btn-danger' name='activar' id='activar' value='activar'>Activar</button>
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
      <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>">
        <form action="buscarUsuarioInactivos.php?pagina=<?php echo $_GET['pagina'] - 1 ?>" method="POST">
          <input id="nombre_usuario" name="nombre_usuario" value="<?php echo $nombre_usuario;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2">Anterior</button>
          
        </form>
      </li>
      <?php for ($i = 1; $i <= $paginas; $i++) : ?>
       <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>">
         <form action="buscarUsuarioInactivos.php?pagina=<?php echo $i ?>" method="POST">
          <input id="nombre_usuario" name="nombre_usuario" value="<?php echo $nombre_usuario;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2"><?php echo $i ?></button>
        </form>
      </li>
    <?php endfor ?>
    <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>">
     <form action="buscarUsuarioInactivos.php?pagina=<?php echo $_GET['pagina'] + 1 ?>" method="POST">
      <input id="nombre_usuario" name="nombre_usuario" value="<?php echo $nombre_usuario;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
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