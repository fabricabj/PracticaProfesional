<?php
require("conexion.php");
require("header.php");
if(isset($_POST['modificar']) && !empty($_POST['modificar'])){
   $idgrupo=$_POST['idgrupo'];
   $select=mysqli_query($conexion,"SELECT idgrupo,nombre_grupo FROM grupo WHERE idgrupo=$idgrupo");
   while($r=mysqli_fetch_array($select)){
       $idgrupo=$r['idgrupo'];
       $grupo = $r['nombre_grupo'];
   }
   echo '<div class="container">
   <div class="row">
         <div class="col-md-12" style="padding-top:60px;">
              <form action="permisos.php" method="post" class="permisos">
                   <div class="row">
                       <div class="col-md-12">
                           <label>Crear grupo</label>
                           <input type="text" name="nombreGrupo" value='.$grupo.'>
                           <input type="text" name="idgrupo" value='.$idgrupo.' hidden>
                           <a style="float:right;width:15%" href="listarPermisos.php" class="btn botonpermisos">Listar</a>
                       </div>
                       <div class="col-md-12" style="padding-top:30px;">';
                            $agrupamiento=mysqli_query($conexion,"SELECT idagrupamiento, nombre FROM permisos_gestiones ORDER BY nombre");
                            
                        
                            while($PermisosGestiones=mysqli_fetch_array($agrupamiento)){
                              
                 echo '</div>
                       <div class="col-md-6 gestiones">
                          <p>'.$PermisosGestiones["nombre"].'</p>';   
                               $permisos=mysqli_query($conexion,"SELECT pu.idpermiso, pu.nombre_permiso FROM permisos_gestiones AS pg, agrupamientos_permisos AS ap,permisos_usuarios AS pu
                                                                 WHERE pg.idagrupamiento = ap.idagrupamiento
                                                                   AND ap.idpermiso=pu.idpermiso
                                                                   AND pg.idagrupamiento=" . $PermisosGestiones['idagrupamiento']);

                               
                                                         
                               while($r=mysqli_fetch_array($permisos)){
                                $permisoschek=mysqli_query($conexion,"SELECT pu.nombre_permiso FROM grupos_permisos AS gp, permisos_usuarios AS pu 
                                WHERE gp.idpermiso=pu.idpermiso
                                  AND gp.idgrupo=$idgrupo");
                                  echo '<input type="checkbox" name="idPermiso[]" value="'.$r["idpermiso"].'"';
                                  while($rs=mysqli_fetch_array($permisoschek)){$perm=$rs['nombre_permiso'];
                                     
                                       if($r['nombre_permiso']==$perm){ echo 'checked'; }
                                  }
                                  echo '>'.$r["nombre_permiso"].'<br>';
                               }
                            
                            }      
                 echo '</div>
                       <div class="col-md-12" align="center" style="padding-top:30px">
                            <button type="submit" class="btn botonpermisos"  name="modificar" value="modificar">Modificar</button>
                       </div>
                   </div>
            </form>    
   </div>
</div>';
}

?>