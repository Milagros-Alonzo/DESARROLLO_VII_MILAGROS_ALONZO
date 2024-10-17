<?php
require_once 'config.php';
require_once 'libros.php';
require_once 'usuarios.php';
require_once 'prestamos.php';

// Manejar la solicitud de la página (acciones como listar, añadir, buscar, etc.)
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

if ($accion == 'listar_libros') {
    echo "<h2>Lista de Libros</h2>";
    listarLibros($pdo);
} elseif ($accion == 'listar_usuarios') {
    echo "<h2>Lista de Usuarios</h2>";
    listarUsuarios($pdo);
} elseif ($accion == 'registrar_libro') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Capturar datos del formulario y añadir libro
        añadirLibro($pdo, $_POST['titulo'], $_POST['autor'], $_POST['isbn'], $_POST['anio'], $_POST['cantidad']);
        echo "Libro registrado con éxito.";
    }
?>
    <h2>Registrar un Nuevo Libro</h2>
    <form method="POST" action="index.php?accion=registrar_libro">
        Título: <input type="text" name="titulo" required><br>
        Autor: <input type="text" name="autor" required><br>
        ISBN: <input type="text" name="isbn" required><br>
        Año: <input type="number" name="anio" required><br>
        Cantidad: <input type="number" name="cantidad" required><br>
        <input type="submit" value="Registrar">
    </form>
<?php
} elseif ($accion == 'registrar_usuario') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Capturar datos del formulario y registrar usuario
        registrarUsuario($pdo, $_POST['nombre'], $_POST['email'], $_POST['password']);
        echo "Usuario registrado con éxito.";
    }
?>
    <h2>Registrar un Nuevo Usuario</h2>
    <form method="POST" action="index.php?accion=registrar_usuario">
        Nombre: <input type="text" name="nombre" required><br>
        Email: <input type="email" name="email" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <input type="submit" value="Registrar">
    </form>
<?php
} else {
    // Página de inicio con enlaces a las acciones
    echo "<h1>Sistema de Gestión de Biblioteca</h1>";
    echo '<a href="index.php?accion=listar_libros">Listar Libros</a><br>';
    echo '<a href="index.php?accion=registrar_libro">Registrar Nuevo Libro</a><br>';
    echo '<a href="index.php?accion=listar_usuarios">Listar Usuarios</a><br>';
    echo '<a href="index.php?accion=registrar_usuario">Registrar Nuevo Usuario</a><br>';
}
?>
