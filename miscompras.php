<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
</head>

<body>
    <?php   
    $asc = 0;
    
if(!isset($_GET['pagina'])){
  header("location:miscompras.php?pagina=1");
  }
  include "conexion.php";
  require("header.php");
  $est=$_GET['est'];
  $idUsu=$_SESSION['login'];
  $sql = "SELECT * FROM ventas WHERE idestados=$est AND idusuario=$idUsu";
  $estados=mysqli_query($conexion,"SELECT * FROM venta_estados ORDER BY descripcion ASC");
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
  $ventas_x_pag = 5;
  $total_ventas = mysqli_num_rows($consulta);
  $paginas = $total_ventas / $ventas_x_pag;
  $paginas = ceil($paginas);
  if (isset($_GET['pagina'])) {
    $iniciar = ($_GET['pagina'] - 1) * $ventas_x_pag;
    $resultado = mysqli_query($conexion,$sql . " limit $iniciar,$ventas_x_pag");
    ?>
    <script language="javascript">
      
      $(document).ready(function(){
      
        $("#Est").change(function () {	
          $("#Est option:selected").each(function () {
            id_estado = $(this).val();
          
            window.location.href="miscompras.php?pagina=1&est="+id_estado;
                      
          });
          
        });
        
      });
 </script>
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-center text-white">Ventas</h3>
         <form action="buscarventa.php?pagina=1" method="POST">
             <div class="input-group-prepend">
                  <input id="venta" name="venta" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Ingrese venta a buscar">
                  <div class="input-group-append">
                    <button style="border-color: white" class="btn btn-outline-dark" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>
            </div>
        </form>
        <table class="table table-light">
          <thead>
          
            <th scope ="col"><a href="miscompras.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=idventa&ascendente=<?php echo $asc; ?>" >Id</a></th>
            <th scope ="col"><a href="miscompras.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=idusuario&ascendente=<?php echo $asc; ?>" >Usuario</a></th>
            <th scope ="col"><a href="miscompras.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=precio_total&ascendente=<?php echo $asc; ?>" >Precio Total</a></th>
            <<th scope ="col"><a href="miscompras.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=fecha_venta&ascendente=<?php echo $asc; ?>" > Fecha venta</a></th>
            <th scope ="col">Estado</th>
            <th>
              <select name="Est" id="Est">
                <option value='0'>Todos</option>
                  <?php while($rs=mysqli_fetch_array($estados)){?>
                    <option value="<?php echo $rs['idestados'] ?>" <?php if($_GET['est']==$rs['idestados']) echo 'Selected'?>><?php echo $rs['descripcion'];?></option>
                  <?php }; ?>
              </select>
            </th>
          </thead> 
<?php
        
  
    while($fila = $resultado->fetch_assoc()){

        $usuario = mysqli_query($conexion, "SELECT idusuario FROM ventas WHERE idusuario='{$fila['idusuario']}'");
        while ($i = mysqli_fetch_array($usuario)) {
            $idUsuario = $i['idusuario'];
        }
        $selectUsuario = mysqli_query($conexion, "SELECT idusuario,nombre_usuario FROM usuarios WHERE idusuario = $idUsuario");
        while ($usu = mysqli_fetch_array($selectUsuario)) {
            $nombre_usuario = $usu['nombre_usuario'];
        }
        
      echo "<tr>";
      echo "<td>"; echo $fila['idventa']; echo "</td>";
      echo "<td>"; echo $nombre_usuario; echo "</td>";
      echo "<td>"; echo $fila['precio_total']; echo "</td>";
      echo "<td>"; echo $fila['fecha_venta']; echo "</td>";
      $tipoestado=mysqli_query($conexion,"SELECT idestados FROM ventas WHERE idventa='{$fila['idventa']}'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestados'];
                      } 
      $selectEstado=mysqli_query($conexion,"SELECT idestados,descripcion FROM venta_estados WHERE idestados = $idTipoEstado ORDER BY descripcion ASC");
                      while($i=mysqli_fetch_array($selectEstado)){
                        $descripcion=$i['descripcion'];
                      } 
    
                      echo "<td>"; echo $descripcion; echo "</td>";

      echo "<td><form action='verventa.php' method='post'>
                    <input name='venta' id='venta' value='".$fila['idventa']."' hidden>
                    <button type='submit' class='btn btn-success'>Ver</button>
                </form>
            </td>";
    }

  ?>
          </table>
          
        </div>
      </div>
  </div>
      <?php }
      ?>
      <div class="container" style="padding-top:40px">
                        <nav arial-label="page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="miscompras.php?pagina=<?php echo $_GET['pagina'] - 1 ?>&est=<?php echo $_GET['est'];?>">Anterior</a></li>
                                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="miscompras.php?pagina=<?php echo $i ?>&est=<?php echo $_GET['est'];?>"><?php echo $i ?></a></li>
                                <?php endfor ?>
                                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="miscompras.php?pagina=<?php echo $_GET['pagina'] + 1 ?>&est=<?php echo $_GET['est'];?>">Siguiente</a></li>
                            </ul>
                        </nav>
                    </div>

      <?php
        if (isset($_GET['estado'])&& $_GET['estado']==1) {
            echo "<script type='text/javascript'>alert('el cuit ingresado ya existe, intente con otro.');</script>";
        }
        ?>

</body>

</html>