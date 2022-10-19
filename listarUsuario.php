<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
</head>

<body>
    <?php   
    $asc = 0;
    
    if(!isset($_GET['pagina'])){
      header("location:listarUsuario.php?pagina=1");
      }
      include "conexion.php";
      $est=$_GET['est'];
  $sql = "SELECT * FROM usuarios WHERE idestado = $est";
  $estados=mysqli_query($conexion,"SELECT * FROM usuario_estados ORDER BY descripcion ASC");
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
  $usuarios_x_pag = 5;
  $total_usuarios = mysqli_num_rows($consulta);
  $paginas = $total_usuarios / $usuarios_x_pag;
  $paginas = ceil($paginas);
  if (isset($_GET['pagina'])) {
    require("header.php");
    $iniciar = ($_GET['pagina'] - 1) * $usuarios_x_pag;
    $resultado = mysqli_query($conexion,$sql . " limit $iniciar,$usuarios_x_pag");
    ?>
    <script language="javascript">
      
      $(document).ready(function(){
      
        $("#Est").change(function () {	
          $("#Est option:selected").each(function () {
            id_estado = $(this).val();
          
            window.location.href="listarUsuario.php?pagina=1&est="+id_estado;
                      
          });
          
        });
        
      });
 </script>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Listado de Usuarios</h3>
        <?php if (isset($_GET['estado'])&& $_GET['estado']==1) {
                echo "<div class='alert alert-success'>Usuario inactivado con exito!!</div>";
              }
              if (isset($_GET['estado'])&& $_GET['estado']==2) {
                echo "<div class='alert alert-success'>Usuario activado con exito!!</div>";
              }
              if (isset($_GET['estado'])&& $_GET['estado']==3) {
                echo "<div class='alert alert-success'>Usuario modificado con exito!!</div>";
              }?>
          <form action="buscarUsuario.php?pagina=1" method="POST">
          <div class="input-group-prepend">
             <input id="nombre_usuario" name="nombre_usuario" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Ingrese el nombre a buscar">
                  <input id="estado" name="estado" type="text" value="<?php echo $_GET['est'];?>" hidden>
                <div class="input-group-append">
                  <button style="border-color: white" class="btn btn-outline-dark" type="submit" name="Buscar" value="Buscar" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>
            </div>
        </form>
        <table class="table table-light">
          <thead>
          
            <th scope ="col"><a href="listarUsuario.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=idusuario&ascendente=<?php echo $asc; ?>" >Id</a></th>
            <th scope ="col"><a href="listarUsuario.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=nombre_usuario&ascendente=<?php echo $asc; ?>" >Nombre Usuario</a></th>
            <th scope ="col"><a href="listarUsuario.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=mail&ascendente=<?php echo $asc; ?>" >Mail</a></th>
            <th scope ="col">Grupo</a></th>
            <!--<th scope ="col"><a href="listarNoticias.php?pagina=1&orden=mail&ascendente=<?php echo $asc; ?>" > Mail</a></th>-->
            <th scope ="col">Estado</th>
          <th>
            <select name="Est" id="Est">
                <option value='0'>Todos</option>
                <?php while($rs=mysqli_fetch_array($estados)){?>
                  <option value="<?php echo $rs['idestado'] ?>" <?php if($_GET['est']==$rs['idestado']) echo 'Selected'?>><?php echo $rs['descripcion'];?></option>
                <?php }; ?>
						</select>
          </th>
</thead> 
<?php
  
    while($fila = $resultado->fetch_assoc()){
       
      echo "<tr>";
      echo "<td>"; echo $fila['idusuario']; echo "</td>";
      echo "<td>"; echo $fila['nombre_usuario']; echo "</td>";
      echo "<td>"; echo $fila['mail']; echo "</td>";
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
            if($_GET['est']==1){
              echo '<td><input type="text" name="eliminarUsuario" id="eliminarUsuario" value="eliminarUsuario" hidden>
                    <input type="text" name="pagina" id="pagina" value="'.$_GET['pagina'].'" hidden>
                    <a style="margin: 5px;" href="#" onclick="eliminarUsuario('.$fila['idusuario'].','.$_GET['pagina'].','.$_GET['est'].')" class="btn btn-danger">Inactivar</a></td>';
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
                                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="listarUsuario.php?pagina=<?php echo $_GET['pagina'] - 1 ?>&est=<?php echo $_GET['est'];?>">Anterior</a></li>
                                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="listarUsuario.php?pagina=<?php echo $i ?>&est=<?php echo $_GET['est'];?>"><?php echo $i ?></a></li>
                                <?php endfor ?>
                                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="listarUsuario.php?pagina=<?php echo $_GET['pagina'] + 1 ?>&est=<?php echo $_GET['est'];?>">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>

      <?php
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
          window.location.href ='listarUsuario.php?pagina='+pagina+'&est='+estado+'&estado=1';
      }
  } 
</script>

</body>

</html>