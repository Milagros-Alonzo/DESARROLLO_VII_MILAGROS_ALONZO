<?php
require_once 'config.php';

class RepositoryManager {
    private $github;
    
    public function __construct(GitHubClient $github) {
        $this->github = $github;
    }
    
    // Obtener repositorios públicos de un usuario
    public function getUserRepositories($username, $sort = 'updated', $direction = 'desc') {
        return $this->github->get("/users/$username/repos", [
            'sort' => $sort,
            'direction' => $direction,
            'type' => 'public'
        ]);
    }
    
    // Obtener información detallada de un repositorio
    public function getRepositoryInfo($owner, $repo) {
        return $this->github->get("/repos/$owner/$repo");
    }
    
    // Obtener lista de lenguajes usados en un repositorio
    public function getRepositoryLanguages($owner, $repo) {
        return $this->github->get("/repos/$owner/$repo/languages");
    }
    
    // Obtener los contribuidores de un repositorio
    public function getRepositoryContributors($owner, $repo) {
        return $this->github->get("/repos/$owner/$repo/contributors");
    }
    
    // Obtener estadísticas básicas (forks, estrellas, etc.)
    public function getRepositoryStats($owner, $repo) {
        $info = $this->getRepositoryInfo($owner, $repo);
        return [
            'stars' => $info['stargazers_count'],
            'forks' => $info['forks_count'],
            'watchers' => $info['watchers_count'],
            'open_issues' => $info['open_issues_count'],
            'created_at' => $info['created_at'],
            'updated_at' => $info['updated_at']
        ];
    }
}
?>