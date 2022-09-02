<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
</head>

<body>
    <?php   
    require("header.php");
    require("conexion.php");
    $grupos=mysqli_query($conexion,"SELECT * FROM grupo");?>
    <div class="container"  style="padding-top:100px;">
    <div style="background:#212121; border-radius:30px;">
        <H1 align="center" class="text-white">Modificar Usuario</H1>
 
       <?php
         if (isset($_POST['idusuario'])) {
                      $idusuario=$_POST['idusuario'];
                      $consulta="SELECT * FROM usuarios WHERE idusuario='$idusuario'";
                      $tipoestado=mysqli_query($conexion,"SELECT idestado FROM usuarios WHERE idusuario='$idusuario'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestado'];
                    
                      }  
                      $resultado=mysqli_query($conexion,$consulta);
                      $datos_generos=mysqli_fetch_assoc($resultado);
                    }
                     
                  ?>

         <form action="abm_usuario.php" method= "POST">
    <div class="px-lg-5 py-lg-4 p-4">
        <div class="form-row">
              <div class="col-6">
                <label class="form-label font-weight-bold text-white">Nombre Usuario</label>
                <input type="text"class="form-control bg-dark-x border-0" placeholder="Nombre Usuario" id="nombre_usuario" name ="nombre_usuario"  value="<?php echo $datos_generos['nombre_usuario'];?>"/>
              </div>

              <div class="col-6">
              <label class="form-label font-weight-bold text-white">Mail</label>
                <input type="text"class="form-control bg-dark-x border-0" placeholder="Mail" id="mail" name ="mail"  value="<?php echo $datos_generos['mail'];?>"/>
              </div>
            
           
              <div class="col-6">
                <label class="form-label font-weight-bold text-white">Estado</label>

								<select name="estado" id="estado" class="form-control" >
									
									<?php $selectEstado=mysqli_query($conexion,"SELECT idestado,descripcion FROM usuario_estados ORDER BY descripcion ASC");
									while($r=mysqli_fetch_array($selectEstado)){?>
										
										<option value="<?php echo $r['idestado'];?>" <?php if($idTipoEstado==$r['idestado']){ echo'selected';}?>><?php echo $r['descripcion'];?></option>
									<?php }?>
								</select>
              </div><br>
              <div class="col-6">
              <label class="form-label font-weight-bold text-white">Estado</label>
              <select name="rol" id="rol" class="form-control" >
                <?php
                  $selectRol=mysqli_query($conexion,"SELECT g.idgrupo, g.nombre_grupo FROM grupo AS g, grupo_usuarios AS gu
                                                      WHERE gu.idusuario=$idusuario
                                                      AND gu.idgrupo=g.idgrupo");
                  while($p=mysqli_fetch_array($selectRol)){
                    $rol=$p['idgrupo'];
                    echo $rol;
                  }
                  while($gp=mysqli_fetch_array($grupos)){?>
                    <option value="<?php echo $gp['idgrupo'];?>" <?php if($rol==$gp['idgrupo']){ echo'selected';}?>><?php echo $gp['nombre_grupo'];?></option>

                <?php  } ?>
                </select>    
                  </div>
                  </div>
             <div class="form-group">
                             <input type="text" name="id" id="id" value="<?php echo $datos_generos['idusuario']; ?>" hidden>
                             <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" value="btnModificar" name="btnModificar"><i class="fas fa-save"></i> Modificar usuario</button>
                             <button style="margin-top: 3%;width: 100%;" class="btn btn-dark"value="Cancelar" name="Cancelar"><i class="fas fa-ban"></i> Cancelar</button>
                         </div>
            
              <!--<button  type="submit" class="btn btn-secondary w-5" name="btnModificar" id="btnModificar" value="btnModificar">Guardar Cambios</button>-->
          </form>       
             </div>
      </div>

    
</body>

</html>

