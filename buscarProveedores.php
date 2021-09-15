<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Proveedores</title>
</head>

<body>
<?php   
$asc = 0;

if(!isset($_GET['pagina'])){
  header("location:buscarProveedores.php?pagina=1");
  }
  include "conexion.php";

if (isset($_GET['pagina'])) {
require("header.php");
$razon_social =$_POST['razon_social'];
$sql = "SELECT * FROM proveedores WHERE(razon_social like '%$razon_social%') AND idestado = 1";
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
$proveedores_x_pag = 2;
$total_proveedores = mysqli_num_rows($consulta);
$paginas = $total_proveedores / $proveedores_x_pag;
$paginas = ceil($paginas);
$iniciar = ($_GET['pagina'] - 1) * $proveedores_x_pag;
$resultado = mysqli_query($conexion,$sql . " limit $iniciar,$proveedores_x_pag");
?>
<div class="container">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <h3 class="text-center text-white">Listado de Proveedores</h3>
    <form action="buscarProveedores.php?pagina=1" method="POST">
             <div class="input-group-prepend">
                  <input id="razon_social" name="razon_social" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="ingrese el titulo a buscar">
                  <div class="input-group-append">
                    <button style="border-color: white" class="btn btn-outline-dark" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>
            </div>
        </form>
    <table class="table table-light">
      <thead>
      
        <th scope ="col"><a href="proveedores.php?pagina=1&orden=idproveedor&ascendente=<?php echo $asc; ?>" >Id</a></th>
        <th scope ="col"><a href="proveedores.php?pagina=1&orden=razon_social&ascendente=<?php echo $asc; ?>" >Razòn Social</a></th>
        <th scope ="col"><a href="proveedores.php?pagina=1&orden=cuit&ascendente=<?php echo $asc; ?>" >Cuit</a></th>
        <th scope ="col"><a href="proveedores.php?pagina=1&orden=mail&ascendente=<?php echo $asc; ?>" > Mail</a></th>
        <th scope ="col">Estado</th>
        <th><a href="altaproveedores.php"><button type="button" class="btn btn-warning">Nuevo</button></a></th>
        <th><a href="proveedoresinactivos.php"><button type="button" class="btn btn-secondary">Inactivos</button></a></th>
        
</thead> 
<?php

while($fila = $resultado->fetch_assoc()){

  echo "<tr>";
  echo "<td>"; echo $fila['idproveedor']; echo "</td>";
  echo "<td>"; echo $fila['razon_social']; echo "</td>";
  echo "<td>"; echo $fila['cuit']; echo "</td>";
  echo "<td>"; echo $fila['mail']; echo "</td>";
  $tipoestado=mysqli_query($conexion,"SELECT idestado FROM proveedores WHERE cuit='{$fila['cuit']}'");
                  while($i=mysqli_fetch_array($tipoestado)){
                      $idTipoEstado=$i['idestado'];
                  } 
  $selectEstado=mysqli_query($conexion,"SELECT idestado,descripcion FROM estados_provedores WHERE idestado = $idTipoEstado ORDER BY descripcion ASC");
                  while($i=mysqli_fetch_array($selectEstado)){
                    $descripcion=$i['descripcion'];
                  } 
                  echo "<td>"; echo $descripcion; echo "</td>";

  echo "<td><form action='modificarproveedores.php' method='post'>
                <input name='cuit' id='cuit' value='".$fila['cuit']."' hidden>
                <button type='submit' class='btn btn-success'>Modificar</button>
            </form>
        </td>";
          echo "<td><form action='abmproveedores.php' method='post'>
                <input name='cuit' id='cuit' value='".$fila['cuit']."'hidden>
                <button type='submit' class='btn btn-danger' name='btnEliminar' id='btnEliminar' value='btnEliminar'>Eliminar</button>
            </form>
        </td>";
// echo "<td><a href='abmproveedores.php'><button type='button' class='btn btn-danger'>Eliminar</button></a></td>";
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
      <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>">
        <form action="buscarProveedores.php?pagina=<?php echo $_GET['pagina'] - 1 ?>" method="POST">
          <input id="razon_social" name="razon_social" value="<?php echo $razon_social;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2">Anteriror</button>
          
        </form>
      </li>
      <?php for ($i = 1; $i <= $paginas; $i++) : ?>
       <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>">
         <form action="buscarProveedores.php?pagina=<?php echo $i ?>" method="POST">
          <input id="razon_social" name="razon_social" value="<?php echo $razon_social;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
          <button name="buscar" value="buscar" class="page-link" id="button-addon2"><?php echo $i ?></button>
        </form>
      </li>
    <?php endfor ?>
    <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>">
     <form action="buscarProveedores.php?pagina=<?php echo $_GET['pagina'] + 1 ?>" method="POST">
      <input id="razon_social" name="razon_social" value="<?php echo $razon_social;?>" style="width:70%" type="text" class="form-control" aria-label="Text input with dropdown button" hidden>
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

</body>

</html>