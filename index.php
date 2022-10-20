<?php require("header.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
    body{
        background: url('fondo.jpg') no-repeat fixed center;
        -webkit-background-size:cover;
        -moz-background-size:cover;
        -o-background-size:cover;
        background-size:cover;
        width: 100%;
        height: 100%;
        text-align: center;
    }
    
</style>
<title>Inicio Películas AFL cinema</title>
</head>
<body>
<?php
    
    
    require("conexion.php");
    if (isset($_GET['error'])&& $_GET['error']==1) {
        echo "<div class='alert alert-danger'>¡El mail ingresado ya existe, por favor ingrese otro!</div>";
    }
    if (isset($_GET['error'])&& $_GET['error']==2) {
        echo "<div class='alert alert-danger'>¡Usuario o contraseña incorrecta!</div>";
    }
    if (isset($_GET['error'])&& $_GET['error']==3) {
        echo "<div class='alert alert-danger'>¡Usuario a sido suspendido!</div>";
    }
    if (isset($_GET['error'])&& $_GET['error']==4) {
        echo "<div class='alert alert-danger'>¡El nombre de usuario ingresado ya existe, por favor ingrese otro!</div>";
    }
    if (isset($_GET['estado'])&& $_GET['estado']==1) {
        echo "<div class='alert alert-success'>¡Usuario registrado con exito!</div>";
    }
    if(isset($_GET['retorno'])&& $_GET['retorno']==2){
        echo "<div class='alert alert-warning'>¡La pelicula ya fue agregada al carrito anteriormente!</div>";
    }
    if(isset($_GET['retorno'])&& $_GET['retorno']==1){
        echo "<div class='alert alert-success'>¡Pelicula agregada exitosamente!</div>";
    }
    if (isset($_GET['recuperar'])&& $_GET['recuperar']==2){
        echo '<script> alert("Hubo problemas con el envio");</script>';
    }
    
    ?>
    
<div class="container" style="padding-top:40px">
       <div class="row">
        <?php
        
           $consulta= mysqli_query($conexion,"SELECT * FROM peliculas WHERE anio=2021 and idestado=1");
           ?>
            <div class="col-md-8" style="background:#212121">
              <div align="center" id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                     <?php $active="active";
                           while ($r=mysqli_fetch_array($consulta)) {
                     ?>
                   <div class="carousel-item <?php echo $active;?>">
                            <div class="card" style="width: 18.5rem;background:#121212;color:white">
                                <img src="imagenes/<?php echo $r['imagen'];?>" class="card-img-top">
                                <p><?php echo "<i class='fas fa-star'></i>".$r['puntaje'];?></p>
                                <div class="card-body" style="height:70px">
                                     <p align="center" class="card-text"><?php echo $r['titulo'];?></p>
                                     <p align="center" class="card-text"><?php echo '$'.$r['precio'];?></p>
                                </div>
                                <br>
                            
                                <div>
                                   <div style="padding-top:25px;">
                                       <a title="más informacion" style="float:right;margin-right:25px;border-radius:30px" class="btn btn-dark card-text" href="#" data-toggle="modal" data-target="#info<?php echo $r['idpelicula'];?>" onclick="vistos(<?php echo $r['idpelicula']?>);"><i class="fas fa-info-circle"></i></a>
                                   </div>     
                                </div>
                            </div> 
                   </div>
			        <div  data-backdrop="static"  class="modal" id="info<?php echo $r['idpelicula'];?>">
                       <div class="modal-dialog modal-lg" >
                            <div class="modal-content">
                               <div class="modal-header" style="background:#212121;color:white">
                                   <h4 class="modal-title">Información</h4>
                                   <button style="color:white" type="button" class="close" data-dismiss="modal">X</button>
                               </div>
                               <div class="modal-body" style="background:#121212;color:white">
		                               <div class="row">
		                                   <div class="col-md-6">
		                                        <img src="ImagenesOriginales/<?php echo $r['imagen'];?>" style="width:50%"><br>
		                                   </div>
		                                  <div class="col-md-6">
		                                        <h6><strong>Título: </strong><?php echo $r['titulo'];?></h6>
                                            <h6><strong>Categorías: </strong><?php echo $r['categorias'];?></h6>
                                            <h6><strong>Duración: </strong><?php echo $r['duracion']." min";?></h6>
                                            <h6><strong>Puntaje: </strong><?php echo "<i class='fas fa-star'></i>".$r['puntaje'];?></h6>
                                            <h6><strong>Año: </strong><?php echo $r['anio'];?></h6>
                                            <h6 align="center"><strong>Descripción </strong></h6>
                                            <h6><?php echo $r['descripcion'];?></h6>
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
                          $active="";
                        }
                   ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>
      </div>
      <div class="col-md-4" style="color:white;background:#121212">
           <br>
           <h3>Películas 2021</h3>
           <?php $consulta= mysqli_query($conexion,"SELECT * FROM peliculas WHERE anio=2021"); ?>
           <div class="parent">
              <div class="child">
                  <?php while ($r=mysqli_fetch_array($consulta)) { ?>
                          <div style="padding:2%;color:grey">
                             <p style="margin-right:20px">
	                               <a href="#" style="text-decoration:none;color:white" data-toggle="modal" data-target="#info<?php echo $r['idpelicula'];?>" onclick="vistos(<?php echo $r['idpelicula']?>);"><img src="imagenes/<?php echo $r['imagen'];?>" style="width:30%" align="left">
                                 <h4><?php echo $r['titulo'];?></h4></a>
                                 <?php echo $r['descripcion'];?>
                             </p>
                             <br clear="all">
                          </div>
                 <?php }?>
              </div>
           </div>
      </div>
      
     </div>
   </div>
<?php

   
?>
<script>

function vistos(idPelicula){

    $.ajax({
                url: 'visitas.php',
                type: 'POST',
                data: { 
                    idpelicula: idPelicula,
                
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
