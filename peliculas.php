<!DOCTYPE html>
    <html>

    <head>
    <meta charset="UTF-8">
    <title>Peliculas</title>
    </head>
    <body>
        <?php
        
            if (isset($_GET['genero'])) {
                $peliculas = $_GET['genero'];
                if(!isset($_GET['pagina'])){
                header("location:peliculas.php?genero=$peliculas&pagina=1");
                }
        
            }
            require("header.php");
            $consulta = mysqli_query($conexion, "SELECT * FROM peliculas where (categorias like '%$peliculas%') AND idestado=1");
            $peliculas_x_pag = 4;
            $total_peliculas = mysqli_num_rows($consulta);
            $paginas = $total_peliculas / $peliculas_x_pag;
            $paginas = ceil($paginas);
        ?>

       
            <div class="row">  
                <div class="col-md-12 menualta">
                        <ul class="nav">
                        <?php if(isset($_SESSION['login']) && $_SESSION['login']>0){
                            $idgrupo=$_SESSION['grupo'];
                            $permisos=mysqli_query($conexion,"SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                            while($rs=mysqli_fetch_array($permisos)){

                                $nombrePermiso=$rs['nombre_permiso'];
                                switch($nombrePermiso) {
                                case "alta pelicula": ?>
                                        <li class="nav-item" style="margin:3px">
                                            <form method="POST" action="altaMod.php">
                                                <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" name="alta" value="alta"><i class="far fa-arrow-alt-circle-up"></i>Alta pelicula</button>
                                            </form>
                                        </li> 
                        <?php     break;
                                }
                                }
                            }
                        ?>
                        </ul>
                </div>     
            </div> 
            <div class="container">
              <div class="row">
            <?php 
            
            if (isset($_GET['pagina'])) {
               $iniciar = ($_GET['pagina'] - 1) * $peliculas_x_pag;
               $consulta2 = mysqli_query($conexion, "SELECT * FROM peliculas WHERE (categorias like '%$peliculas%') AND idestado=1 ORDER BY anio DESC limit $iniciar,$peliculas_x_pag");
               while ($r = mysqli_fetch_array($consulta2)) {?>
                    <div align="center" class="col-md-3" style="padding:1%;">    
                          <div class="card" style="width: 12.5rem;background:#212121;color:white">
                              <a href="#"><img src="imagenes/<?php echo $r['imagen']; ?>" class="card-img-top" width="620px"></a>
                              <p><?php echo "<i class='fas fa-star'></i>" . $r['puntaje']; ?></p>
                              <div class="card-body" style="height:70px">
                                  <p align="center" class="card-text"><?php echo $r['titulo']; ?></p>
                                  <label><strong>Precio: </strong><?php echo "$".$r['precio']; ?></label>
                                 
                              </div>
                              <div style="padding-top:40px">
                              <?php 
                              if(isset($_SESSION['login']) && $_SESSION['login'] > 0){
                              $idgrupo=$_SESSION['grupo'];
                              $permisos=mysqli_query($conexion,"SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                              while($rs=mysqli_fetch_array($permisos)){

                                    $nombrePermiso=$rs['nombre_permiso'];
                                    switch($nombrePermiso) {
                                    case "modificar pelicula": ?>     
                                   <form method="POST" action="altaMod.php">
                                        <button style="float: left;margin: 5px;border-radius:30px" type="submit" name="titulo" value="<?php echo $r['titulo']; ?>" class="btn btn-dark"><i class="fas fa-pencil-alt"></i></button>
                                   </form>
                                   <?php break;
                                     case "baja pelicula": ?>
                                     <a style="float: left;margin: 5px;border-radius:30px" class="btn btn-dark" href="#" data-toggle="modal" data-target="#info<?php echo $r['idpelicula']; ?>"><i class="fas fa-trash-alt"></i></a>
                                   <?php break;
                                    }
                                  }
                                }
                                ?>
                                    <div style="padding-top:5px;">
                                        <a title="más informacion" style="float: right;margin-right:5px;border-radius:30px" class="btn btn-dark card-text" href="#" data-toggle="modal" data-target="#info<?php echo $r['idpelicula']; ?>"><i class="fas fa-info-circle"></i></a>
                                        
                                    </div>
                                    <div>
                                       <a style="float: right;margin-right:7px;border-radius:30px" class="btn btn-dark card-text" href="peliculas.php?genero=<?php echo $peliculas;?>&pagina=<?php echo $_GET['pagina'];?>&idpelicula=<?php echo $r['idpelicula']; ?>&estado=4"><i class="fas fa-bookmark"></i></a>
                                    </div>
                                </div>
                          </div>
                    </div>
                    <div align="center" data-backdrop="static" class="modal" id="info<?php echo $r['idpelicula']; ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header" style="background:#212121;color:white">
                                        <h4 class="modal-title">informacion</h4>
                                        <button style="color:white" type="button" class="close" data-dismiss="modal">X</button>
                                    </div>
                                    <div class="modal-body" style="background:#121212;color:white">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <img src="imagenes/<?php echo $r['imagen']; ?>" style="width:50%"><br>
                                            </div>
                                            <div class="col-md-6">
                                                <h6><strong>Titulo: </strong><?php echo $r['titulo']; ?></h6>
                                                <h6><strong>Genero: </strong><?php echo $r['categorias']; ?></h6>
                                                <h6><strong>Duracion: </strong><?php echo $r['duracion']." min"; ?></h6>
                                                <h6><strong>puntaje: </strong><?php echo "<i class='fas fa-star'></i>" .$r['puntaje']; ?></h6>
                                                <h6><strong>Año: </strong><?php echo $r['anio']; ?></h6>
                                                <h6><strong>Precio: </strong><?php echo $r['precio']; ?></h6>
                                                <h6 align="center"><strong>Descripcion </strong></h6>
                                                <h6><?php echo $r['descripcion']; ?></h6>
                                            </div>
                                            <?php if (isset($_SESSION['login']) && $_SESSION['login'] > 0) {
                            
                                                $idgrupo=$_SESSION['grupo'];
                                                $permisos=mysqli_query($conexion,"SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                                                while($rs=mysqli_fetch_array($permisos)){

                                                        $nombrePermiso=$rs['nombre_permiso'];
                                                        switch($nombrePermiso) {
                                                        case "baja pelicula": ?>
                                                                    <div class="col-md-6">
                                                                        <form method="POST" action="ABM.php">
                                                                        <input type="text" name="id" id="id" value="<?php echo $r['idpelicula']; ?>" hidden>
                                                                            <input type="text" name="genero" id="genero" value="<?php echo $peliculas;?>" hidden>
                                                                                <button style="margin: 5px;" type="submit" name="idpelicula" value="idpelicula" class="btn btn-dark">Eliminar</button>
                                                                                
                                                                               
                                                                            </form>
                                                                    </div>
                                                    <?php break;
                                                        }
                                                            
                                                        }
                                                            
                                               }
                                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>           
            <?php 
                   }
             ?>
         </div>
         </div>
         </div>e
         <?php } ?>
                      <div class="container" style="padding-top:40px">
                        <nav arial-label="page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="peliculas.php?genero=<?php echo $peliculas; ?>&pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>
                                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="peliculas.php?genero=<?php echo $peliculas; ?>&pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                                <?php endfor ?>
                                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="peliculas.php?genero=<?php echo $peliculas; ?>&pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>
                    <?php  
                         if (isset($_GET['idpelicula']) && (isset($_GET['estado']) && $_GET['estado'] == 4)) {
                            $idPelicula = $_GET['idpelicula'];
                            $prod = mysqli_query($conexion, "select * from favoritos where idusuario={$_SESSION['login']} and idpelicula='$idPelicula'");
                            if (mysqli_num_rows($prod) > 0) {
                                echo "<script>alert('no puede agregar una pelicula que ya se encuentra en la lista');</script>";
                            } else {
                                $insertar = mysqli_query($conexion, "insert into favoritos(idusuario,idpelicula)values('{$_SESSION['login']}','$idPelicula')");
                                echo "<script>alert('pelicula agregada');</script>";
                            }
                        }
                                            
                    ?>
    </body>
</html>