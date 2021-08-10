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
    <div class="container"  style="padding-top:100px;">
    <div style="background:#212121; border-radius:30px;">
        <H1 align="center" class="text-white">Proveedores Alta</H1>
        
         <form action="abmproveedores.php" method= "POST">
    <div class="px-lg-5 py-lg-4 p-4">
        <div class="form-row">
              <div class="col-6">
                <label class="form-label font-weight-bold text-white">Razòn Social</label>
                <input type="text"class="form-control bg-dark-x border-0" placeholder="Razòn Social" id="razon_social" name ="razon_social"/>
                
              </div>
              <div class="col-6">
              <label class="form-label font-weight-bold text-white">Cuit</label>
                <input type="text"class="form-control bg-dark-x border-0" placeholder="Cuit" id="cuit" name ="cuit" onkeyup="isValid(this.value);">
                
              </div>
              </div>

              <div class="form-row">
              <div class="col-6">
                <label class="form-label font-weight-bold text-white">Email</label>
                <input type="email" class="form-control bg-dark-x border-0 mb-2" placeholder="Ingresar Email" id="email" name="email"/>
              </div><br>
              <div class="form-group col-md-6">
              <label class="form-label font-weight-bold text-white">estado</label>
                                <select name="estado" class="form-control" >

                                    <?php $selectEstado=mysqli_query($conexion,"SELECT descripcion FROM estados_provedores ORDER BY descripcion ASC");
                                    while($r=mysqli_fetch_array($selectEstado)){?>

                                        <option><?php echo $r['descripcion'];?></option>
                                    <?php }?>
                                </select>
                            </div>
            </div>
            
              <button type="submit" class="btn btn-secondary w-5" name="btnGuardar" onclick="esCUITValida(cuit)" id="btnGuardar" value="btnGuardar" >Guardar Cambios</button>
          </form>      
      </div> 
             </div>
      </div>
      
            <script>
                function isValid($cuit) {
		$digits = array();
		if (strlen($cuit) != 13) return false;
		for ($i = 0; $i < strlen($cuit); $i++) {
			if ($i == 2 or $i == 11) {
				if ($cuit[$i] != '-') return false;
			} else {
				if (!ctype_digit($cuit[$i])) return false;
				if ($i < 12) {
					$digits[] = $cuit[$i];
				}
			}
		}
		$acum = 0;
		foreach (array(5, 4, 3, 2, 7, 6, 5, 4, 3, 2) as $i => $multiplicador) {
			$acum += $digits[$i] * $multiplicador;
		}
		$cmp = 11 - ($acum % 11);
		if ($cmp == 11) $cmp = 0;
		if ($cmp == 10) $cmp = 9;
		return ($cuit[12] == $cmp);
	
    </script>

    
</body>

</html>

<?php
function is_valid_email($str)
{
  $matches = null;
  return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $str, $matches));
}
?>

