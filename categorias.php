
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
       <div class="row">
         <?php 
              $select=mysqli_query($conexion,"SELECT * FROM categoria");
              while($r=mysqli_fetch_array($select)){
         ?>
                <div class="col-md-4" align="center" style="padding:20px;">
                  <a href="peliculas.php?genero=<?php echo $r['nombrecategoria'];?>"><img src="<?php echo $r['imagen'];?>" style="width:60%;border-radius:20px"></a>
                </div>
         <?php }?>
       </div>
   </div>
 </body>
</html>
