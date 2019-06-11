<?php

namespace App;

class PaginatedQuery
{
    private $queryCount;

    private $query;

    private $classMapping;

    private $url;

    private $perPage;

    private $pdo;

    private $items;

    private $count;

    public function __construct(string $queryCount, 
                                string $query, 
                                string $classMapping, 
                                string $url, 
                                int $perPage = 12)
    {
        $this->queryCount = $queryCount;
        $this->query = $query;
        $this->classMapping = $classMapping;
        $this->url = $url;
        $this->perPage = $perPage;
        $this->pdo = Connection::getPDO();
    }
    //affichage des articles ds le fichiers show.php
    public function getItems(): array
    {
        $nbPage = $this->getNbPages();
        $currentPage = URL::getPositiveInt('page', 1);
        if ($currentPage > $nbPage) {
            throw new \Exception('pas de pages');
        }
        if($this->items === null){
            $offset = ($currentPage - 1) * $this->perPage;
            $statement = $this->pdo->query("{$this->query} LIMIT {$this->perPage} OFFSET {$offset}");
            $statement->setFetchMode(\PDO::FETCH_CLASS, $this->classMapping);
            $this->items = $statement->fetchAll();
        }
        return $this->items;
    }
    //pagination
    //calcul nb pages
    public function getNbPages(): string
    {
        if ($this->count === null) {
            $this->count = $this->pdo
                ->query($this->queryCount)
                ->fetch()[0];
        }
        return ceil($this->count / $this->perPage);
    }

    public function getNav(): array
    {
        $uri = $this->url;
        $nbPage = $this->getNbPages();
        $navArray = [];
        for ($i = 1; $i <= $nbPage; $i++){
            //if($i == 1){
            //    $url =  $uri;
            //}else{
            //    $url = $uri . "?page" . $i;
            //}
            //correpond
            $url = $i == 1 ? $uri : $uri . "?page=" . $i;
            //[1=>url, 2=>url]
            $navArray[$i] = $url;
        }
        return $navArray;
    }

    private function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', 1);
    }

    public function getNavHTML()
    {
        $urls = $this->getNav();
        $html = "";
        foreach ($urls as $key => $url) {
            $class = $this->getCurrentPage() == $key ? " active" : "";
            $html .= "<li class=\"page-item {$class}\"><a class=\"page-link\" href=\"{$url}\">{$key}</a></li>";
        }
        //pour ecrire en html
        return <<<HTML
        <nav class="Page navigation">
            <ul class="pagination justify-content-center">
                {$html}
            </ul>
        </nav>
HTML;
    }
}