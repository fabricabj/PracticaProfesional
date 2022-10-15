
<!DOCTYPE html>
<html>
<head>
    <title>Categorías</title>
</head>
<body>
   <?php 
      require("header.php");
      require("conexion.php");   

   ?>
   <div class="container">
   <?php if (isset($_GET['estado'])&& $_GET['estado']==1) {
            echo "<div class='alert alert-success'>Pelicula agregada con exito!!</div>";
          }
          if (isset($_GET['estado'])&& $_GET['estado']==2) {
            echo "<div class='alert alert-success'>Pelicula modificada con exito!!</div>";
          }?>
        <h1 align="center" style="color:white">Categorias</h1>
       <div class="row">
         <?php 
              $select=mysqli_query($conexion,"SELECT * FROM categoria");
              while($r=mysqli_fetch_array($select)){
         ?>     
         <div class="col-md-4" align="center" style="padding:20px;">
                  <h4><strong style="color:white"><?php echo $r['nombrecategoria'];?></strong></h4>
                  <a href="peliculas.php?genero=<?php echo $r['nombrecategoria'];?>"><img src="categorias/<?php echo $r['imagen'];?>" style="width:60%;border-radius:20px"></a>
                </div>
         <?php }?>
       </div>
   </div>
 </body>
</html>


