<!DOCTYPE html>
    <html>

    <head>
    <meta charset="UTF-8">
        <title>Estenos</title>
    </head>
    <body>
        <?php
         if (!isset($_GET['pagina'])) {
            header("location:estrenos.php?pagina=1");
        }
        require("conexion.php");
        $sql = "SELECT * FROM peliculas where idestado=3 ORDER BY idpelicula DESC";
        $consulta = mysqli_query($conexion, $sql);

         
    $estrenos_x_pag = 4;
    $total_estrenos = mysqli_num_rows($consulta);
    $paginas = $total_estrenos / $estrenos_x_pag;
    $paginas = ceil($paginas);
    if (isset($_GET['pagina'])) {
        require("header.php");
        $iniciar = ($_GET['pagina'] - 1) * $estrenos_x_pag;
        $resultado = mysqli_query($conexion, $sql . " limit $iniciar,$estrenos_x_pag");
    ?> ?>

       
            <div class="row">  
                <div class="col-md-12 menualta">
                        <ul class="nav">
                        <?php if(isset($_SESSION['login']) && $_SESSION['login']>0){
                            $idgrupo=$_SESSION['grupo'];
                            $permisos=mysqli_query($conexion,"SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                            while($rs=mysqli_fetch_array($permisos)){

                                $nombrePermiso=$rs['nombre_permiso'];
                                switch($nombrePermiso) {
                                case "alta estrenos": ?>
                                        <li class="nav-item" style="margin:3px">
                                            <form method="POST" action="altaEstrenos.php">
                                                <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" name="alta" value="alta"><i class="far fa-arrow-alt-circle-up"></i>Alta Estrenos</button>
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
            <h1 align="center" style="color:white">Estrenos</h1>
            <?php if (isset($_GET['estado'])&& $_GET['estado']==1) {
                    echo "<div class='alert alert-success'>Estreno agregada con exito!!</div>";
                }
                if (isset($_GET['estado'])&& $_GET['estado']==2) {
                    echo "<div class='alert alert-success'>Estreno modificada con exito!!</div>";
                }
                if (isset($_GET['estado'])&& $_GET['estado']==3) {
                    echo "<div class='alert alert-success'>Estreno inactivada con exito!!</div>";
                }
                if (isset($_GET['estado'])&& $_GET['estado']==4) {
                    echo "<div class='alert alert-warning'>Titulo ya existente, por favor intente con otro!!</div>";
                }?>
              <div class="row">
            <?php while ($r = mysqli_fetch_array($resultado)) { ?>
                    <div align="center" class="col-md-3" style="padding:1%;">    
                          <div class="card" style="width: 12.5rem;background:#212121;color:white">
                              <a href="#"><img src="imagenes/<?php echo $r['imagen']; ?>" class="card-img-top" style="width: 200px; height: 200px;"></a>
                              <div class="card-body" style="height:70px">
                                  <p align="center" class="card-text"><?php echo $r['titulo']; ?></p>
                                  <strong>Duración: </strong><?php echo $r['duracion']; ?>
                                  <?php $fecha=date('d/m/Y',strtotime($r['fecha_publicacion'])); ?>
                                  <br><strong>Fecha: </strong><?php echo $fecha; ?>
                                  <br><strong>Categorías: </strong><?php echo $r['categorias']; ?>
                              </div>
                              <br>
                              <div style="padding-top:100px">
                              <?php 
                              if(isset($_SESSION['login']) && $_SESSION['login'] > 0){
                              $idgrupo=$_SESSION['grupo'];
                              $permisos=mysqli_query($conexion,"SELECT p.nombre_permiso,gp.idpermiso FROM permisos_usuarios AS p, grupos_permisos AS gp WHERE p.idpermiso = gp.idpermiso AND gp.idgrupo=$idgrupo;");
                              while($rs=mysqli_fetch_array($permisos)){

                                    $nombrePermiso=$rs['nombre_permiso'];
                                    switch($nombrePermiso) {
                                    case "modificar estrenos": ?>     
                                   <form method="POST" action="altaEstrenos.php">
                                        <button style="float: left;margin: 5px;border-radius:30px" type="submit" name="titulo" value="<?php echo $r['titulo']; ?>" class="btn btn-dark"><i class="fas fa-pencil-alt"></i></button>
                                   </form>
                                   <?php break;
                                     case "baja estrenos": ?>
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
                                        <button style="color:white" type="button" class="close" data-dismiss="modal">X</button>
                                    </div>
                                    <div class="modal-body" style="background:#121212;color:white">
                                    <div class="col-md-6">
                                    <h6><strong>Título: </strong><?php echo $r['titulo']; ?></h6>
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
                                                        case "baja estrenos": ?>
                                                                    <div class="col-md-6">
                                                                         <input type="text" name="eliminarEstrenos" id="eliminarEstrenos" value="eliminarEstrenos" hidden>
                                                                         <a style="margin: 5px;" href="#" onclick="eliminarEstrenos(<?php echo $r['idpelicula']?>)" class="btn btn-dark">Inactivar</a>
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
                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="estrenos.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>
                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="estrenos.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php endfor ?>
                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="estrenos.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
            </ul>
        </nav>
    </div>
         <script>
             function eliminarEstrenos(idPelicula){
                var eliminar = confirm('Desea inactivar este estreno?');
                var estreno=document.getElementById('eliminarEstrenos').value;
                if ( eliminar ) {
                        
                        $.ajax({
                        url: 'ABM.php',
                        type: 'POST',
                        data: { 
                            id: idPelicula,
                            deleteEstreno: estreno,
                            
                        },
                        })
                        .done(function(response){
                        $("#result").html(response);
                        })
                        .fail(function(jqXHR){
                        console.log(jqXHR.statusText);
                        });
                        window.location.href='estrenos.php?pagina=1&estado=3';
   }
} 


         </script>
         <?php } ?>
    </body>
</html>