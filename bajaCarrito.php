<?php
 session_start();
        $arreglo=$_SESSION['carrito'];
   	    for ($i=0; $i<count($arreglo) ; $i++) { 
   	    	if ($arreglo[$i]['Id']!=$_POST['IdPelicula']) {
                $nuevoCarrito[]=array('Id'=>$arreglo[$i]['Id'],
                'Titulo'=>$arreglo[$i]['Titulo'],
                'Precio'=>$arreglo[$i]['Precio']);
   	    	}
        }
        if(isset($nuevoCarrito)){
            $_SESSION['carrito']=$nuevoCarrito;
        }else{
            unset($_SESSION['carrito']);
            echo '0';
        }
?>