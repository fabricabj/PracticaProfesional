<!DOCTYPE html>
<html>

<head>
  <title>Mi lista</title>
  <style>
    .lista img {
      width: 120px;
      height: 180px;
    }

    .lista {
      color: #e0e0e0;
    }
  </style>
</head>

<body>
  <?php
  require("header.php");
  require("conexion.php");
  ?>
  <div class="container">
    <div class="row" style="padding-top:40px"> 
      <div class="col-md-12" style="background:#212121">
        <?php if (isset($_SESSION['login'])) {
          $idUser = $_SESSION['login'];
          $consulta = mysqli_query($conexion, "SELECT p.idpelicula, p.titulo,p.puntaje,
                    p.imagen,p.anio,p.duracion,p.categorias,p.descripcion,f.idusuario from peliculas AS p,favoritos AS f
                   where p.idpelicula=f.idpelicula and f.idusuario='$idUser' and p.idestado=1");
          while ($r = mysqli_fetch_array($consulta)) { ?>
            <div class="row" style="padding-top:20px">
              <div class="col-md-2">
                <div class="lista">
                  <img src="imagenes/<?php echo $r['imagen']; ?>">
                </div>
              </div>
              <div class="col-md-10">
                <div class="row">
                  <div class="col-md-8 lista">
                    <h4><?php echo $r['titulo']; ?></h4>
                    <h6><?php echo $r['anio'] . " |" . $r['duracion'] . "min |" . $r['categorias']; ?></h6>
                    <br>
                    <h6><?php echo $r['descripcion']; ?></h6>
                  </div>
                  <div align="center" class="col-md-4 lista">
                    <br><br><br>
                    <a style="text-decoration:underline;cursor:pointer; float: left;margin-right:5px;border-radius:30px;margin-top: 2%" class="btn btn-danger card-text" href="#" onclick="eliminarDato(<?php echo $r['idpelicula']?>)">Quitar de la lista</a>
                  </div>
                  
                </div>
              </div>
            </div>
            <hr style="background:grey;height:1px">
        <?php }
        } ?>
      </div>
    </div>
  </div>
  <?php if (isset($_GET['estado']) && $_GET['estado'] == 1) {
    echo "<script>alert('pelicula eliminada de la lista');</script>";
  } 
 
  ?>

  <script>
    function init() {
      $('#lista').attr("class", "");
      $('#lista').attr("class", "btn btn-danger");
    }
    window.onload = function() {
      init();
    }
    function eliminarDato(idpelicula){
    var eliminar = confirm('De verdad desea eliminar esta pelicula?');
 
  
    if ( eliminar ) {
          
          $.ajax({
            url: 'eliminarLista.php',
            type: 'POST',
            data: { 
                id: idpelicula,
                
              
            },
         })
         .done(function(response){
            $("#result").html(response);
         })
         .fail(function(jqXHR){
            console.log(jqXHR.statusText);
         });
         alert('La pelicula ha sido eliminada');
         window.location.href="lista.php";
    }
} 
  </script>
</body>

</html>