<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Sugerencias</title>
</head>

<body>
    <?php
    $asc = 0;

    if (isset($_POST['leido'])){
        include "conexion.php";
        $idSug = $_POST['leido'];
        $Actualizar = "UPDATE sugerencias SET idestado=1 WHERE idsugerencia='$idSug'";
        $enviar = mysqli_query($conexion, $Actualizar);
    }

    
    if (!isset($_GET['pagina'])) {
        header("location:listadoSugerencia.php?pagina=1");
    }
    include "conexion.php";
    $est=$_GET['est'];
    $sql = "SELECT * FROM sugerencias WHERE idestado = $est";
    $estados=mysqli_query($conexion,"SELECT * FROM sugerencia_estados ORDER BY descripcion ASC");
    $consulta = mysqli_query($conexion, $sql);
    if (isset($_GET['orden'])) {
        if (isset($_GET['ascendente'])) {
            if ($_GET['ascendente'] == 1) {
                $sql2 = " ASC";
                $asc = 0;
            } else {
                $sql2 = " DESC";
                $asc = 1;
            }
        }
        $sql .= " ORDER BY " . $_GET['orden'] . $sql2;
    }
    $sugerencias_x_pag = 5;
    $total_sugerencias = mysqli_num_rows($consulta);
    $paginas = $total_sugerencias / $sugerencias_x_pag;
    $paginas = ceil($paginas);
    if (isset($_GET['pagina'])) {
        require("header.php");
        $iniciar = ($_GET['pagina'] - 1) * $sugerencias_x_pag;
        $resultado = mysqli_query($conexion, $sql . " limit $iniciar,$sugerencias_x_pag");
    ?>
    <script language="javascript">
      
      $(document).ready(function(){
      
        $("#Est").change(function () {	
          $("#Est option:selected").each(function () {
            id_estado = $(this).val();
          
            window.location.href="listadoSugerencia.php?pagina=1&est="+id_estado;
                      
          });
          
        });
        
      });
 </script>
        <div class="container">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h3 class="text-center text-white">Listado de Sugerencias</h3>
                <table class="table table-light">
                    <thead>

                        <th scope="col"><a href="listadoSugerencia.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=idsugerencia&ascendente=<?php echo $asc; ?>">Id</a></th>
                        <th scope="col"><a href="listadoSugerencia.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=fecha&ascendente=<?php echo $asc; ?>">Fecha</a></th>
                        <th scope="col"><a href="listadoSugerencia.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=descripcion&ascendente=<?php echo $asc; ?>">Descripción</a></th>
                        <th scope="col"><a href="listadoSugerencia.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=idusuario&ascendente=<?php echo $asc; ?>">Usuario</a></th>
                        <th scope="col" class="col-1">Estado</th>
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

                    while ($fila = $resultado->fetch_assoc()) {
                        $fecha=date('d/m/Y',strtotime($fila['fecha'])); 
                        echo "<tr>";
                        echo "<td>";
                        echo $fila['idsugerencia'];
                        echo "</td>";
                        echo "<td>";
                        echo $fecha;
                        echo "</td>";
                        echo "<td>";
                        echo $fila['descripcion'];
                        echo "</td>";
                        $tipoestado = mysqli_query($conexion, "SELECT idestado FROM sugerencias WHERE idsugerencia='{$fila['idsugerencia']}'");
                        while ($i = mysqli_fetch_array($tipoestado)) {
                            $idTipoEstado = $i['idestado'];
                        }
                        $usuario = mysqli_query($conexion, "SELECT idusuario FROM sugerencias WHERE idusuario='{$fila['idusuario']}'");
                        while ($i = mysqli_fetch_array($usuario)) {
                            $idUsuario = $i['idusuario'];
                        }
                        echo "<td>";                       
                        echo $nombre_usuario;
                        echo "</td>";
                        $selectEstado = mysqli_query($conexion, "SELECT idestado,descripcion FROM sugerencia_estados WHERE idestado = $idTipoEstado ORDER BY descripcion ASC");
                        while ($i = mysqli_fetch_array($selectEstado)) {
                            $descripcion = $i['descripcion'];
                        }
                        $selectUsuario = mysqli_query($conexion, "SELECT idusuario,nombre_usuario FROM usuarios WHERE idusuario = $idUsuario");
                        while ($usu = mysqli_fetch_array($selectUsuario)) {
                            $nombre_usuario = $usu['nombre_usuario'];
                        }
                        echo "<td>";
                        echo $descripcion;
                        echo "</td>";
                        if($_GET['est']==2){
                        echo "<td>
                            <form method='POST'>
                                <button type='submit' name='leido' value='".$fila['idsugerencia']."' class='btn btn-success'>Leer</button>
                            </form>
                        </td>";
                        }
                        
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
                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="listadosugerencia.php?pagina=<?php echo $_GET['pagina'] - 1 ?>&est=<?php echo $_GET['est'];?>">Anterior</a></li>
                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="listadosugerencia.php?pagina=<?php echo $i ?>&est=<?php echo $_GET['est'];?>"><?php echo $i ?></a></li>
                <?php endfor ?>
                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="listadosugerencia.php?pagina=<?php echo $_GET['pagina'] + 1 ?>&est=<?php echo $_GET['est'];?>">Siguiente</a></li>
            </ul>
        </nav>
    </div>

</body>

</html>