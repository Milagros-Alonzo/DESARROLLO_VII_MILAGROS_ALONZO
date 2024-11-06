
<?php
require_once 'validaciones.php';
require_once 'sanitizacion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errores = [];
    $datos = [];

  // Procesar y validar cada campo
$campos = ['nombre', 'email', 'sitio_web', 'genero', 'intereses', 'comentarios'];
foreach ($campos as $campo) {
    if (isset($_POST[$campo])) {
        $valor = $_POST[$campo];

        // Manejamos el campo 'sitio_web' específicamente para que coincida con el nombre correcto de la función
        if ($campo === 'sitio_web') {
            $valorSanitizado = sanitizarSitioWeb($valor);
        } else {
            $valorSanitizado = call_user_func("sanitizar" . ucfirst($campo), $valor);
        }

        $datos[$campo] = $valorSanitizado;

        // Valida de manera similar
        if ($campo === 'sitio_web') {
            if (!validarSitioWeb($valorSanitizado)) {
                $errores[] = "El campo $campo no es válido.";
            }
        } else {
            if (!call_user_func("validar" . ucfirst($campo), $valorSanitizado)) {
                $errores[] = "El campo $campo no es válido.";
            }
        }
    }
}

     

    // Procesar la foto de perfil
    if (!validarFotoPerfil($_FILES['foto_perfil'])) {
        $errores[] = "La foto de perfil no es válida.";
    } else {
        $extension = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $nombreUnico = uniqid('perfil_', true) . '.' . $extension;
        $rutaDestino = 'uploads/' . $nombreUnico;
        
        if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
            $datos['foto_perfil'] = $rutaDestino;
        } else {
            $errores[] = "Hubo un error al subir la foto de perfil.";
        }
    }
    
//Calculamos fecha de nacimiento
    if (isset($datos['fecha_nacimiento'])) {
    $fechaNacimiento = new DateTime($datos['fecha_nacimiento']);
    $fechaActual = new DateTime();
    $edad = $fechaActual->diff($fechaNacimiento)->y;
    $datos['edad'] = $edad; // Guardamos la edad en el array de datos
}
    

    // Mostrar resultados o errores
   // if (empty($errores)) {
     //   echo "<h2>Datos Recibidos:</h2>";
       // foreach ($datos as $campo => $valor) {
         //   if ($campo === 'intereses') {
        //        echo "$campo: " . implode(", ", $valor) . "<br>";
        //    } elseif ($campo === 'foto_perfil') {
          //      echo "$campo: <img src='$valor' width='100'><br>";
        //    } else {
             //   echo "$campo: $valor<br>";
          //  }
      //  }
   // } else {
      //  echo "<h2>Errores:</h2>";
      //  foreach ($errores as $error) {
           // echo "$error<br>";
       // }
   // }
//} else {
   // echo "Acceso no permitido.";
//}
// Modificar la sección de mostrar resultados
if (empty($errores)) {
    echo "<h2>Datos Recibidos:</h2>";
    echo "<table border='1'>";
    foreach ($datos as $campo => $valor) {
        echo "<tr>";
        echo "<th>" . ucfirst($campo) . "</th>";
        if ($campo === 'intereses') {
            echo "<td>" . implode(", ", $valor) . "</td>";
        } elseif ($campo === 'foto_perfil') {
            echo "<td><img src='$valor' width='100'></td>";
        } else {
            echo "<td>$valor</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<h2>Errores:</h2>";
    echo "<ul>";
    foreach ($errores as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
}
}

//guardar en archivos json
if (empty($errores)) {
    $archivoJson = 'registros.json';
    $registros = file_exists($archivoJson) ? json_decode(file_get_contents($archivoJson), true) : [];
    
    $registros[] = $datos;
    file_put_contents($archivoJson, json_encode($registros, JSON_PRETTY_PRINT));
}

echo "<br><a href='formulario.html'>Volver al formulario</a>";
?>

        