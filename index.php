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
<title>Inicio Peliculas AFL cinema</title>
</head>
<body>
<?php
    require("header.php");
    
    require("conexion.php");
    
    ?>
<div class="container" style="padding-top:40px">
       <div class="row">
        <?php
        
           $consulta= mysqli_query($conexion,"SELECT * FROM peliculas WHERE anio=2021");
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
                                </div>
                                <br>
                            
                                <div>
                                   <div style="padding-top:25px;">
                                       <a title="más informacion" style="float:right;margin-right:25px;border-radius:30px" class="btn btn-dark card-text" href="#" data-toggle="modal" data-target="#info<?php echo $r['idpelicula'];?>"><i class="fas fa-info-circle"></i></a>
                                   </div>     
                                </div>
                            </div> 
                   </div>
			        <div  data-backdrop="static"  class="modal" id="info<?php echo $r['idpelicula'];?>">
                       <div class="modal-dialog modal-lg" >
                            <div class="modal-content">
                               <div class="modal-header" style="background:#212121;color:white">
                                   <h4 class="modal-title">informacion</h4>
                                   <button style="color:white" type="button" class="close" data-dismiss="modal">X</button>
                               </div>
                               <div class="modal-body" style="background:#121212;color:white">
		                               <div class="row">
		                                   <div class="col-md-6">
		                                        <img src="imagenes/<?php echo $r['imagen'];?>" style="width:50%"><br>
		                                   </div>
		                                  <div class="col-md-6">
		                                        <h6><strong>Titulo: </strong><?php echo $r['titulo'];?></h6>
                                            <h6><strong>categorias: </strong><?php echo $r['categorias'];?></h6>
                                            <h6><strong>Duracion: </strong><?php echo $r['duracion']." min";?></h6>
                                            <h6><strong>puntaje: </strong><?php echo "<i class='fas fa-star'></i>".$r['puntaje'];?></h6>
                                            <h6><strong>Año: </strong><?php echo $r['anio'];?></h6>
                                            <h6 align="center"><strong>Descripcion </strong></h6>
                                            <h6><?php echo $r['descripcion'];?></h6>
		                                  </div>
                                  
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
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
      </div>
      <div class="col-md-4" style="color:white;background:#121212">
           <br>
           <h3>Extrenos 2021</h3>
           <?php $consulta= mysqli_query($conexion,"SELECT * FROM peliculas WHERE anio=2021"); ?>
           <div class="parent">
              <div class="child"> 
                  <?php while ($r=mysqli_fetch_array($consulta)) { ?>
                          <div style="padding:2%;color:grey">
                             <p style="margin-right:20px">
	                               <a href="#" style="text-decoration:none;color:white" data-toggle="modal" data-target="#info<?php echo $r['idpelicula'];?>"><img src="imagenes/<?php echo $r['imagen'];?>" style="width:30%" align="left">
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
if (isset($_GET['error'])&& $_GET['error']==1) {
    echo "<script type='text/javascript'>alert('el mail ingresado ya existe, intente con otro.');</script>";
}
if (isset($_GET['error'])&& $_GET['error']==2) {
    echo "<script type='text/javascript'>alert('Usuario o contraseña incorrecto.');</script>";
}
if (isset($_GET['estado'])&& $_GET['estado']==1) {
    echo "<script type='text/javascript'>alert('fue registrado con exito');</script>";
}
?>
</body>
</html>
