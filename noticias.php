<!DOCTYPE html>
    <html>

    <head>
    <meta charset="UTF-8">
        <title>Noticias</title>
    </head>
    <body>
        <?php
        
        // if (isset($_GET['genero'])) {
        //    $noticias = $_GET['genero'];
        //     if(!isset($_GET['pagina'])){
        //       header("location:peliculas.php?genero=$peliculas&pagina=1");
        //     }
       
        // }
        require("header.php");
         $consulta = mysqli_query($conexion, "SELECT * FROM noticias where idestado=1"); ?>

       
            <div class="row">  
                <div class="col-md-12 menualta">
                        <ul class="nav">
                        <?php if(isset($_SESSION['login']) && $_SESSION['login']>0){
                            $idgrupo=$_SESSION['grupo'];
                            $permisos=mysqli_query($conexion,"SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                            while($rs=mysqli_fetch_array($permisos)){

                                $nombrePermiso=$rs['nombre_permiso'];
                                switch($nombrePermiso) {
                                case "alta noticias": ?>
                                        <li class="nav-item" style="margin:3px">
                                            <form method="POST" action="altaNoticia.php">
                                                <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" name="alta" value="alta"><i class="far fa-arrow-alt-circle-up"></i>Alta noticia</button>
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
            <?php while ($r = mysqli_fetch_array($consulta)) { ?>
                    <div align="center" class="col-md-3" style="padding:1%;">    
                          <div class="card" style="width: 12.5rem;background:#212121;color:white">
                            <a href="#"><img src="imagenes/<?php echo $r['imagen']; ?>" class="card-img-top" style="width: 200px; height: 200px;"></a>
                              <div class="card-body" style="height:70px">
                                  <p align="center" class="card-text"><?php echo $r['nombre_noticia']; ?></p>
                              </div>
                              <div>
                              <?php 
                              if(isset($_SESSION['login']) && $_SESSION['login'] > 0){
                              $idgrupo=$_SESSION['grupo'];
                              $permisos=mysqli_query($conexion,"SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                              while($rs=mysqli_fetch_array($permisos)){

                                    $nombrePermiso=$rs['nombre_permiso'];
                                    switch($nombrePermiso) {
                                    case "modificar noticias": ?>     
                                   <form method="POST" action="altaNoticia.php">
                                        <button style="float: left;margin: 5px;border-radius:30px" type="submit" name="idnoticia" value="<?php echo $r['idnoticia']; ?>" class="btn btn-dark"><i class="fas fa-pencil-alt"></i></button>
                                   </form>
                                   <?php break;
                                     case "baja noticia": ?>
                                     <a style="float: left;margin: 5px;border-radius:30px" class="btn btn-dark" href="#" data-toggle="modal" data-target="#info<?php echo $r['idnoticia']; ?>"><i class="fas fa-trash-alt"></i></a>
                                   <?php break;
                                    }
                                  }
                                }
                                ?>
                                    <div style="padding-top:5px;">
                                        <a title="m??s informacion" style="float: right;margin-right:5px;border-radius:30px" class="btn btn-dark card-text" href="#" data-toggle="modal" data-target="#info<?php echo $r['idnoticia']; ?>"><i class="fas fa-info-circle"></i></a>
                                    </div>
                                </div>
                          </div>
                    </div>
                    <div align="center" data-backdrop="static" class="modal" id="info<?php echo $r['idnoticia']; ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header" style="background:#212121;color:white">
                                        <button style="color:white" type="button" class="close" data-dismiss="modal">X</button>
                                    </div>
                                    <div class="modal-body" style="background:#121212;color:white">
                                    <div class="col-md-6">
                                    <h6><strong>T??tulo: </strong><?php echo $r['nombre_noticia']; ?></h6>
                                    <img src="ImagenesOriginales/<?php echo $r['imagen']; ?>" style="width:50%"><br>
                                    </div>
                                        <div >                                
                                            <div class="col-md-12">                                               
                                                <h6><?php echo $r['descripcion']; ?></h6>
                                            </div>
                                            <?php if (isset($_SESSION['login']) && $_SESSION['login'] > 0) {
                            
                                                $idgrupo=$_SESSION['grupo'];
                                                $permisos=mysqli_query($conexion,"SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                                                while($rs=mysqli_fetch_array($permisos)){

                                                        $nombrePermiso=$rs['nombre_permiso'];
                                                        switch($nombrePermiso) {
                                                        case "baja noticias": ?>
                                                                    <div class="col-md-6">
                             
                                                                       <input type="text" name="eliminarNoticia" id="eliminarNoticia" value="eliminarNoticia" hidden>
                                                                       <a style="margin: 5px;" href="#" onclick="eliminarNoticia(<?php echo $r['idnoticia']?>)" class="btn btn-dark">Eliminar</a>
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
            <?php } ?>
         </div>
         </div>
         </div>
         <script>
                        function eliminarNoticia(idNoticia){
                            var eliminar = confirm('De verdad desea eliminar esta noticia');
                            var eliminarNoticia=document.getElementById('eliminarNoticia').value;
                            if ( eliminar ) {
                                
                                $.ajax({
                                    url: 'abm_noticias.php',
                                    type: 'POST',
                                    data: { 
                                        id: idNoticia,
                                        delete: eliminarNoticia,
                                    
                                    },
                                })
                                .done(function(response){
                                    $("#result").html(response);
                                })
                                .fail(function(jqXHR){
                                    console.log(jqXHR.statusText);
                                });
                                alert('La noticia ha sido eliminada');
                                window.location.href ='noticias.php';
                            }
                        } 
         </script>
    </body>
</html>