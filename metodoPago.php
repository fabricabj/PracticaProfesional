<?php

    require("header.php");
    require("conexion.php");
    date_default_timezone_set('America/Argentina/Buenos_Aires');
	$fechaActual = date('Y-m-d');
    if(isset($_POST['tarjeta'])){
       $total=$_POST['total'];
       echo '
       <div class="container"  style="padding-top:70px">
            <h1 align="center" style="color:white">Tarjeta de crédito</h1>
                <form action="comprar.php" method="POST" style="background:white;border-radius:30px;padding:20px">
                    <div class="row">
                        <div class="col-md-4 form-group" id="user-group">
                            <label for="user">Dueño/a</label>
                            <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Dueño/a" required>
                        </div>
                        <div class="col-md-4 form-group" id="user-group">
                            <label for="user">Codigo de seguridad</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="ej: 123" onkeyup="this.value=Numeros(this.value)" required>
                        </div>
                        <div class="col-md-4 form-group" id="password-group">
                            <label for="contra">Fecha de vto</label>
                            <input type="date" class="form-control" name="fechaVto" id="fechaVto" required>
                        </div>
                        <div class="col-md-12 form-group" id="password-group">
                            <label for="contra">Nro tarjeta</label>
                            <input type="text" class="form-control" name="nTarjeta" id="nTarjeta" placeholder="0000-0000-0000-0000" onkeyup="this.value=NumerosTar(this.value)" required>
                            <input type="text" class="form-control" name="fechaPago" id="fechaPago" value="'.$fechaActual.'" hidden>
                            <input type="text" class="form-control" name="tipoPago" id="tipoPago" value="1" hidden>
                        </div>
                        
                    </div>
                    <div align="center" class="form-group">
                            <input type="text" name="totalpagar" id="totalpagar" value="'.$total.'" hidden>
                            <button name="aceptar" value="aceptar" type="submit" class="btn btn-dark">Continuar</button>
                    </div>
                </form>
             </div>';
    }else{
        $total=$_POST['total'];
        echo '<div class="container" style="padding-top:70px">
            <h1 align="center" style="color:white">Transferencia bancaria</h1>
                <div align="center" style="background:white;border-radius:30px;padding:20px">
                  <br><br>
                  <h4>Empresa: AFLcinema</h4>
                  <h4>CBU: 1234567890123456789012</h4>
                  <h4>Dirección: Capital federal</h4>
                  <h4>Tipo de cuenta: Cuenta corriente</h4>
                  <h4>Monto a pagar: $'.$total.'</h4>
                  <br><br>
                  <h4>Inserte comprobante de pago</h4>
                  <br>
                  <form action="validarcomprobante.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="imagen">
                    <input type="text" class="form-control" name="fechaPago" id="fechaPago" value="'.$fechaActual.'" hidden>
                    <input type="text" class="form-control" name="tipoPago" id="tipoPago" value="2" hidden>
                    <input type="text" name="totalpagar" id="totalpagar" value="'.$total.'" hidden>
                    <button type="submit" name="enviar" value="enviar" class="btn btn-dark">enviar</button>
                  </form>
              </div>';
    }
    echo "<script>
    function Numeros(string){
        var out = '';
        ok=true;
        var filtro = '1234567890';
        for (var i=0; i<4; i++)
           if (filtro.indexOf(string.charAt(i)) != -1)
             out += string.charAt(i);
        
             return out;
    }   
    </script>"

?>
<script>
function Numeros(string){
    var out = '';
    ok=true;
    var filtro = '1234567890';
    for (var i=0; i<3; i++)
       if (filtro.indexOf(string.charAt(i)) != -1)
         out += string.charAt(i);
    
         return out;
}
function NumerosTar(string){
    var out = '';
    ok=true;
    var filtro = '1234567890';
    for (var i=0; i<16; i++)
        if (filtro.indexOf(string.charAt(i)) != -1)
            out += string.charAt(i);
    
            return out;
}   



</script>