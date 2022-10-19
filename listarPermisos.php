<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos</title>
</head>

<body>
    <?php   
    $asc = 0;
    
    if(!isset($_GET['pagina'])){
      header("location:listarPermisos.php?pagina=1");
      }
      include "conexion.php";
  $sql = "SELECT * FROM grupo";
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
  $permisos_x_pag = 5;
  $total_permisos = mysqli_num_rows($consulta);
  $paginas = $total_permisos / $permisos_x_pag;
  $paginas = ceil($paginas);
  if (isset($_GET['pagina'])) {
    require("header.php");
    $iniciar = ($_GET['pagina'] - 1) * $permisos_x_pag;
    $resultado = mysqli_query($conexion,$sql." limit $iniciar,$permisos_x_pag");

    ?>
    <div class="container">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <h3 class="text-center text-white">Listado de Grupos</h3>
            <table class="table table-light">
            <thead>
                    <th scope ="col"><a href="listarPermisos.php?pagina=1&orden=nombre_grupo&ascendente=<?php echo $asc; ?>" >Grupo</a></th>
                    <th><a href="asignarpermisos.php"><button type="button" class="btn btn-primary">Nuevo</button></a></th>      
            </thead>   
                    <?php
                    
                        while($fila= $resultado->fetch_assoc()){

                        echo "<tr>
                                  <td>".$fila['nombre_grupo']."</td>
                                   <td>
                                      <form action='FormModPermisos.php' method='post'>
                                          <input name='idgrupo' id='idgrupo' value='".$fila['idgrupo']."' hidden>
                                          <button type='submit' id='modificar' name='modificar' value='modificar' class='btn btn-success'>Modificar</button>
                                      </form>
                                   </td>
                                   <td>
                                      <form action='permisos.php' method='post'>
                                         <input name='idgrupo' id='idgrupo' value='".$fila['idgrupo']."' hidden>
                                         <button type='submit' id='modificar' name='baja' value='baja' class='btn btn-danger'>Eliminar</button>
                                      </form>
                                  </td>
                              </tr>";
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
                                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="listarPermisos.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>
                                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="listarPermisos.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                                <?php endfor ?>
                                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="listarPermisos.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>

</body>
</html>