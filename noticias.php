<!DOCTYPE html>
    <html>

    <head>
    <meta charset="UTF-8">
        <title>Noticias</title>
    </head>
    <body>
        <?php
        if (!isset($_GET['pagina'])) {
            header("location:noticias.php?pagina=1");
        }
        require("conexion.php");
        $sql = "SELECT n.* FROM noticias AS n, proveedores AS p where n.idproveedor = p.idproveedor and p.idestado=1 and n.idestado=1 ORDER BY n.idnoticia DESC";
        $consulta = mysqli_query($conexion, $sql);
         
    $noticias_x_pag = 4;
    $total_noticias = mysqli_num_rows($consulta);
    $paginas = $total_noticias / $noticias_x_pag;
    $paginas = ceil($paginas);
    if (isset($_GET['pagina'])) {
        require("header.php");
        $iniciar = ($_GET['pagina'] - 1) * $noticias_x_pag;
        $resultado = mysqli_query($conexion, $sql . " limit $iniciar,$noticias_x_pag");
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
                                case "alta noticias": ?>
                                        <li class="nav-item" style="margin:3px">
                                            <form method="POST" action="altaNoticia.php">
                                                <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" name="alta" value="alta"><i class="far fa-arrow-alt-circle-up"></i>Alta Noticia</button>
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
            <h1 align="center" style="color:white">Noticias</h1>
            <?php if (isset($_GET['estado'])&& $_GET['estado']==1) {
                    echo "<div class='alert alert-success'>Noticia agregada con exito!!</div>";
                }
                if (isset($_GET['estado'])&& $_GET['estado']==2) {
                    echo "<div class='alert alert-success'>Noticia modificada con exito!!</div>";
                }
                if (isset($_GET['estado'])&& $_GET['estado']==3) {
                    echo "<div class='alert alert-success'>Noticia inactivada con exito!!</div>";
                }?>
              <div class="row">
            <?php while ($r = mysqli_fetch_array($resultado)) { ?>
                    <div align="center" class="col-md-3" style="padding:1%;">    
                          <div class="card" style="width: 12.5rem;background:#212121;color:white">
                            <a href="#"><img src="imagenes/<?php echo $r['imagen']; ?>" class="card-img-top" style="width: 200px; height: 200px;"></a>
                              <div class="card-body" style="height:70px">
                                  <p align="center" class="card-text"><?php echo $r['nombre_noticia']; ?></p>
                              </div>
                              <br>
                              <div style="padding-top:50px">
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
                                        <a title="más informacion" style="float: right;margin-right:5px;border-radius:30px" class="btn btn-dark card-text" href="#" data-toggle="modal" data-target="#info<?php echo $r['idnoticia']; ?>"><i class="fas fa-info-circle"></i></a>
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
                                    <h6><strong>Título: </strong><?php echo $r['nombre_noticia']; ?></h6>
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
                                                                       <a style="margin: 5px;" href="#" onclick="eliminarNoticia(<?php echo $r['idnoticia']?>)" class="btn btn-dark">Inactivar</a>
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
         <div class="container" style="padding-top:40px">
        <nav arial-label="page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="noticias.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>
                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="noticias.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php endfor ?>
                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="noticias.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
            </ul>
        </nav>
    </div>
         <script>
                        function eliminarNoticia(idNoticia){
                            var eliminar = confirm('De verdad desea inactivar está noticia');
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
                                window.location.href ='noticias.php?pagina=1&estado=3';
                            }
                        }
                    
         </script>
         <?php } ?>
         
        
    </body>
</html>