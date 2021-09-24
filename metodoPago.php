<?php

    require("header.php");
    require("conexion.php");

    if(isset($_POST['tarjeta'])){
       echo '<div class="container" align="center" style="background:white;padding-top:70px">
                <form action="comprar.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 form-group" id="user-group">
                            <label for="user">Dueño/a</label>
                            <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Dueño/a" require>
                        </div>
                        <div class="col-md-6 form-group" id="password-group">
                            <label for="contra">Fecha de pago</label>
                            <input type="date" class="form-control" name="fechaPago" id="fechaPago" require>
                        </div>
                        <div class="col-md-12 form-group" id="password-group">
                            <label for="contra">Nro tarjeta</label>
                            <input type="text" class="form-control" name="nTarjeta" id="nTarjeta" require>
                        </div>
                        <div class="col-md-6 form-group" id="user-group">
                            <label for="user">Codigo de seguridad</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="ej: 123" require>
                        </div>
                        <div class="col-md-6 form-group" id="password-group">
                            <label for="contra">Fecha de vto</label>
                            <input type="date" class="form-control" name="fechaVto" id="fechaVto" require>
                        </div>
                    </div>
                    <div align="center" class="form-group">
                            <button name="aceptar" value="aceptar" type="submit" class="btn btn-light">Continuar</button>
                    </div>
                </form>
             </div>';
    }else{
        echo "transferencia";
    }

?>