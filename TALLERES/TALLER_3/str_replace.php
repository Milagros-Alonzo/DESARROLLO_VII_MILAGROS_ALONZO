
<?php
// Ejemplo de uso de str_replace()
$frase = "El gato negro saltó sobre el perro negro";
$fraseModificada = str_replace("negro", "blanco", $frase);

echo "Frase original: $frase
";
echo "Frase modificada: $fraseModificada
";

// Ejercicio: Crea una variable con una frase que contenga al menos tres veces la palabra "PHP"
// y usa str_replace() para cambiar "PHP" por "JavaScript"
$miFrase = "El lengauje PHP es dificil para agunas personas pero PHP es buscado por muchos trabajos lo que hacer que PHP sea importante"; // Reemplaza esto con tu frase
$miFraseModificada = str_replace("PHP", "JavaScript", $miFrase);

echo "
Mi frase original: $miFrase
";
echo "Mi frase modificada: $miFraseModificada
";

// Bonus: Usa str_replace() para reemplazar múltiples palabras a la vez
$texto = "Manzanas y naranjas son frutas. Me gustan las manzanas y las naranjas.";
$buscar = ["Manzanas", "naranjas"];
$reemplazar = ["Peras", "uvas"];
$textoModificado = str_replace($buscar, $reemplazar, $texto);

echo "
Texto original: $texto
";
echo "Texto modificado: $textoModificado
";
?>
          
