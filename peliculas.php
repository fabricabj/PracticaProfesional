<!DOCTYPE html>
    <html>

    <head>
    <meta charset="UTF-8">
    <title>Películas</title>
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
                                                <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" name="alta" value="alta"><i class="far fa-arrow-alt-circle-up"></i>Alta película</button>
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
               while ($r = mysqli_fetch_array($consulta2)) {
                   $seletFavoritos=mysqli_query($conexion,"SELECT * FROM favoritos WHERE idusuario={$_SESSION['login']} AND idpelicula={$r['idpelicula']}");?>
                    <div align="center" class="col-md-3" style="padding:1%;">    
                          <div class="card" style="width: 12.5rem;background:#212121;color:white">
                              <a href="#"><img src="imagenes/<?php echo $r['imagen']; ?>" class="card-img-top"></a>
                              <p><?php echo "<i class='fas fa-star'></i>" . $r['puntaje']; ?></p>
                              <div class="card-body" style="height:80px">
                                  <p align="center" class="card-text"><?php echo $r['titulo']; ?></p>
                                  <p><strong>Precio: </strong><?php echo "$".$r['precio']; ?></p>
                              </div>
                              <br>
                                  <?php if($f=mysqli_fetch_array($seletFavoritos)){?>
                                                 <input type="text" name="quitar" id="quitar" value="quitar" hidden>
                                                 <input type="text" name="genero" id="genero" value="<?php echo $peliculas;?>" hidden>
                                                 <a style="width:100%" class="btn btn-dark card-text" href="#" onclick="eliminarFav(<?php echo $r['idpelicula']?>,<?php echo $_SESSION['login'];?>,<?php echo $_GET['pagina']?>)">Quitar</a>
                                        <?php }else{?>
                                                 <input type="text" name="agregar" id="agregar" value="agregar" hidden>
                                                 <input type="text" name="genero" id="genero" value="<?php echo $peliculas;?>" hidden>
                                                 <a style="width:100%" class="btn btn-dark card-text" href="#" onclick="agregarFav(<?php echo $r['idpelicula']?>,<?php echo $_SESSION['login'];?>,<?php echo $_GET['pagina']?>)">Agregar</a>
                                        <?php }?>
                              
                              <div style="padding-top:50px">
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
                                    
                                </div>
                          </div>
                    </div>
                    <div align="center" data-backdrop="static" class="modal" id="info<?php echo $r['idpelicula']; ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header" style="background:#212121;color:white">
                                        <h4 class="modal-title">Información de la película</h4>
                                        <button style="color:white" type="button" class="close" data-dismiss="modal">X</button>
                                    </div>
                                    <div class="modal-body" style="background:#121212;color:white">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <img src="ImagenesOriginales/<?php echo $r['imagen']; ?>" style="width:50%"><br>
                                            </div>
                                            <div class="col-md-6">
                                                <h6><strong>Título: </strong><?php echo $r['titulo']; ?></h6>
                                                <h6><strong>Genero: </strong><?php echo $r['categorias']; ?></h6>
                                                <h6><strong>Duración: </strong><?php echo $r['duracion']." min"; ?></h6>
                                                <h6><strong>Puntaje: </strong><?php echo "<i class='fas fa-star'></i>" .$r['puntaje']; ?></h6>
                                                <h6><strong>Año: </strong><?php echo $r['anio']; ?></h6>
                                                <h6><strong>Precio: </strong><?php echo $r['precio']; ?></h6>
                                                <h6 align="center"><strong>Descripción </strong></h6>
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
                                                                <input type="text" name="pag" id="pag" value="<?php echo $_GET['pagina'];?>" hidden>
                                                                <input type="text" name="categ" id="categ" value="<?php echo $peliculas;?>" hidden>
                                                                <input type="text" name="eliminarPelicula" id="eliminarPelicula" value="eliminarPelicula" hidden>
                                                                <a style="margin: 5px;" href="#" onclick="eliminarPelicula(<?php echo $r['idpelicula']?>,<?php echo $_GET['pagina']?>)" class="btn btn-dark">Eliminar</a>
                                                            
                                                            </div>
                                                    <?php break;
                                                        case "comprar pelicula": ?>
                                                            <div class="col-md-6">
                                                                <form method="POST" action="altacarrito.php">
                                                                    <input type="text" name="id" id="id" value="<?php echo $r['idpelicula']; ?>" hidden>
                                                                    <input type="text" name="pagina" id="pagina" value="<?php echo $_GET['pagina']; ?>" hidden>
                                                                    <input type="text" name="genero" id="genero" value="<?php echo $peliculas;?>" hidden>
                                                                    <button style="margin: 5px;" type="submit" class="btn btn-dark">Añadir a carrito</button>
                                                                        
                                                                    
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
         </div>
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
                        if(isset($_GET['estadocarrito'])&& $_GET['estadocarrito']==2){
                            echo "<script>alert('La pelicula ya fue agregada al carrito anteriormente');</script>";
                        }
                        if(isset($_GET['estadocarrito'])&& $_GET['estadocarrito']==1){
                            echo "<script>alert('La pelicula fue agregada exitosamente!');</script>";
                        }
                                            
                    ?>
                    <script>
                        function eliminarPelicula(idPelicula,pagina){
                            var eliminar = confirm('De verdad desea eliminar esta pelicula');
                            var categoria=document.getElementById('categ').value;
                            var eliminarPelicula=document.getElementById('eliminarPelicula').value;
                            if ( eliminar ) {
                                
                                $.ajax({
                                    url: 'ABM.php',
                                    type: 'POST',
                                    data: { 
                                        id: idPelicula,
                                        delete: eliminarPelicula,
                                    
                                    },
                                })
                                .done(function(response){
                                    $("#result").html(response);
                                })
                                .fail(function(jqXHR){
                                    console.log(jqXHR.statusText);
                                });
                                alert('La pelicula ha sido eliminada');
                                window.location.href ='peliculas.php?genero='+categoria+'&pagina='+pagina;
                            }
                        } 
                        function eliminarFav(idPelicula,idUsuario,pagina){
                            var eliminar = confirm('De verdad desea quitar esta pelicula de favoritos?');
                            
                            var quitar=document.getElementById('quitar').value;
                            var genero=document.getElementById('genero').value;
                            if ( eliminar ) {
                                
                                $.ajax({
                                    url: 'ABfavoritos.php',
                                    type: 'POST',
                                    data: { 
                                        idpelicula: idPelicula,
                                        idusuario: idUsuario,
                                        categ: genero,
                                        pag: pagina,
                                        delete: quitar,
                                    
                                    },
                                })
                                .done(function(response){
                                    $("#result").html(response);
                                })
                                .fail(function(jqXHR){
                                    console.log(jqXHR.statusText);
                                });
                                alert('se ha quitado de favoritos');
                                window.location.href ='peliculas.php?genero='+genero+'&pagina='+pagina;
                            }
                    } 
                    function agregarFav(idPelicula,idUsuario,pagina){
                            var agregar = confirm('De verdad desea agregar esta pelicula de favoritos?');
                            
                            var agregar=document.getElementById('agregar').value;
                            var genero=document.getElementById('genero').value;
                            if ( agregar ) {
                                
                                $.ajax({
                                    url: 'ABfavoritos.php',
                                    type: 'POST',
                                    data: { 
                                        idpelicula: idPelicula,
                                        idusuario: idUsuario,
                                        categ: genero,
                                        pag: pagina,
                                        alta: agregar,
                                    
                                    },
                                })
                                .done(function(response){
                                    $("#result").html(response);
                                })
                                .fail(function(jqXHR){
                                    console.log(jqXHR.statusText);
                                });
                                alert('se ha agregado a favoritos');
                                window.location.href ='peliculas.php?genero='+genero+'&pagina='+pagina;
                            }
                    } 

                    </script>
    </body>
</html>