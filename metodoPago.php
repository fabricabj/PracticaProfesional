<?php

    require("header.php");
    require("conexion.php");
    date_default_timezone_set('America/Argentina/Buenos_Aires');
	$fechaActual = date('Y-m-d');
    if(isset($_POST['tarjeta'])){
       $total=$_POST['total'];
       echo '<div class="container"  style="padding-top:70px">
                <form action="comprar.php" method="POST" style="background:white;border-radius:30px;padding:20px">
                    <div class="row">
                        <div class="col-md-4 form-group" id="user-group">
                            <label for="user">Dueño/a</label>
                            <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Dueño/a" require>
                        </div>
                        <div class="col-md-4 form-group" id="user-group">
                            <label for="user">Codigo de seguridad</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="ej: 123" require>
                        </div>
                        <div class="col-md-4 form-group" id="password-group">
                            <label for="contra">Fecha de vto</label>
                            <input type="date" class="form-control" name="fechaVto" id="fechaVto" require>
                        </div>
                        <div class="col-md-12 form-group" id="password-group">
                            <label for="contra">Nro tarjeta</label>
                            <input type="text" class="form-control" name="nTarjeta" id="nTarjeta" require>
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
                <div align="center" style="background:white;border-radius:30px;padding:20px">
                  <h3> Transferencia bancaria</h3>
                  <br><br>
                  <h4>Empresa: AFLcinema</h4>
                  <h4>CBU: 1234567890123456789012</h4>
                  <h4>Direccion: Capital federal</h4>
                  <h4>Tipo de cuenta: Cuenta corriente</h4>
                  <h4>Monto a pagar: $'.$total.'</h4>
                  <br><br>
                  <h4>Inserte comprobante de pago</h4>
                  <br>
                  <input type="file" name="imagen">
                  <input type="button name="enviar" value="enviar" class="btn btn-dark">
              </div>';
    }

?>