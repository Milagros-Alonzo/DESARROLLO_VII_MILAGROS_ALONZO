<?php 
$producto_precio =[
    'camisa' => 50, 'pantalon' => 70, 'zapatos' => 80, 'calcetines' => 10, 'gorra' => 25];
 $carrito = [ 
        'camisa' => 2, 
        'pantalon' => 1, 
        'zapatos' => 1, 
        'calcetines' => 3, 
        'gorra' => 0 
        ]; 
$infoCompleta = array_merge($producto_precio, $carrito);

     ?>