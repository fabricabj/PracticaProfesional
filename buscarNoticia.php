<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <style>
      .ordenButton{
         border: none;
         color:#2979ff;
         font-weight: bold;
       
       }
       .ordenButton:hover{
         color:#1565c0;
         text-decoration: underline;
       }
       
    </style>

</head>

<body>
    <?php   
    $asc = 0;

    if(!isset($_GET['pagina'])){
      header("location:buscarNoticia.php?pagina=1");
      }
      include "conexion.php";
      
  if (isset($_GET['pagina'])) {
    require("header.php"); 

       $nombre_noticia=$_POST['nombre_noticia'];
       $est=$_POST['estado'];

  $sql = "SELECT * FROM noticias WHERE (nombre_noticia like '%$nombre_noticia%') AND idestado=$est";
  $consulta = mysqli_query($conexion,$sql);
  if(isset($_POST['orden'])){
    if(isset($_POST['ascendente'])){
      if($_POST['ascendente']==1){
        $sql2 = " ASC";
        $asc = 0;
      }else{
        $sql2 = " DESC";
        $asc = 1;
      }
    }
    $sql.=" ORDER BY " . $_POST['orden'] . $sql2;
  }
  $noticias_x_pag = 5;
  $total_noticias = mysqli_num_rows($consulta);
  $paginas = $total_noticias / $noticias_x_pag;
  $paginas = ceil($paginas);
    $iniciar = ($_GET['pagina'] - 1) * $noticias_x_pag;
    $resultado = mysqli_query($conexion,$sql . " limit $iniciar,$noticias_x_pag");
      }
    ?>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Listado de Noticias</h3>
        <form action="buscarNoticia.php?pagina=1" method="POST">
             <div class="input-group-prepend">
                  <input id="nombre_noticia" name="nombre_noticia" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Ingrese título a buscar">
                  <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
                  <div class="input-group-append">
                    <button style="border-color: white" class="btn btn-outline-dark" type="submit" name="Buscar" value="Buscar" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>
            </div>
        </form>
        <table class="table table-light">
          <thead>
            <form action="buscarNoticia.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="idnoticia" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="estado" name="estado" value="<?php echo $_POST['estado'];?>" hidden>
                <input type="text" id="nombre_noticia" name="nombre_noticia" value="<?php echo $_POST['nombre_noticia'];?>" hidden>
                <button type="submit" class="ordenButton" name="Id" value="Id">Id</button>
            </form>
            <form action="buscarNoticia.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="nombre_noticia" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="estado" name="estado" value="<?php echo $_POST['estado'];?>" hidden>
                <input type="text" id="nombre_noticia" name="nombre_noticia" value="<?php echo $_POST['nombre_noticia'];?>" hidden>
                <button type="submit" class="ordenButton" name="nombre" value="nomre">Nombre</button>
            </form>
            <form action="buscarNoticia.php?pagina=1" method="POST">
               <th scope ="col">
                <input type="text" id="orden" name="orden" value="descripcion" hidden>
                <input type="text" id="ascendente" name="ascendente" value="<?php echo $asc;?>" hidden>
                <input type="text" id="estado" name="estado" value="<?php echo $_POST['estado'];?>" hidden>
                <input type="text" id="nombre_noticia" name="nombre_noticia" value="<?php echo $_POST['nombre_noticia'];?>" hidden>
                <button type="submit" class="ordenButton" name="descripcion" value="descripcion">Descripción</button>
            </form>
            <th scope ="col">Estado</th>
            
 
   
</thead> 
<?php
  
    while($fila = $resultado->fetch_assoc()){

      echo "<tr>";
      echo "<td>"; echo $fila['idnoticia']; echo "</td>";
      echo "<td>"; echo $fila['nombre_noticia']; echo "</td>";
      echo "<td>"; echo $fila['descripcion']; echo "</td>";
      $tipoestado=mysqli_query($conexion,"SELECT idestado FROM noticias WHERE idnoticia='{$fila['idnoticia']}'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestado'];
                      } 
      $selectEstado=mysqli_query($conexion,"SELECT idestado,descripcion FROM estados_noticias WHERE idestado = $idTipoEstado ORDER BY descripcion ASC");
                      while($i=mysqli_fetch_array($selectEstado)){
                        $descripcion=$i['descripcion'];
                      } 
                      echo "<td>"; echo $descripcion; echo "</td>";

      echo "<td><form action='altaNoticia.php' method='post'>
                    <input name='idnoticia' id='idnoticia' value='".$fila['idnoticia']."' hidden>
                    <button type='submit' class='btn btn-success'>Modificar</button>
                </form>
            </td>";
      if($est==1){   
        echo "<td><input type='text' name='eliminarNoticia' id='eliminarNoticia' value='eliminarNoticia' hidden>
              <input type='text' name='pagina' id='pagina' value='".$_GET['pagina']."' hidden>
              <a style='margin: 5px;' href='#' onclick='eliminarNoticia(".$fila['idnoticia'].",".$_GET['pagina'].",".$est.")' class='btn btn-danger'>Inactivar</a></td>';
          </form>
      </td>";
      }else{
        echo "<td><form action='abm_noticias.php' method='post'>
              <input name='id' id='id' value='".$fila['idnoticia']."'hidden>
              <button class='btn btn-danger' name='activar' id='activar' value='activar'>Activar</button>
          </form>
      </td>";
      }
     
    }

  ?>
          </table>
          
        </div>
      </div>
  </div>
  <div class="container" style="padding-top:40px">
    <nav arial-label="page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>">
          <form action="buscarNoticia.php?pagina=<?php echo $_GET['pagina'] - 1 ?>" method="POST">
            <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
            <input id="nombre_noticia" name="nombre_noticia" value="<?php echo $nombre_noticia;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
            <button name="buscar" value="buscar" class="page-link" id="button-addon2">Anterior</button>
          </form>
        </li>
        <?php for ($i = 1; $i <= $paginas; $i++) : ?>
        <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>">
          <form action="buscarNoticia.php?pagina=<?php echo $i ?>" method="POST">
            <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
            <input id="nombre_noticia" name="nombre_noticia" value="<?php echo $nombre_noticia;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
            <button name="buscar" value="buscar" class="page-link" id="button-addon2"><?php echo $i ?></button>
          </form>
        </li>
        <?php endfor ?>
        <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>">
          <form action="buscarNoticia.php?pagina=<?php echo $_GET['pagina'] + 1 ?>" method="POST">
            <input id="estado" name="estado" type="text" value="<?php echo $est;?>" hidden>
            <input id="nombre_noticia" name="nombre_noticia" value="<?php echo $nombre_noticia;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
            <button name="buscar" value="buscar" class="page-link" id="button-addon2">Siguiente</button>
          </form>
        </li>
      </ul>
    </nav>
  </div>

      <?php
        if (isset($_GET['estado'])&& $_GET['estado']==1) {
            echo "<script type='text/javascript'>alert('el cuit ingresado ya existe, intente con otro.');</script>";
        }
        ?>
<script>
  function eliminarNoticia(idNoticia,pagina,estado){
      var eliminar = confirm('De verdad desea inactivar esta noticia');
      var eliminarNoticia=document.getElementById('eliminarNoticia').value;
      if ( eliminar ) {
          
          $.ajax({
              url: 'abm_noticias.php',
              type: 'POST',
              data: { 
                  id: idNoticia,
                  delete: eliminarNoticia,
                  est: estado,
              
              },
          })
          .done(function(response){
              $("#result").html(response);
          })
          .fail(function(jqXHR){
              console.log(jqXHR.statusText);
          });
          window.location.href ='listarNoticias.php?pagina='+pagina+'&est='+estado;
      }
  } 
</script>

</body>

</html>