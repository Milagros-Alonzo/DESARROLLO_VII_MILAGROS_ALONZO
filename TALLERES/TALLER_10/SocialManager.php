<?php
require_once 'config.php';

class SocialManager {
    private $github;
    
    public function __construct(GitHubClient $github) {
        $this->github = $github;
    }
    
    // Obtener repositorios con estrella del usuario autenticado
    public function getStarredRepositories() {
        return $this->github->get('/user/starred');
    }
    
    // Verificar si un repositorio tiene estrella
    public function isRepositoryStarred($owner, $repo) {
        try {
            $this->github->get("/user/starred/$owner/$repo");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Dar estrella a un repositorio
    public function starRepository($owner, $repo) {
        return $this->github->put("/user/starred/$owner/$repo");
    }
    
    // Quitar estrella de un repositorio
    public function unstarRepository($owner, $repo) {
        return $this->github->delete("/user/starred/$owner/$repo");
    }
    
    // Obtener usuarios que el usuario autenticado sigue
    public function getFollowing() {
        return $this->github->get('/user/following');
    }
    
    // Obtener seguidores del usuario autenticado
    public function getFollowers() {
        return $this->github->get('/user/followers');
    }
    
    // Verificar si el usuario autenticado sigue a un usuario
    public function isFollowing($username) {
        try {
            $this->github->get("/user/following/$username");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Seguir a un usuario
    public function followUser($username) {
        return $this->github->put("/user/following/$username");
    }
    
    // Dejar de seguir a un usuario
    public function unfollowUser($username) {
        return $this->github->delete("/user/following/$username");
    }
}
?>
        