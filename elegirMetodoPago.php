<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
</head>

<body>
<?php 
require ("header.php");
require ("conexion.php");
$cont=$_POST['total'];
?>
            <div class="container"  style="padding-top:70px">
                <form action="metodoPago.php" method="POST" style="background:white;border-radius:30px;padding:20px">
                <h2 align="center">Método de pago</h2>
                <br><br>
                <h3 align="center"> Seleccione el método de pago</h3>
                    <div align="center" class="form-group">
                        <div class="row">
                            <div class="col-md-6 form-group" id="password-group">
                                <input type="text" name="total" id="total" value="<?php echo $cont?>" hidden>
                                <button align="center" style="margin-top:7%;width:50%" name="tarjeta" value="tarjeta" type="submit" class="btn btn-dark"><i class='fa fa-credit-card-alt'></i> Tarjeta</button>
                            </div>
                            <div class="col-md-6 form-group" id="password-group">
                                <input type="text" name="total" id="total" value="<?php echo $cont?>" hidden>
                                <button align="center" style="margin-top:7%;width:50%" name="transferencia" value="transferencia" type="submit" class="btn btn-dark"><i class='fa fa-bank'></i> Transferencia</button>
                            </div>
                        </div>
                    </div>  
                </form>
             </div>';
            
</body>
</html>