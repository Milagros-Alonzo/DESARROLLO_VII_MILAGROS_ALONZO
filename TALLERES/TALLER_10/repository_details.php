<?php
require_once 'config.php';
require_once 'RepositoryManager.php';

$repoManager = new RepositoryManager($github);

$owner = $_GET['owner'] ?? '';
$repo = $_GET['repo'] ?? '';

if (!$owner || !$repo) {
    die('Se requieren los parámetros owner y repo');
}

try {
    $info = $repoManager->getRepositoryInfo($owner, $repo);
    $languages = $repoManager->getRepositoryLanguages($owner, $repo);
    $contributors = $repoManager->getRepositoryContributors($owner, $repo);
    $stats = $repoManager->getRepositoryStats($owner, $repo);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($repo) ?> - Detalles</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .section { margin-bottom: 30px; }
        .languages { display: flex; gap: 10px; flex-wrap: wrap; }
        .language { background: #f0f0f0; padding: 5px 10px; border-radius: 3px; }
        .contributors { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
        .contributor { text-align: center; }
        .contributor img { width: 100px; height: 100px; border-radius: 50%; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($info['full_name']) ?></h1>
        
        <div class="section">
            <h2>Información General</h2>
            <p><?= htmlspecialchars($info['description'] ?? 'Sin descripción') ?></p>
            <p>Creado: <?= date('Y-m-d', strtotime($info['created_at'])) ?></p>
            <p>Última actualización: <?= date('Y-m-d', strtotime($info['updated_at'])) ?></p>
        </div>
        
        <div class="section">
            <h2>Estadísticas</h2>
            <p>⭐ Estrellas: <?= $stats['stars'] ?></p>
            <p>🍴 Forks: <?= $stats['forks'] ?></p>
            <p>👀 Observadores: <?= $stats['watchers'] ?></p>
            <p>❗ Issues abiertas: <?= $stats['open_issues'] ?></p>
        </div>
        
        <div class="section">
            <h2>Lenguajes</h2>
            <div class="languages">
                <?php foreach ($languages as $language => $bytes): ?>
                    <span class="language">
                        <?= htmlspecialchars($language) ?>: <?= number_format($bytes) ?> bytes
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="section">
            <h2>Principales Contribuidores</h2>
            <div class="contributors">
                <?php foreach (array_slice($contributors, 0, 12) as $contributor): ?>
                    <div class="contributor">
                        <img src="<?= htmlspecialchars($contributor['avatar_url']) ?>" 
                             alt="<?= htmlspecialchars($contributor['login']) ?>">
                        <p><?= htmlspecialchars($contributor['login']) ?></p>
                        <p>Contribuciones: <?= $contributor['contributions'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>