
<!DOCTYPE html>
<html>
<head>
    <title>Inicio</title>
</head>
<body>
   <?php 
      require("header.php");
      require("conexion.php");   

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
                                            <form method="POST" action="listarpeliculas.php">
                                                <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" name="alta" value="alta"><i class="far fa-arrow-alt-circle-up"></i>Listar peliculas</button>
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
          <div class="col-md-4" align="center" style="padding:20px;">
            <a href="peliculas.php?genero=Fantasia"><img src="https://m.media-amazon.com/images/G/01/IMDb/genres/Fantasy._CB1513316168_SX233_CR0,0,233,131_AL_.jpg" style="width:60%;border-radius:20px"></a>
          </div>
          <div class="col-md-4" align="center" style="padding:20px;">
            <a href="peliculas.php?genero=Terror"><img src="https://m.media-amazon.com/images/G/01/IMDb/genres/Horror._CB1513316168_SX233_CR0,0,233,131_AL_.jpg" style="width:60%;border-radius:20px"></a>
          </div>
          <div class="col-md-4" align="center" style="padding:20px;">
            <a href="peliculas.php?genero=accion"><img src="https://m.media-amazon.com/images/G/01/IMDb/genres/Action._CB1513316166_SX233_CR0,0,233,131_AL_.jpg" style="width:60%;border-radius:20px"></a>
          </div>
          <div class="col-md-4" align="center" style="padding:20px;">
            <a href="peliculas.php?genero=Aventura"><img src="https://m.media-amazon.com/images/G/01/IMDb/genres/Adventure._CB1513316166_SX233_CR0,0,233,131_AL_.jpg" style="width:60%;border-radius:20px"></a>
          </div>
          <div class="col-md-4" align="center" style="padding:20px;">
            <a href="peliculas.php?genero=Crimen"><img src="https://m.media-amazon.com/images/G/01/IMDb/genres/Crime._CB1513316167_SX233_CR0,0,233,131_AL_.jpg" style="width:60%;border-radius:20px"></a>
          </div>
          <div class="col-md-4" align="center" style="padding:20px;">
            <a href="peliculas.php?genero=SCI-FI"><img src="https://m.media-amazon.com/images/G/01/IMDb/genres/Sci-Fi._CB1513316168_SX233_CR0,0,233,131_AL_.jpg" style="width:60%;border-radius:20px"></a>
          </div>
          <div class="col-md-4" align="center" style="padding:20px;">
            <a href="peliculas.php?genero=Drama"><img src="https://m.media-amazon.com/images/G/01/IMDb/genres/Drama._CB1513316168_SX233_CR0,0,233,131_AL_.jpg" style="width:60%;border-radius:20px"></a>
          </div>
          <div class="col-md-4" align="center" style="padding:20px;">
            <a href="peliculas.php?genero=Comedia"><img src="https://m.media-amazon.com/images/G/01/IMDb/genres/Comedy._CB1513316167_SX233_CR0,0,233,131_AL_.jpg" style="width:60%;border-radius:20px"></a>
          </div>
          <div class="col-md-4" align="center" style="padding:20px;">
            <a href="peliculas.php?genero=Romance"><img src="https://m.media-amazon.com/images/G/01/IMDb/genres/Romance._CB1513316168_SX233_CR0,0,233,131_AL_.jpg" style="width:60%;border-radius:20px"></a>
          </div>
       </div>
   </div>
 </body>
</html>
