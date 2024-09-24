<?php
function contar_palabras($texto){
    $texto = trim($texto);

    if($texto == ""){
        return "0 <br>";
    }

    $cantidad = 1;
    for( $i = 0; $i < strlen($texto); $i++ ) {
        
        if( $texto[ $i ] == ' '){
            $cantidad++;
        }
        if( $texto[ $i-1 ] == ' ' && $texto[ $i ] == ' ')  {
            $cantidad--;
        }
    }
    return "$cantidad <br>";
}

function contar_vocales($texto){
    $texto = strtolower($texto);
    $cant=0;
    for ($i=0;$i<strlen(string: $texto); $i++ ){
        if ($texto[$i]== 'a'){
            $cant++;
        }
        if ($texto[$i]== 'e'){
            $cant++;
        }
        if ($texto[$i]== 'i'){
            $cant++;
        }
        if ($texto[$i]== 'o'){
            $cant++;
        }
        if ($texto[$i]== 'u'){
            $cant++;
        } 
}
return " $cant <br>";
}


function invertir_palabras($texto){
    $cadenaREv = "";
    for ( $i = strlen($texto) - 1; $i > 0; $i-- ){
        $cadenaREv .= $texto[$i];
    }

    return "$cadenaREv <br>";
}


//contar_palabras(" hoals como estas pepe   mi amor");
//contar_vocales("hay 4 vocales");
//invertir_palabras(" me gustas mucho mi amor");
?>