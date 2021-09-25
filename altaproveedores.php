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
        
    
    <div class="px-lg-5 py-lg-4 p-4">
        <div class="form-row">
              <div class="col-6">
                <label class="form-label font-weight-bold text-white">Razón Social</label>
                <input type="text"class="form-control bg-dark-x border-0" placeholder="Razón Social" id="razon_social" name ="razon_social"/>
                
              </div>
              <div class="col-6">
              <label class="form-label font-weight-bold text-white">Cuit</label>
                <input type="text"class="form-control bg-dark-x border-0" placeholder="Cuit" id="cuit" name ="cuit">
                <input type="text"class="form-control bg-dark-x border-0" id="btnGuardar" name ="btnGuardar" value="btnGuardar" hidden>
              </div>
              </div>

              <div class="form-row">
              <div class="col-6">
                <label class="form-label font-weight-bold text-white">Mail</label>
                <input type="email" class="form-control bg-dark-x border-0 mb-2" placeholder="Ingresar Mail" id="email" name="email"/>
              </div><br>
              <div class="form-group col-md-6">
              <label class="form-label font-weight-bold text-white">Estado</label>
                                <select name="estado" id="estado" class="form-control" >

                                    <?php $selectEstado=mysqli_query($conexion,"SELECT descripcion FROM estados_provedores ORDER BY descripcion ASC");
                                    while($r=mysqli_fetch_array($selectEstado)){?>

                                        <option><?php echo $r['descripcion'];?></option>
                                    <?php }?>
                                </select>
                            </div>
            </div>
            
              <button type="submit" class="btn btn-secondary w-5" onclick="validarCuit()">Guardar Cambios</button>
              <div id="result"></div>          
      </div> 
             </div>
      </div>
      <script type="text/javascript">

  function validarCuit(cuit) 
    {
    var vec = new Array(10);
    var cuit = document.getElementById('cuit').value;
    esCuit=false;
    cuit_rearmado="";
    errors = ''
    for (i=0; i < cuit.length; i++)
    {   
        caracter=cuit.charAt( i);
        if ( caracter.charCodeAt(0) >= 48 && caracter.charCodeAt(0) <= 57 )
        {
            cuit_rearmado +=caracter;
        }
    }
    cuit=cuit_rearmado;
    if ( cuit.length != 11) {  // si no estan todos los digitos
        esCuit=false;
        errors = 'Cuit < 11 ';
        alert( "CUIT Menor a 11 Caracteres" );
    } else {
        x=i=dv=0;
        // Multiplico los dígitos.
        vec[0] = cuit.charAt(  0) * 5;
        vec[1] = cuit.charAt(  1) * 4;
        vec[2] = cuit.charAt(  2) * 3;
        vec[3] = cuit.charAt(  3) * 2;
        vec[4] = cuit.charAt(  4) * 7;
        vec[5] = cuit.charAt(  5) * 6;
        vec[6] = cuit.charAt(  6) * 5;
        vec[7] = cuit.charAt(  7) * 4;
        vec[8] = cuit.charAt(  8) * 3;
        vec[9] = cuit.charAt(  9) * 2;
                    
        // Suma cada uno de los resultado.
        for( i = 0;i<=9; i++) 
        {
            x += vec[i];
        }
        dv = (11 - (x % 11)) % 11;
        if ( dv == cuit.charAt( 10) )
        {
            esCuit=true;
        }
    }
    if ( !esCuit ) 
    {
        alert( "CUIT Invalido" );
        document.form.cuit.focus();
        errors = 'Cuit Invalido ';
    }else{
      $.ajax({
            url: 'abmproveedores.php',
            type: 'POST',
            data: { 
                razon: document.getElementById('razon_social').value,
                cuit: document.getElementById('cuit').value,
                email: document.getElementById('email').value,
                estado: document.getElementById('estado').value,
                btnGuardar: document.getElementById('btnGuardar').value,
              
            },
         })
         .done(function(response){
            $("#result").html(response);
         })
         .fail(function(jqXHR){
            console.log(jqXHR.statusText);
         });
         
    }
    document.MM_returnValue1 = (errors == '');
    }
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

