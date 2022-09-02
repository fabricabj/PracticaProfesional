<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Comprobantes leidos</title>
</head>

<body>
    <?php
    $asc = 0;


    
    if (!isset($_GET['pagina'])) {
        header("location:listadocomprobantesleidos.php?pagina=1");
    }
    include "conexion.php";
    $sql = "SELECT * FROM comprobantes WHERE idestado = 2 OR idestado = 1";
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
    $comprobantes_x_pag = 8;
    $total_comprobantes = mysqli_num_rows($consulta);
    $paginas = $total_comprobantes / $comprobantes_x_pag;
    $paginas = ceil($paginas);
    if (isset($_GET['pagina'])) {
        require("header.php");
        $iniciar = ($_GET['pagina'] - 1) * $comprobantes_x_pag;
        $resultado = mysqli_query($conexion, $sql . " limit $iniciar,$comprobantes_x_pag");
    ?>
        <div class="container">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h3 class="text-center text-white">Listado de Comprobantes leidos</h3>
                <table class="table table-light">
                    <thead>

                        <th scope="col"><a href="listadocomprobantesleidos.php?pagina=1&orden=idcomprobante&ascendente=<?php echo $asc; ?>">Id</a></th>
                        <th scope="col"><a href="listadocomprobantesleidos.php?pagina=1&orden=fechapago&ascendente=<?php echo $asc; ?>">Fecha</a></th>
                        <th scope="col"><a href="listadocomprobantesleidos.php?pagina=1&orden=imagen&ascendente=<?php echo $asc; ?>">Descripción</a></th>
                        <th scope="col"><a href="listadocomprobantesleidos.php?pagina=1&orden=idusuario&ascendente=<?php echo $asc; ?>">Usuario</a></th>
                        <th scope="col" class="col-1">Estado</th>
                        <th><a href="listadocomprobante.php"><button type="button" class="btn btn-primary">Leídas</button></a></th>

                    </thead>
                    <?php

                    while ($fila = $resultado->fetch_assoc()) {

                        echo "<tr>";
                        echo "<td>";
                        echo $fila['idcomprobante'];
                        echo "</td>";
                        
                        $tipoestado = mysqli_query($conexion, "SELECT idestado FROM comprobantes WHERE idcomprobante='{$fila['idcomprobante']}'");
                        while ($i = mysqli_fetch_array($tipoestado)) {
                            $idTipoEstado = $i['idestado'];
                        }
                        
                        $fecha = mysqli_query($conexion, "SELECT fechapago FROM comprobantes WHERE idcomprobante='{$fila['idcomprobante']}'");
                        while ($i = mysqli_fetch_array($fecha)) {
                            $fecha1 = $i['fechapago'];
                        }
                        $total = mysqli_query($conexion, "SELECT totalpagar FROM comprobantes WHERE idcomprobante='{$fila['idcomprobante']}'");
                        while ($i = mysqli_fetch_array($total)) {
                            $totalpagar = $i['totalpagar'];
                        }
                        echo "<td>";
                        echo $fecha1;
                        echo "</td>";
                        $usuario = mysqli_query($conexion, "SELECT idusuario FROM comprobantes WHERE idusuario='{$fila['idusuario']}'");
                        while ($i = mysqli_fetch_array($usuario)) {
                            $idUsuario = $i['idusuario'];
                        }
                        
                        $selectEstado = mysqli_query($conexion, "SELECT idestado,descripcion FROM estados_comprobante WHERE idestado = $idTipoEstado ORDER BY descripcion ASC");
                        while ($i = mysqli_fetch_array($selectEstado)) {
                            $estado = $i['descripcion'];
                        }
                        $selectUsuario = mysqli_query($conexion, "SELECT idusuario,nombre_usuario FROM usuarios WHERE idusuario = $idUsuario");
                        while ($usu = mysqli_fetch_array($selectUsuario)) {
                            $nombre_usuario = $usu['nombre_usuario'];
                        }
                        $imagen = mysqli_query($conexion, "SELECT imagen FROM comprobantes WHERE idcomprobante='{$fila['idcomprobante']}'");
                        while ($i = mysqli_fetch_array($imagen)) {
                            $imagen1 = $i['imagen'];
                        }
                        echo "<td>";
                        echo $imagen1;
                        echo "</td>";
                        echo "<td>";                       
                        echo $nombre_usuario;
                        echo "</td>";
                        echo "<td>";
                        echo $estado;
                        echo "</td>";
                        
                        echo "<td>
                        
                                <a type='submit' name='Ver' value='".$fila['idcomprobante']."' href='#' class='btn btn-primary' data-toggle='modal' data-target='#info".$fila['idcomprobante']."'>Ver</a>
                            
                        </td>";
                       ?>
                        
                        <div data-backdrop="static" class="modal fade" id="info<?php echo $fila['idcomprobante']; ?>">
                        <?php 
                            $consulta1=mysqli_query($conexion,"SELECT p.titulo,p.precio FROM peliculas AS p,comprobantes AS c,venta_detalles AS vd  
                                                               WHERE c.idventa = vd.idventa 
                                                                 AND vd.idpelicula = p.idpelicula
                                                                 AND c.idcomprobante = {$fila['idcomprobante']}");
                                
                        ?>
                            <div class="col-md-12 modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Comprobante</h4>
                                    <button type="button" class="close" data-dismiss="modal">X</button>
                                </div>
                                <div class="col-md-12" style="background:#212121">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div align="center" class="col-md-12">
                                                <img src="ImagenesOriginalesComprobante/<?php echo $fila['imagen']; ?>" style="width:80%"><br>
                                            </div>
                                            <?php while($a = mysqli_fetch_array($consulta1)){
                                                $titulo = $a['titulo'];
                                                $precio = $a['precio'];?>
                                                
                                                <div align="center" class="col-md-6">
                                                <label style="color:white">Titulo: <?php echo $titulo;?></label>
                                                </div>
                                                <div align="center" class="col-md-6">
                                                <label style="color:white">Precio: <?php echo $precio;?></label>
                                                </div>
                                                  <?php  }?>
                                                <div align="center" class="col-md-12">
                                                <label style="color:white">Total: <?php echo $totalpagar;?></label>
                                                </div>
                                         </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!--<div align="center" data-backdrop="static" class="modal" id="info<?php //echo $fila['idcomprobante']; ?>">
                        <div class="modal-body">
                        <div class="modal-header">
                            <h4 class="modal-title">Comprobante</h4>
                            <button type="button" class="close" data-dismiss="modal">X</button>
                        </div>
                        <div class="card" style="width: 20%;background:#212121;color:white">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="ImagenesOriginalesComprobante/<?php //echo $fila['imagen']; ?>" style="width:100%"><br>
                            </div>
                            <div class="col-md-6" style="padding-top:30px">
                                <form method="POST">
                                 <button type="submit" name="Aceptado" value=<?php// echo $fila['idcomprobante']?> class="btn btn-success">Aceptar</button>
                                </form>
                            </div>
                            <div class="col-md-6" style="padding-top:30px">
                                <form method="POST">
                                  <button type="submit" name="Rechazado" value=<?php //echo $fila['idcomprobante']?> class="btn btn-danger">Rechazado</button>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>-->
                   
                    <?php
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
                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="listadocomprobante.php?pagina=<?php echo $_GET['pagina'] - 1 ?>">Anterior</a></li>
                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="listadocomprobante.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php endfor ?>
                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="listadocomprobante.php?pagina=<?php echo $_GET['pagina'] + 1 ?>">Siguiente</a></li>
            </ul>
        </nav>
    </div>

    <?php


    if (isset($_GET['estado']) && $_GET['estado'] == 1) {
        echo "<script type='text/javascript'>alert('el cuit ingresado ya existe, intente con otro.');</script>";
    }
    ?>

</body>

</html>