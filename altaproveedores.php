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
    require("header.php");?>
    <div class="container">
        <H1 class="text-white">Proveedores Alta</H1>
         <form action="abmproveedores.php" method= "POST">
    <div class="px-lg-5 py-lg-4 p-4">
        <div class="form-row">
              <div class="col-3">
                <label class="form-label font-weight-bold text-white">Razòn Social</label>
                <input type="text"class="form-control bg-dark-x border-0" placeholder="Razòn Social" id="razon_social" name ="razon_social"/>
                
              </div>
              <div class="col-3">
              <label class="form-label font-weight-bold text-white">Cuit</label>
                <input type="text"class="form-control bg-dark-x border-0" placeholder="Cuit" id="cuit" name ="cuit"/>
              </div>
              </div>

              <div class="form-row">
              <div class="col-3">
                <label class="form-label font-weight-bold text-white">Email</label>
                <input type="email" class="form-control bg-dark-x border-0 mb-2" placeholder="Ingresar Email" id="email" name="email"/>
              </div><br>
              <div class="form-group col-md-4">
              <label class="form-label font-weight-bold text-white">estado</label>
                                <select name="estado" class="form-control" >

                                    <?php $selectEstado=mysqli_query($conexion,"SELECT descripcion FROM estados_provedores ORDER BY descripcion ASC");
                                    while($r=mysqli_fetch_array($selectEstado)){?>

                                        <option><?php echo $r['descripcion'];?></option>
                                    <?php }?>
                                </select>
                            </div>
            </div>
              <button type="submit" class="btn btn-primary w-5" name="btnGuardar" id="btnGuardar" value="btnGuardar">Guardar Cambios</button>
          </form>       
             </div>
      </div>

    
</body>

</html>




