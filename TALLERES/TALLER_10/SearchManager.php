<?php
require_once 'config.php';

class SearchManager {
    private $github;
    
    public function __construct(GitHubClient $github) {
        $this->github = $github;
    }
    
    // Búsqueda de usuarios
    public function searchUsers($query, $sort = 'repositories', $order = 'desc') {
        return $this->github->get('/search/users', [
            'q' => $query,
            'sort' => $sort,
            'order' => $order
        ]);
    }
    
    // Búsqueda de repositorios
    public function searchRepositories($query, $params = []) {
        $defaultParams = [
            'q' => $query,
            'sort' => 'stars',
            'order' => 'desc'
        ];
        
        return $this->github->get('/search/repositories', 
            array_merge($defaultParams, $params)
        );
    }
    
    // Búsqueda de código
    public function searchCode($query, $params = []) {
        $defaultParams = [
            'q' => $query,
            'sort' => 'indexed',
            'order' => 'desc'
        ];
        
        return $this->github->get('/search/code', 
            array_merge($defaultParams, $params)
        );
    }
    
    // Construir query para repositorios
    public function buildRepositoryQuery($filters) {
        $query = [];
        
        if (!empty($filters['language'])) {
            $query[] = "language:{$filters['language']}";
        }
        
        if (!empty($filters['stars'])) {
            $query[] = "stars:>={$filters['stars']}";
        }
        
        if (!empty($filters['created'])) {
            $query[] = "created:>={$filters['created']}";
        }
        
        if (!empty($filters['topic'])) {
            $query[] = "topic:{$filters['topic']}";
        }

        if (!empty($filters['keyword'])) {
            $query[] = $filters['keyword'];
        }
        
        return implode(' ', $query);
    }
}
?>
        