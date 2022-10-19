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
  header("location:proveedores.php?pagina=1");
  }
  include "conexion.php";
  $est=$_GET['est'];
$sql = "SELECT * FROM proveedores WHERE idestado = $est";
$estados=mysqli_query($conexion,"SELECT * FROM estados_provedores ORDER BY descripcion DESC");
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
$proveedores_x_pag = 5;
$total_proveedores = mysqli_num_rows($consulta);
$paginas = $total_proveedores / $proveedores_x_pag;
$paginas = ceil($paginas);
if (isset($_GET['pagina'])) {
require("header.php");
$iniciar = ($_GET['pagina'] - 1) * $proveedores_x_pag;
$resultado = mysqli_query($conexion,$sql . " limit $iniciar,$proveedores_x_pag");
?>
<script language="javascript">
      
      $(document).ready(function(){
      
        $("#Est").change(function () {	
          $("#Est option:selected").each(function () {
            id_estado = $(this).val();
          
            window.location.href="proveedores.php?pagina=1&est="+id_estado;
                      
          });
          
        });
        
      });
 </script>
<div class="container">
  <div class="col-sm-12 col-md-12 col-lg-12">
    <h3 class="text-center text-white">Listado de Proveedores</h3>
    <?php if (isset($_GET['estado'])&& $_GET['estado']==1) {
            echo "<div class='alert alert-success'>Proveedor agregado con exito!!</div>";
          }
          if (isset($_GET['estado'])&& $_GET['estado']==2) {
            echo "<div class='alert alert-success'>Proveedor modificado con exito!!</div>";
          }
          if (isset($_GET['estado'])&& $_GET['estado']==3) {
            echo "<div class='alert alert-success'>Proveedor inactivado con exito!!</div>";
          }
          if (isset($_GET['estado'])&& $_GET['estado']==4) {
            echo "<div class='alert alert-success'>Proveedor activado con exito!!</div>";
          }
          if (isset($_GET['estado'])&& $_GET['estado']==5) {
            echo "<div class='alert alert-success'>Cuit ya existente, intente con otro!!</div>";
          }
          if (isset($_GET['estado'])&& $_GET['estado']==6) {
            echo "<div class='alert alert-success'>Mail ya existente, intente con otro!!</div>";
          }?>
    <form action="buscarProveedores.php?pagina=1" method="POST">
             <div class="input-group-prepend">
             <input id="razonsocial" name="razonsocial" style="background:black;color:white" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Ingrese título a buscar">
                  <input id="estado" name="estado" type="text" value="<?php echo $_GET['est'];?>" hidden>
                <div class="input-group-append">
                  <button style="border-color: white" class="btn btn-outline-dark" type="submit" name="Buscar" value="Buscar" id="button-addon2"><i class="fas fa-search"></i></button>
                  </div>
            </div>
        </form>
    <table class="table table-light">
      <thead>
      
        <th scope ="col"><a href="proveedores.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=idproveedor&ascendente=<?php echo $asc; ?>" >Id</a></th>
        <th scope ="col"><a href="proveedores.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=razon_social&ascendente=<?php echo $asc; ?>" >Razón Social</a></th>
        <th scope ="col"><a href="proveedores.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=cuit&ascendente=<?php echo $asc; ?>" >Cuit</a></th>
        <th scope ="col"><a href="proveedores.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=mail&ascendente=<?php echo $asc; ?>" > Mail</a></th>
        <th scope ="col">Estado</th>
        <th>
        <?php if($_GET['est']==1){ ?>
          <a href="altaproveedores.php">
            <button type="button" class="btn btn-warning">Nuevo</button>
          </a>
          <?php }?>
        </th>
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
        if($_GET['est']==1){
          echo '<td><input type="text" name="eliminarProveedor" id="eliminarProveedor" value="eliminarProveedor" hidden>
                <input type="text" name="pagina" id="pagina" value="'.$_GET['pagina'].'" hidden>
                <a style="margin: 5px;" href="#" onclick="eliminarProveedor('.$fila['idproveedor'].','.$_GET['pagina'].','.$_GET['est'].')" class="btn btn-danger">Inactivar</a></td>';
        }else{  
          echo "<td><form action='abmproveedores.php' method='post'>
                <input name='id' id='id' value='".$fila['idproveedor']."'hidden>
                <button type='submit' class='btn btn-danger' name='activar' id='activar' value='activar'>Activar</button>
            </form>
        </td>";
        }

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
                            <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="proveedores.php?pagina=<?php echo $_GET['pagina'] - 1 ?>&est=<?php echo $_GET['est'];?>">Anterior</a></li>
                            <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                                <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="proveedores.php?pagina=<?php echo $i ?>&est=<?php echo $_GET['est'];?>"><?php echo $i ?></a></li>
                            <?php endfor ?>
                            <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="proveedores.php?pagina=<?php echo $_GET['pagina'] + 1 ?>&est=<?php echo $_GET['est'];?>">Siguiente</a></li>
                        </ul>
                    </nav>
                </div>

<script>
                        function eliminarProveedor(idproveedor,pagina,estado){
                            var eliminar = confirm('De verdad desea inactivar este Proveedor');
                            var eliminarProveedor=document.getElementById('eliminarProveedor').value;
                            if ( eliminar ) {
                                
                                $.ajax({
                                    url: 'abmproveedores.php',
                                    type: 'POST',
                                    data: { 
                                        id: idproveedor,
                                        Delete: eliminarProveedor,
                                        est: estado,
                                    
                                    },
                                })
                                .done(function(response){
                                    $("#result").html(response);
                                })
                                .fail(function(jqXHR){
                                    console.log(jqXHR.statusText);
                                });
                                window.location.href ='proveedores.php?pagina='+pagina+'&est='+estado+'&estado=3';
                            }
                        } 
         </script>

</body>

</html>