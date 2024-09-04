<?php 
function calcular_descuento($total_compra){
if ($total_compra < 100) {  
} elseif ($total_compra >= 100 <=500 ) { 
               $descuento = $total_compra-($total_compra+.05);
               $subtotal = $total_compra-$descuento;
               retur($subtotal);
} elseif ($total_compra >500 <= 1000) {
    $descuento = $total_compra-($total_compra+.10);
    $subtotal = $total_compra-$descuento;
    retur($subtotal);
} elseif ($total_compra > 1000) {
    $descuento = $total_compra-($total_compra+.15);
    $subtotal = $total_compra-$descuento;
    retur($subtotal) }
} 


function aplicar_impuesto($subtotal){
$impuesto= $subtotal-($subtotal+.07);
}



function calcular_total($subtotal, $descuento, $impuesto){
    $total= $subtotal+$impuesto+$descuento;
}
?>