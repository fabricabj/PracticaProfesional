<?php 
require("header.php");
$select3=mysqli_query($conexion,"SELECT idpais,nombre FROM paises ORDER BY nombre ASC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perfil de Usuario</title>
</head>

<body>
<script language="javascript">
 	$(document).ready(function(){
 		$("#cbxpais").change(function () {	
 			$("#cbxpais option:selected").each(function () {
                 id= $(this).val();
 				 $.post("includes/obtenerProvincias.php", { id: id }, function(data){
 					$("#cbxprovincia").html(data);
 				});             
 			});
 		});
     $("#cbxprovincia").change(function () {	
 			$("#cbxprovincia option:selected").each(function () {
 				id_ciudad = $(this).val();
 				 $.post("includes/obtenerCiudad.php", { id_ciudad: id_ciudad }, function(data){
 					$("#cbxciudad").html(data);
 				});           
 			});
 		});
 	});
 	
	
	
 </script>
<form action="abm_gestionPerfil.php" method ="POST" style="width:95%;">
<div class="container"  style="padding-top:100px;">
<div style="background:#212121; border-radius:30px;">
<H1 align="center" class="text-white">Perfil</H1>
<div class="px-lg-5 py-lg-4 p-4">
    <div class="form-row">
        <div class="col-6">
             <label class="form-label font-weight-bold text-white">Nombre</label>
            <input type="text"class="form-control bg-dark-x border-0" placeholder="Nombre" id="nombre_usuario" name ="nombre_usuario"/>
        </div>

        <div class="col-6">
             <label class="form-label font-weight-bold text-white">Apellido</label>
            <input type="text"class="form-control bg-dark-x border-0" placeholder="Apellido" id="apellido" name ="apellido"/>
        </div>
        <div class="form-group col-md-6">
            <label class="form-label font-weight-bold text-white">Tipo de Documento</label>
                            <select name="idtipodocumento" id="idtipodocumento" class="form-control" >
                            <option>Seleccione Tipo documentacion</option>

                                <?php $selectEstado=mysqli_query($conexion,"SELECT nombre_documento FROM documento_tipos ORDER BY idtipodocumento ASC");
                                while($r=mysqli_fetch_array($selectEstado)){?>

                                    <option><?php echo $r['nombre_documento'];?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-6">
             <label class="form-label font-weight-bold text-white">Numero de Documento</label>
            <input type="text"class="form-control bg-dark-x border-0" placeholder="Numero de Documento" id="numero_documento" name ="numero_documento"/>
        </div>
         <div class="form-group col-md-6">
            <label class="form-label font-weight-bold text-white">Sexo</label>
                            <select name="sexo" id="sexo" class="form-control" >
                            <option>Seleccione Sexo</option>

                                <?php $selectEstado=mysqli_query($conexion,"SELECT nombre FROM generos ORDER BY idgenero ASC");
                                
                                while($r=mysqli_fetch_array($selectEstado)){?>

                                    <option><?php echo $r['nombre'];?></option>
                                <?php }?>
                            </select>
                        </div>
                                   <div class="col-6">
             <label class="form-label font-weight-bold text-white">Numero de Telefono</label>
            <input type="text"class="form-control bg-dark-x border-0" placeholder="Numero de Telefono" id="telefono" name ="telefono"/>
        </div>
         <div class="form-group col-md-4">
         <label class="form-label font-weight-bold text-white">Pais</label>
                                <select class="form-control" id="cbxpais" name="cbxpais">
               	                  <option>Seleccione Pais</option>
                                  <?php while ($rsTP = $select3->fetch_assoc()){?>
                                     <option><?php echo $rsTP['nombre'];?></option>
                                  <?php } ?>
                                </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label font-weight-bold text-white">Provincia</label>
                            <select name="cbxprovincia" id="cbxprovincia" class="form-control" >
                                 <option>seleccione provincia</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label font-weight-bold text-white">Ciudad</label>
                            <select name="cbxciudad" id="cbxciudad" class="form-control" >
                                 <option>seleccione Ciudad</option>
                            </select>
                        </div>
                        <div>
                            <button  class="btn btn-dark" style="margin-top: 3%;width: 100%;" value="guardarPerfil" name="guardarPerfil"><i class="fas fa-save"></i> Guardar Usuario</button>
                        </div>
        </div>
    </div>

</div>


</div>
 </div>
                                  </form>
</body>
</html>