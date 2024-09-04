<?php 
include 'utilidades_texto.php';

$frases= [['hola mundo'], ['este parcial esta dificil'],['me gustan los kiwis']]; 

for ($i = 0; $i < count($frases); $i++) {
    echo contar_palabras($frases);
    echo contar_vocales($frases);
    echo invertir_palabras($frases);
       }

?>