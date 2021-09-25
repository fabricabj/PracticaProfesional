<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Proveedores</title>
</head>

<body>
    <?php   
    require("header.php");
    require("conexion.php");?>
    <div class="container"  style="padding-top:100px;">
    <div style="background:#212121; border-radius:30px;">
        <H1 align="center" class="text-white">Modificar Proveedores</H1>
 
       <?php
         if (isset($_POST['cuit'])) {
                      $cuit=$_POST['cuit'];
                      $consulta="SELECT * FROM proveedores WHERE cuit='$cuit'";
                      $tipoestado=mysqli_query($conexion,"SELECT idestado FROM proveedores WHERE cuit='$cuit'");
                      while($i=mysqli_fetch_array($tipoestado)){
                          $idTipoEstado=$i['idestado'];
                      }  
                      $resultado=mysqli_query($conexion,$consulta);
                      $datos_generos=mysqli_fetch_assoc($resultado);
                    }
                     
                  ?>
         <form action="abmproveedores.php" method= "POST">
    <div class="px-lg-5 py-lg-4 p-4">
        <div class="form-row">
              <div class="col-6">
                <label class="form-label font-weight-bold text-white">Razón Social</label>
                <input type="text"class="form-control bg-dark-x border-0" placeholder="Razòn Social" id="razon_social" name ="razon_social"  value="<?php echo $datos_generos['razon_social'];?>"/>
                 
                
              </div>
              <div class="col-6">
              <label class="form-label font-weight-bold text-white">Cuit</label>
                <input type="text"class="form-control bg-dark-x border-0" placeholder="Cuit" id="cuit" name ="cuit"  value="<?php echo $datos_generos['cuit'];?>"/>
                 <input type="text"class="form-control bg-dark-x border-0"  id="cuit_anterior" name ="cuit_anterior"  value="<?php echo $datos_generos['cuit'];?>"hidden/>
              </div>
              </div>

              <div class="form-row">
              <div class="col-6">
                <label class="form-label font-weight-bold text-white">Mail</label>
                <input type="email" class="form-control bg-dark-x border-0 mb-2" placeholder="Ingresar Email" id="email" value="<?php echo $datos_generos['mail'];?>" name="email"/>
              </div>
            
              <div class="col-6">
                <label class="form-label font-weight-bold text-white">Estado</label>

								<select name="estado" class="form-control" >
									
									<?php $selectEstado=mysqli_query($conexion,"SELECT idestado,descripcion FROM estados_provedores ORDER BY descripcion ASC");
									while($r=mysqli_fetch_array($selectEstado)){?>
										
										<option value="<?php echo $r['idestado'];?>" <?php if($idTipoEstado==$r['idestado']){ echo'selected';}?>><?php echo $r['descripcion'];?></option>
									<?php }?>
								</select>
              </div><br>
            </div>
              <button type="submit" class="btn btn-secondary w-5" name="btnModificar" id="btnModificar" value="btnModificar">Guardar Cambios</button>
          </form>       
             </div>
      </div>

    
</body>

</html>