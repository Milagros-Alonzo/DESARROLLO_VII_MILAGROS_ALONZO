<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

if ($_SESSION['role'] === 'profesor') {
    header('Location: pantallas/profesorDashboard.php');
} elseif ($_SESSION['role'] === 'estudiante') {
    header('Location: pantallas/estudianteDashboard.php');
}
exit();
?>