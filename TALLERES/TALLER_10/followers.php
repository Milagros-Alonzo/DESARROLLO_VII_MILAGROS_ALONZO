<?php
require_once 'config.php';
require_once 'SocialManager.php';

$socialManager = new SocialManager($github);

// Procesar acciones de seguir/dejar de seguir
if (isset($_POST['action']) && isset($_POST['username'])) {
    try {
        if ($_POST['action'] === 'follow') {
            $socialManager->followUser($_POST['username']);
        } elseif ($_POST['action'] === 'unfollow') {
            $socialManager->unfollowUser($_POST['username']);
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Obtener seguidores y siguiendo
try {
    $followers = $socialManager->getFollowers();
    $following = $socialManager->getFollowing();
} catch (Exception $e) {
    $error = $e->getMessage();
    $followers = [];
    $following = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Seguidores</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .user-lists { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .user-item { border: 1px solid #ddd; margin: 5px 0; padding: 10px; }
        .error { color: red; padding: 10px; background: #fee; }
        .avatar { width: 50px; height: 50px; border-radius: 25px; vertical-align: middle; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Seguidores</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <div class="user-lists">
            <div class="followers">
                <h2>Mis Seguidores (<?= count($followers) ?>)</h2>
                <?php foreach ($followers as $user): ?>
                    <div class="user-item">
                        <img src="<?= htmlspecialchars($user['avatar_url']) ?>" 
                             alt="Avatar" class="avatar">
                        <a href="<?= htmlspecialchars($user['html_url']) ?>" target="_blank">
                            <?= htmlspecialchars($user['login']) ?>
                        </a>
                        
                        <?php if (!$socialManager->isFollowing($user['login'])): ?>
                            <form method="POST" style="display: inline; float: right;">
                                <input type="hidden" name="username" 
                                       value="<?= htmlspecialchars($user['login']) ?>">
                                <input type="hidden" name="action" value="follow">
                                <button type="submit">Seguir</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="following">
                <h2>Siguiendo (<?= count($following) ?>)</h2>
                <?php foreach ($following as $user): ?>
                    <div class="user-item">
                        <img src="<?= htmlspecialchars($user['avatar_url']) ?>" 
                             alt="Avatar" class="avatar">
                        <a href="<?= htmlspecialchars($user['html_url']) ?>" target="_blank">
                            <?= htmlspecialchars($user['login']) ?>
                        </a>
                        
                        <form method="POST" style="display: inline; float: right;">
                            <input type="hidden" name="username" 
                                   value="<?= htmlspecialchars($user['login']) ?>">
                            <input type="hidden" name="action" value="unfollow">
                            <button type="submit">Dejar de Seguir</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
        