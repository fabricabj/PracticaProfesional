<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Comprobantes</title>
</head>

<body>
    <?php
    $asc = 0;

    if (isset($_POST['Rechazar'])){
        include "conexion.php";
        $idComprobante = $_POST['Rechazado'];
        $Actualizar = "UPDATE comprobantes SET idestado=2 WHERE idcomprobante='$idComprobante'";
        $enviar = mysqli_query($conexion, $Actualizar);
    }

    
    if (!isset($_GET['pagina'])) {
        header("location:listadocomprobante.php?pagina=1");
    }
    include "conexion.php";
    $est=$_GET['est'];
    $sql = "SELECT * FROM comprobantes WHERE idestado = $est";
    $estados=mysqli_query($conexion,"SELECT * FROM estados_comprobante ORDER BY descripcion ASC");
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
    $comprobantes_x_pag = 5;
    $total_comprobantes = mysqli_num_rows($consulta);
    $paginas = $total_comprobantes / $comprobantes_x_pag;
    $paginas = ceil($paginas);
    if (isset($_GET['pagina'])) {
        require("header.php");
        $iniciar = ($_GET['pagina'] - 1) * $comprobantes_x_pag;
        $resultado = mysqli_query($conexion, $sql . " limit $iniciar,$comprobantes_x_pag");
    ?>
    <script language="javascript">
      
      $(document).ready(function(){
      
        $("#Est").change(function () {	
          $("#Est option:selected").each(function () {
            id_estado = $(this).val();
          
            window.location.href="listadocomprobante.php?pagina=1&est="+id_estado;
                      
          });
          
        });
        
      });
 </script>
        <div class="container">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h3 class="text-center text-white">Listado de Comprobantes</h3>
                <table class="table table-light">
                    <thead>
                        <th scope="col"><a href="listadocomprobante.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=idcomprobante&ascendente=<?php echo $asc; ?>">Id</a></th>
                        <th scope="col"><a href="listadocomprobante.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=fechapago&ascendente=<?php echo $asc; ?>">Fecha</a></th>
                        <th scope="col"><a href="listadocomprobante.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=imagen&ascendente=<?php echo $asc; ?>">Descripción</a></th>
                        <th scope="col"><a href="listadocomprobante.php?pagina=1&est=<?php echo $_GET['est'];?>&orden=idusuario&ascendente=<?php echo $asc; ?>">Usuario</a></th>
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
                            $fecha1=date('d/m/Y',strtotime($i['fechapago'])); 
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
                                $consulta10 = mysqli_query($conexion, "SELECT * FROM comprobantes WHERE idcomprobante = {$fila['idcomprobante']}");
                                while($g = mysqli_fetch_array($consulta10)){
                                    $fechaPago =$g['fechapago'];
                                    $tipoPago =$g['tipopago'];
                                    $totalPagar =$g['totalpagar'];
                                    $Comprobante =$g['idcomprobante'];
                                    $idventa =$g['idventa'];
                                }
                                $consulta1=mysqli_query($conexion,"SELECT p.titulo,p.precio FROM peliculas AS p,comprobantes AS c,venta_detalles AS vd  
                                                               WHERE c.idventa = vd.idventa 
                                                                 AND vd.idpelicula = p.idpelicula
                                                                 AND c.idcomprobante = {$fila['idcomprobante']}");
                                
                        ?>

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
                                                <label style="color:white">Título: <?php echo $titulo;?></label>
                                                </div>
                                                <div align="center" class="col-md-6">
                                                <label style="color:white">Precio: <?php echo '$' . $precio;?></label>
                                                </div>
                                                  <?php  }?>
                                                <div align="center" class="col-md-12">
                                                <label style="color:white">Total: <?php echo '$' . $totalpagar;?></label>
                                                </div>
                                                <?php if($_GET['est']==3){  ?>
                                                <div align="center" class="col-md-6" style="padding-top:30px">
                                                    <form method="POST" action="comprar.php">
                                                    <input type="text" class="form-control" name="fechaPago" id="fechaPago" value="<?php echo $fechaPago;?>" hidden>
                                                    <input type="text" class="form-control" name="tipoPago" id="tipoPago" value="<?php echo $tipoPago;?>" hidden>
                                                    <input type="text" name="totalpagar" id="totalpagar" value="<?php echo $totalPagar;?>" hidden>
                                                    <input type="text" name="idventa" id="idventa" value="<?php echo $idventa;?>" hidden>
                                                    <input type="text" name="comprobante" id="comprobante" value="<?php echo $Comprobante;?>" hidden>
                                                        <button type="submit" name="enviar" value="enviar" class="btn btn-success">Aceptar</button>
                                                    </form>
                                                </div>
                                                <div align="center" class="col-md-6" style="padding-top:30px">
                                                    <form method="POST">
                                                        <button type="submit" name="Rechazar" value=<?php echo $fila['idcomprobante']?> class="btn btn-danger">Rechazado</button>
                                                    </form>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                   
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
                <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="listadocomprobante.php?pagina=<?php echo $_GET['pagina'] - 1 ?>&est=<?php echo $_GET['est'];?>">Anterior</a></li>
                <?php for ($i = 1; $i <= $paginas; $i++) : ?>
                    <li class="<?php echo $_GET['pagina'] == $i ? 'active' : '' ?>"><a class="page-link" href="listadocomprobante.php?pagina=<?php echo $i ?>&est=<?php echo $_GET['est'];?>"><?php echo $i ?></a></li>
                <?php endfor ?>
                <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link" href="listadocomprobante.php?pagina=<?php echo $_GET['pagina'] + 1 ?>&est=<?php echo $_GET['est'];?>">Siguiente</a></li>
            </ul>
        </nav>
    </div>

</body>

</html>
