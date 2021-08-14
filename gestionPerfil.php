<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perfil de Usuario</title>
</head>

<body>
<?php   
require("header.php");?>
<div class="container"  style="padding-top:100px;">
<div style="background:#212121; border-radius:30px;">
<H1 align="center" class="text-white">Perfil</H1>
<div class="px-lg-5 py-lg-4 p-4">
    <div class="form-row">
        <div class="col-6">
             <label class="form-label font-weight-bold text-white">Nombre</label>
            <input type="text"class="form-control bg-dark-x border-0" placeholder="Nombre" id="nombre" name ="nombre"/>
        </div>

        <div class="col-6">
             <label class="form-label font-weight-bold text-white">Apellido</label>
            <input type="text"class="form-control bg-dark-x border-0" placeholder="Apellido" id="apellido" name ="apellido"/>
        </div>
        <div class="form-group col-md-6">
            <label class="form-label font-weight-bold text-white">Tipo de Documento</label>
                            <select name="tipoDocumento" id="tipoDocumento" class="form-control" >

                                <?php $selectEstado=mysqli_query($conexion,"SELECT nombre_documento FROM documento_tipos ORDER BY idtipodocumento ASC");
                                while($r=mysqli_fetch_array($selectEstado)){?>

                                    <option><?php echo $r['nombre_documento'];?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-6">
             <label class="form-label font-weight-bold text-white">Numero de Documento</label>
            <input type="text"class="form-control bg-dark-x border-0" placeholder="Numero de Documento" id="numDocumento" name ="numDocumento"/>
        </div>
         <div class="form-group col-md-6">
            <label class="form-label font-weight-bold text-white">Sexo</label>
                            <select name="sexo" id="sexo" class="form-control" >

                                <?php $selectEstado=mysqli_query($conexion,"SELECT nombre FROM generos ORDER BY idgenero ASC");
                                while($r=mysqli_fetch_array($selectEstado)){?>

                                    <option><?php echo $r['nombre'];?></option>
                                <?php }?>
                            </select>
                        </div>
                                   <div class="col-6">
             <label class="form-label font-weight-bold text-white">Numero de Telefono</label>
            <input type="text"class="form-control bg-dark-x border-0" placeholder="Numero de Telefono" id="numTelefono" name ="numTelefono"/>
        </div>
         <div class="form-group col-md-6">
            <label class="form-label font-weight-bold text-white">País</label>
                            <select name="pais" id="pais" class="form-control" >

                                <?php $selectEstado=mysqli_query($conexion,"SELECT nombre, idpais FROM paises ORDER BY idpais ASC");
                                while($r=mysqli_fetch_array($selectEstado)){?>

                                    <option><?php echo $r['nombre'];?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
            <label class="form-label font-weight-bold text-white">Provincia</label>
                            <select name="provincia" id="provincia" class="form-control" >
                                <?php $selectEstado=mysqli_query($conexion,"SELECT p.nombre_provincia FROM provincias AS p, paises AS pa where p.idpais = pa.idpais ORDER BY idpais ASC");
                                while($r=mysqli_fetch_array($selectEstado)){?>

                                    <option><?php echo $r['nombre_provincia'];?></option>
                                <?php }?>
                            </select>
                        </div>
        </div>
    </div>

</div>


</div>
 </div>
<!-- <button type="submit" class="btn btn-secondary w-5" onclick="validarCuit()">Guardar Cambios</button>
            <div id="result"></div> -->
                                </body>
                                </html>