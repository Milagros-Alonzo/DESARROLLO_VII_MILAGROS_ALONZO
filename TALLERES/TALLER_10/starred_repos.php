<?php
require_once 'config.php';
require_once 'SocialManager.php';

$socialManager = new SocialManager($github);

// Procesar acciones de estrella/desestrella
if (isset($_POST['action']) && isset($_POST['owner']) && isset($_POST['repo'])) {
    try {
        if ($_POST['action'] === 'star') {
            $socialManager->starRepository($_POST['owner'], $_POST['repo']);
        } elseif ($_POST['action'] === 'unstar') {
            $socialManager->unstarRepository($_POST['owner'], $_POST['repo']);
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Obtener repositorios con estrella
try {
    $starredRepos = $socialManager->getStarredRepositories();
} catch (Exception $e) {
    $error = $e->getMessage();
    $starredRepos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Repositorios con Estrella</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .repo-item { border: 1px solid #ddd; margin: 10px 0; padding: 15px; }
        .error { color: red; padding: 10px; background: #fee; }
        .stats { font-size: 0.9em; color: #666; }
        .button { padding: 5px 10px; margin: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mis Repositorios con Estrella</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <div class="repos">
            <?php foreach ($starredRepos as $repo): ?>
                <div class="repo-item">
                    <h3>
                        <a href="<?= htmlspecialchars($repo['html_url']) ?>" target="_blank">
                            <?= htmlspecialchars($repo['full_name']) ?>
                        </a>
                    </h3>
                    
                    <p><?= htmlspecialchars($repo['description'] ?? 'Sin descripción') ?></p>
                    
                    <div class="stats">
                        <span>⭐ <?= number_format($repo['stargazers_count']) ?></span> |
                        <span>🍴 <?= number_format($repo['forks_count']) ?></span>
                    </div>
                    
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="owner" value="<?= htmlspecialchars($repo['owner']['login']) ?>">
                        <input type="hidden" name="repo" value="<?= htmlspecialchars($repo['name']) ?>">
                        <input type="hidden" name="action" value="unstar">
                        <button type="submit" class="button">Quitar Estrella</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
        