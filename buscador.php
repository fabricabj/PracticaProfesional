
<!DOCTYPE html>
<html>
<head>
    <title>Inicio</title>
</head>
<body>
   <?php 
     
      require("conexion.php");
      if (isset($_GET['pagina'])) {
            require("header.php");
            $genero=$_POST['genero'];
            $titulo=$_POST['titulo']; 
            $sql="SELECT * FROM peliculas WHERE idestado=1";
            if($genero=="Todo"){
            $sql="SELECT * FROM peliculas WHERE (titulo like '%$titulo%') AND idestado=1";
            }else{
            $sql="SELECT * FROM peliculas WHERE (titulo like '%$titulo%') AND (categorias like '%$genero%') AND idestado=1";
            }
            $consulta=mysqli_query($conexion,$sql);
            $peliculas_x_pag = 8;
            $total_peliculas = mysqli_num_rows($consulta);
            $paginas = $total_peliculas / $peliculas_x_pag;
            $paginas = ceil($paginas);
            $iniciar = ($_GET['pagina'] - 1) * $peliculas_x_pag;
            $resultado = mysqli_query($conexion,$sql . " limit $iniciar,$peliculas_x_pag");

   ?>
   <div class="container">
       <div class="row">
     <?php 
     if(mysqli_num_rows($resultado)>0){
         echo "<div class='col-md-12'><h3 align='center' style='color:white'>resultados de la busqueda</h3></div>";
         while ($r = mysqli_fetch_array($resultado)) { ?>
            <div align="center" class="col-md-3" style="padding:1%;padding-top:40px">
                <div class="card" style="width: 12.5rem;background:#212121;color:white">
                    <img src="imagenes/<?php echo $r['imagen']; ?>" class="card-img-top">
                    <p><?php echo "<i class='fas fa-star'></i>" . $r['puntaje']; ?></p>
                    <div class="card-body" style="height:70px">
                        <p align="center" class="card-text"><?php echo $r['titulo']; ?></p>
                    </div>
                    <br>
                   
                    <div>
                       
                                    <div style="padding-top:5px;">
                                        <a title="más informacion" style="float: right;margin-right:5px;border-radius:30px" class="btn btn-dark card-text" href="#" data-toggle="modal" data-target="#info<?php echo $r['idpelicula']; ?>" onclick="vistos(<?php echo $r['idpelicula']?>,<?php echo $_GET['pagina']?>);"><i class="fas fa-info-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-backdrop="static" class="modal" id="info<?php echo $r['idpelicula']; ?>">
                            <div align="center" class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header" style="background:#212121;color:white">
                                        <h4 class="modal-title">Información</h4>
                                        <button style="color:white" type="button" class="close" data-dismiss="modal">X</button>
                                    </div>
                                    <div class="modal-body" style="background:#121212;color:white">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <img src="ImagenesOriginales/<?php echo $r['imagen']; ?>" style="width:50%"><br>
                                            </div>
                                            <div class="col-md-6">
                                                <h6><strong>Título: </strong><?php echo $r['titulo']; ?></h6>
                                                <h6><strong>Género: </strong><?php echo $r['categorias']; ?></h6>
                                                <h6><strong>Duración: </strong><?php echo $r['duracion']." min"; ?></h6>
                                                <h6><strong>Puntaje: </strong><?php echo "<i class='fas fa-star'></i>".$r['puntaje']; ?></h6>
                                                <h6><strong>Año: </strong><?php echo $r['anio']; ?></h6>
                                                <h6 align="center"><strong>Descripción </strong></h6>
                                                <h6><?php echo $r['descripcion']; ?></h6>
                                            </div>
                                            <?php if (isset($_SESSION['login']) && $_SESSION['login'] > 0) {
                            
                            $idgrupo=$_SESSION['grupo'];
                            $permisos=mysqli_query($conexion,"SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                            while($rs=mysqli_fetch_array($permisos)){

                                    $nombrePermiso=$rs['nombre_permiso'];
                                    switch($nombrePermiso) {
                                    case "comprar pelicula": ?>
                                        <div class="col-md-6">
                                            <form method="POST" action="altacarrito.php">
                                                <input type="text" name="id" id="id" value="<?php echo $r['idpelicula']; ?>" hidden>
                                                
                                               
                                                <button style="margin: 5px;" type="submit" class="btn btn-dark">Añadir a Carrito</button>
                                                    
                                                
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
                }else{
                        echo "<h3 style='color:white'>no se encontro resultados de la busqueda</h3>";
                    }
                }
                    ?>
                    <div class="container" style="padding-top:40px">
                            <nav arial-label="page navigation">
                                <ul class="pagination justify-content-center">
                                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>">
                                    <form action="buscador.php?pagina=<?php echo $_GET['pagina'] - 1 ?>" method="POST">
                                    <input id="titulo" name="titulo" value="<?php echo $titulo;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
                                    <input id="genero" name="genero" value="<?php echo $genero;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
                                    <button name="buscar" value="buscar" class="page-link" id="button-addon2">Anterior</button>
                                    
                                    </form>
                                </li>
                                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                                <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>">
                                    <form action="buscador.php?pagina=<?php echo $i ?>" method="POST">
                                    <input id="titulo" name="titulo" value="<?php echo $titulo;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
                                    <input id="genero" name="genero" value="<?php echo $genero;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
                                    <button name="buscar" value="buscar" class="page-link" id="button-addon2"><?php echo $i ?></button>
                                    </form>
                                </li>
                                <?php endfor ?>
                                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>">
                                <form action="buscador.php?pagina=<?php echo $_GET['pagina'] + 1 ?>" method="POST">
                                <input id="titulo" name="titulo" value="<?php echo $titulo;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
                                <input id="genero" name="genero" value="<?php echo $genero;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
                                <button name="buscar" value="buscar" class="page-link" id="button-addon2">Siguiente</button>
                                </form>
                            </li>
                            </ul>
                            </nav>
                     </div>

     </div>
   </div>
   <?php 
     if(isset($_GET['retorno'])&& $_GET['retorno']==2){
        echo "<script>alert('La pelicula ya fue agregada al carrito anteriormente');</script>";
     }
     if(isset($_GET['retorno'])&& $_GET['retorno']==1){
        echo "<script>alert('La pelicula fue agregada exitosamente!');</script>";
     }
   
   ?>
   <script>

        function vistos(idPelicula,pagina){

        $.ajax({
                    url: 'visitas.php',
                    type: 'POST',
                    data: { 
                        idpelicula: idPelicula,
                        pag: pagina,
                    
                    },
                })
                .done(function(response){
                    $("#result").html(response);
                })
                .fail(function(jqXHR){
                    console.log(jqXHR.statusText);
                }); 
                
        }

    </script>
 </body>
</html>
