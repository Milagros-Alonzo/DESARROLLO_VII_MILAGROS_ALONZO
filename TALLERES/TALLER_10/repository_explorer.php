<?php
require_once 'config.php';
require_once 'RepositoryManager.php';

$repoManager = new RepositoryManager($github);

// Obtener usuario de la URL o usar uno por defecto
$username = $_GET['username'] ?? 'github';

try {
    $repositories = $repoManager->getUserRepositories($username);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Explorador de Repositorios</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .repository { border: 1px solid #ddd; margin: 10px 0; padding: 15px; }
        .repository h3 { margin-top: 0; }
        .stats { display: flex; gap: 20px; }
        .stats span { background: #f0f0f0; padding: 5px 10px; border-radius: 3px; }
        .search { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Repositorios Públicos de <?= htmlspecialchars($username) ?></h1>
        
        <div class="search">
            <form method="GET">
                <input type="text" name="username" placeholder="Nombre de usuario" 
                       value="<?= htmlspecialchars($username) ?>">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <div class="repositories">
            <?php foreach ($repositories as $repo): ?>
                <div class="repository">
                    <h3>
                        <a href="<?= htmlspecialchars($repo['html_url']) ?>" target="_blank">
                            <?= htmlspecialchars($repo['name']) ?>
                        </a>
                    </h3>
                    
                    <p><?= htmlspecialchars($repo['description'] ?? 'Sin descripción') ?></p>
                    
                    <div class="stats">
                        <span>⭐ <?= $repo['stargazers_count'] ?></span>
                        <span>🍴 <?= $repo['forks_count'] ?></span>
                        <span>👀 <?= $repo['watchers_count'] ?></span>
                        <span>📅 <?= date('Y-m-d', strtotime($repo['created_at'])) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>