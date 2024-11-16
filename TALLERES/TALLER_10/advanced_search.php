<?php
require_once 'config.php';
require_once 'SearchManager.php';

$searchManager = new SearchManager($github);

$filters = [
    'keyword' => $_GET['keyword'] ?? '',
    'language' => $_GET['language'] ?? '',
    'stars' => $_GET['stars'] ?? '',
    'created' => $_GET['created'] ?? '',
    'topic' => $_GET['topic'] ?? ''
];

$results = [];
$error = null;

if (!empty($filters['keyword'])) {
    try {
        $query = $searchManager->buildRepositoryQuery($filters);
        $results = $searchManager->searchRepositories($query);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda Avanzada de GitHub</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .search-form { margin-bottom: 30px; padding: 20px; background: #f5f5f5; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .results { margin-top: 20px; }
        .result-item { border: 1px solid #ddd; margin-bottom: 10px; padding: 15px; }
        .error { color: red; padding: 10px; background: #fee; }
        .stats { font-size: 0.9em; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Búsqueda Avanzada de GitHub</h1>
        
        <form class="search-form" method="GET">
            <div class="form-group">
                <label for="keyword">Palabra clave:</label>
                <input type="text" id="keyword" name="keyword" 
                       value="<?= htmlspecialchars($filters['keyword']) ?>">
            </div>
            
            <div class="form-group">
                <label for="language">Lenguaje:</label>
                <input type="text" id="language" name="language" 
                       value="<?= htmlspecialchars($filters['language']) ?>">
            </div>
            
            <div class="form-group">
                <label for="stars">Estrellas mínimas:</label>
                <input type="number" id="stars" name="stars" 
                       value="<?= htmlspecialchars($filters['stars']) ?>">
            </div>
            
            <div class="form-group">
                <label for="created">Creado después de (YYYY-MM-DD):</label>
                <input type="date" id="created" name="created" 
                       value="<?= htmlspecialchars($filters['created']) ?>">
            </div>
            
            <div class="form-group">
                <label for="topic">Topic:</label>
                <input type="text" id="topic" name="topic" 
                       value="<?= htmlspecialchars($filters['topic']) ?>">
            </div>
            
            <button type="submit">Buscar</button>
        </form>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if (!empty($results)): ?>
            <div class="results">
                <h2>Resultados (Total: <?= $results['total_count'] ?>)</h2>
                
                <?php foreach ($results['items'] as $repo): ?>
                    <div class="result-item">
                        <h3>
                            <a href="<?= htmlspecialchars($repo['html_url']) ?>" target="_blank">
                                <?= htmlspecialchars($repo['full_name']) ?>
                            </a>
                        </h3>
                        
                        <p><?= htmlspecialchars($repo['description'] ?? 'Sin descripción') ?></p>
                        
                        <div class="stats">
                            <span>⭐ <?= number_format($repo['stargazers_count']) ?></span> |
                            <span>🍴 <?= number_format($repo['forks_count']) ?></span> |
                            <span>Lenguaje: <?= htmlspecialchars($repo['language'] ?? 'N/A') ?></span> |
                            <span>Actualizado: <?= date('Y-m-d', strtotime($repo['updated_at'])) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>