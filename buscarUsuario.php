<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
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
      header("location:buscarUsuario.php?pagina=1");
      }
      include "conexion.php";
      
  if (isset($_GET['pagina'])) {
    require("header.php");
    $nombre_usuario=$_POST['nombre_usuario'];
    $est=$_POST['estado'];
  $sql = "SELECT * FROM usuarios WHERE(nombre_usuario like '%$nombre_usuario%') AND idestado=$est";
  $consulta = mysqli_query($conexion,$sql);
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
  $usuarios_x_pag = 5;
  $total_usuarios = mysqli_num_rows($consulta);
  $paginas = $total_usuarios / $usuarios_x_pag;
  $paginas = ceil($paginas);
    $iniciar = ($_GET['pagina'] - 1) * $usuarios_x_pag;
    $resultado = mysqli_query($conexion,$sql . " limit $iniciar,$usuarios_x_pag");
    ?>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Listado de Usuarios</h3>
          <form action="buscarUsuario.php?pagina=1" method="POST">
          <div class="input-group-prepend">
             <input id="nombre_usuario" name="nombre_usuario" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Ingrese el nombre a buscar">
                  <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
                  <div class="input-group-append">
                    <button style="border-color: white" class="btn btn-outline-dark" type="submit" name="Buscar" value="Buscar" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>

            </div>
        </form>
        <table class="table table-light">
          <thead>
          
            <form action="buscarUsuario.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="idusuario" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="estado" name="estado" value="<?php echo $_POST['estado'];?>" hidden>
                <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo $_POST['nombre_usuario'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Id</button>
            </form>
            <form action="buscarUsuario.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="nombre_usuario" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="estado" name="estado" value="<?php echo $_POST['estado'];?>" hidden>
                <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo $_POST['nombre_usuario'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Nombre</button>
            </form>
            <form action="buscarUsuario.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="mail" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="estado" name="estado" value="<?php echo $_POST['estado'];?>" hidden>
                <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo $_POST['nombre_usuario'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Mail</button>
            </form>
            <th scope ="col">Grupo</a></th>
            <th scope ="col">Estado</th>
           <!-- <th><form action="altaNoticia.php" method="POST"> <button name='alta' value='alta' class="btn btn-warning">Nuevo</button></form></th>-->
</thead> 
<?php
  
    while($fila = $resultado->fetch_assoc()){
       
      echo "<tr>";
      echo "<td>"; echo $fila['idusuario']; echo "</td>";
      echo "<td>"; echo $fila['nombre_usuario']; echo "</td>";
      echo "<td>"; echo $fila['mail']; echo "</td>";
      //echo "<td>"; echo $fila['idestado']; echo "</td>";
      $selectGrupo=mysqli_query($conexion,"SELECT g.nombre_grupo FROM grupo AS g
      JOIN grupo_usuarios AS gu ON gu.idgrupo=g.idgrupo
      WHERE gu.idusuario={$fila['idusuario']}");
while($i=mysqli_fetch_array($selectGrupo)){
$nombre_grupo=$i['nombre_grupo'];
}
echo "<td>"; echo $nombre_grupo; echo "</td>";
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
            if($est==1){
              echo '<td><input type="text" name="eliminarUsuario" id="eliminarUsuario" value="eliminarUsuario" hidden>
                    <input type="text" name="pagina" id="pagina" value="'.$_GET['pagina'].'" hidden>
                    <a style="margin: 5px;" href="#" onclick="eliminarUsuario('.$fila['idusuario'].','.$_GET['pagina'].','.$_POST['estado'].')" class="btn btn-danger">Inactivar</a></td>';
            }else{  
              echo "<td><form action='abm_usuario.php' method='post'>
                    <input name='idusuario' id='idusuario' value='".$fila['idusuario']."'hidden>
                    <button type='submit' class='btn btn-danger' name='Activar' id='Activar' value='Activar'>Activar</button>
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
        <form action="buscarUsuario.php?pagina=<?php echo $_GET['pagina'] - 1 ?>" method="POST">
        <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
          <input id="nombre_usuario" name="nombre_usuario" value="<?php echo $nombre_usuario;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2">Anterior</button>
          
        </form>
      </li>
      <?php for ($i = 1; $i <= $paginas; $i++) : ?>
       <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>">
         <form action="buscarUsuario.php?pagina=<?php echo $i ?>" method="POST">
         <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
          <input id="nombre_usuario" name="nombre_usuario" value="<?php echo $nombre_usuario;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2"><?php echo $i ?></button>
        </form>
      </li>
    <?php endfor ?>
    <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>">
     <form action="buscarUsuario.php?pagina=<?php echo $_GET['pagina'] + 1 ?>" method="POST">
     <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
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
        <script>
  function eliminarUsuario(idusuario,pagina,estado){
      var eliminar = confirm('De verdad desea inactivar este usuario?');
      var eliminarUsuario=document.getElementById('eliminarUsuario').value;
      if ( eliminar ) {
          
          $.ajax({
              url: 'abm_usuario.php',
              type: 'POST',
              data: { 
                  id: idusuario,
                  delete: eliminarUsuario,
                  est: estado,
              
              },
          })
          .done(function(response){
              $("#result").html(response);
          })
          .fail(function(jqXHR){
              console.log(jqXHR.statusText);
          });
          window.location.href ='listarUsuario.php?pagina='+pagina+'&est='+estado;
      }
  } 
</script>

</body>

</html>