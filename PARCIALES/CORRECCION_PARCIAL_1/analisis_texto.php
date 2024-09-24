<?php 
include_once 'utilidades_texto.php';

$frases= [['  hola mundo pepe  '], ['este parcial esta dificil'],['me gustan los kiwis']]; 

for ($i = 0; $i < count($frases); $i++) {
    echo contar_palabras($frases[$i][0]);
    echo contar_vocales($frases[$i][0]);
    echo invertir_palabras($frases[$i][0]);
    echo "<br>";
    echo "<br>";
    echo "<br>";
}

?>