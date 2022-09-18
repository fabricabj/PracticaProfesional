
<?php 
      require("header.php");
      require("conexion.php");
?>
<div class="container">
        <div class="row">
              <div class="col-md-12" style="padding-top:60px;">
                   <form action="permisos.php" method="post" class="permisos">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Crear Grupo</label>
                                <input type="text" name="nombreGrupo">
                                <a style="float:right;width:15%" href="listarPermisos.php" class="btn botonpermisos">Listar</a>
                            </div>
                            <div class="col-md-12" style="padding-top:30px;">
                                <?php   
                                    $agrupamiento=mysqli_query($conexion,"SELECT idagrupamiento, nombre FROM permisos_gestiones ORDER BY nombre");
                                    while($PermisosGestiones=mysqli_fetch_array($agrupamiento)){
                                ?>
                            </div>
                            <div class="col-md-6 gestiones">
                                    <p><?php echo $PermisosGestiones['nombre']?></p>
                                    <?php   
                                            $permisos=mysqli_query($conexion,"SELECT pu.idpermiso, pu.nombre_permiso FROM permisos_gestiones AS pg, agrupamientos_permisos AS ap,permisos_usuarios AS pu
                                                                            WHERE pg.idagrupamiento = ap.idagrupamiento
                                                                            AND ap.idpermiso=pu.idpermiso
                                                                            AND pg.idagrupamiento=" . $PermisosGestiones['idagrupamiento']);
                                                                            
                                            while($r=mysqli_fetch_array($permisos)){?>
                                                <input type="checkbox" name="nombrePermiso[]" value="<?php echo $r['nombre_permiso']?>"><?php echo $r['nombre_permiso']?><br>
                                   <?php    }
                                    }      
                                   ?>
                            </div>
                            <div class="col-md-12" align="center" style="padding-top:30px">
                                <button type="submit" class="btn botonpermisos"  name="alta" value="alta">Asignar</button>
                            </div>
                        </div>
                   </form>
             </div>
        </div>
 </div>
 <?php if(isset($_GET['estado']) && $_GET['estado']==1){
           echo "<script>alert('grupo creado con exito')</script>";
       }
 ?>
