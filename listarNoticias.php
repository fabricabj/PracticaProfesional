<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>     
</head>

<body>
    <?php   
    $asc = 0;
    
    if(!isset($_GET['pagina'])){
      header("location:listarNoticias.php?pagina=1");
      }
      include "conexion.php";
      $est=$_GET['est'];
  $sql = "SELECT * FROM noticias WHERE idestado = $est";
  $estados=mysqli_query($conexion,"SELECT * FROM estados_noticias ORDER BY descripcion ASC");
  $consulta = mysqli_query($conexion,$sql);
  if(isset($_GET['orden'])){
    if(isset($_GET['ascendente'])){
      if($_GET['ascendente']==1){
        $sql2 = " ASC";
        $asc = 0;
      }else{
        $sql2 = " DESC";
        $asc = 1;
      }
    }
    $sql.=" ORDER BY " . $_GET['orden'] . $sql2;
  }
  $noticias_x_pag = 5;
  $total_noticias = mysqli_num_rows($consulta);
  $paginas = $total_noticias / $noticias_x_pag;
  $paginas = ceil($paginas);
  if (isset($_GET['pagina'])) {
    require("header.php");
    $iniciar = ($_GET['pagina'] - 1) * $noticias_x_pag;
    $resultado = mysqli_query($conexion,$sql . " limit $iniciar,$noticias_x_pag");
      }
    ?>
    <script language="javascript">
      
      $(document).ready(function(){
      
        $("#Est").change(function () {	
          $("#Est option:selected").each(function () {
            id_estado = $(this).val();
          
            window.location.href="listarNoticias.php?pagina=1&est="+id_estado;
                      
          });
          
        });
        
      });
 </script>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Listado de Noticias</h3>
        <?php if (isset($_GET['estado'])&& $_GET['estado']==1) {
                echo "<div class='alert alert-success'>Noticia inactivada con exito!!</div>";
              }
              if (isset($_GET['estado'])&& $_GET['estado']==2) {
                echo "<div class='alert alert-success'>Noticia activada con exito!!</div>";
              }?>
        <form action="buscarNoticia.php?pagina=1" method="POST">
             <div class="input-group-prepend">
                  <input id="nombre_noticia" name="nombre_noticia" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Ingrese título a buscar">
                  <input id="estado" name="estado" type="text" value="<?php echo $_GET['est'];?>" hidden>
                  <div class="input-group-append">
                    <button style="border-color: white" class="btn btn-outline-dark" type="submit" name="Buscar" value="Buscar" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>
            </div>
        </form>
        <table class="table table-light">
          <thead>
          
            <th scope ="col"><a href="listarNoticias.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=idnoticia&ascendente=<?php echo $asc; ?>" >Id</a></th>
            <th scope ="col"><a href="listarNoticias.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=nombre_noticia&ascendente=<?php echo $asc; ?>" >Nombre Noticia</a></th>
            <th scope ="col"><a href="listarNoticias.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=descripcion&ascendente=<?php echo $asc; ?>" >Descripción</a></th>
            <!--<th scope ="col"><a href="listarNoticias.php?pagina=1&orden=mail&ascendente=<?php echo $asc; ?>" > Mail</a></th>-->
            <th scope ="col">Estado</th>
            <th>
              <?php if($_GET['est']==1){ ?>
              <form action="altaNoticia.php" method="POST"> 
                  <button name='alta' value='alta' class="btn btn-warning">Nuevo</button>
              </form></th>
              <?php }?>
            <th>
              <select name="Est" id="Est">
							   <option value='0'>Todos</option>
							    <?php while($rs=mysqli_fetch_array($estados)){?>
								    <option value="<?php echo $rs['idestado'] ?>" <?php if($_GET['est']==$rs['idestado']) echo 'Selected'?>><?php echo $rs['descripcion'];?></option>
							    <?php }; ?>
						  </select>
            </th>
</thead> 
<?php
  
    while($fila = $resultado->fetch_assoc()){

      echo "<tr>";
      echo "<td>"; echo $fila['idnoticia']; echo "</td>";
      echo "<td>"; echo $fila['nombre_noticia']; echo "</td>";
      echo "<td>"; echo $fila['descripcion']; echo "</td>";
      //echo "<td>"; echo $fila['idestado']; echo "</td>";
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
            if($_GET['est']==1){   
              echo '<td><input type="text" name="eliminarNoticia" id="eliminarNoticia" value="eliminarNoticia" hidden>
                    <input type="text" name="pagina" id="pagina" value="'.$_GET['pagina'].'" hidden>
                    <a style="margin: 5px;" href="#" onclick="eliminarNoticia('.$fila['idnoticia'].','.$_GET['pagina'].','.$_GET['est'].')" class="btn btn-danger">Inactivar</a></td>';
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
                                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="listarNoticias.php?pagina=<?php echo $_GET['pagina'] - 1 ?>&est=<?php echo $_GET['est'];?>">Anterior</a></li>
                                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="listarNoticias.php?pagina=<?php echo $i ?>&est=<?php echo $_GET['est'];?>"><?php echo $i ?></a></li>
                                <?php endfor ?>
                                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="listarNoticias.php?pagina=<?php echo $_GET['pagina'] + 1 ?>&est=<?php echo $_GET['est'];?>">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>
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
                                window.location.href ='listarNoticias.php?pagina='+pagina+'&est='+estado+'&estado=1';
                            }
                        } 
         </script>
</body>

</html>