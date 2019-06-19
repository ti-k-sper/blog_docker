<?php
namespace App\Controller;

use \App\Model\Table\Table;

use \App\URL;

class PaginatedQueryController
{
    private $classTable;

    private $url;

    private $perPage;

    private $items;

    private $count;

    public function __construct(
        Table $classTable,
        string $url = null,
        int    $perPage = 12) 
    {
        $this->classTable   = $classTable;
        $this->url          = $url;
        $this->perPage      = $perPage;
    }

    public function getItems(): array
    {
        $nbPage = $this->getNbPages();
        $currentPage = $this->getCurrentPage();
        if ($currentPage > $nbPage) {
            throw new \Exception('pas de pages');
        }
        if ($this->items === null) {
            $offset = ($currentPage - 1) * $this->perPage;
            $this->items = $this->classTable->allByLimit($this->perPage, $offset);
        }
        return $this->items;
    }

    public function getNav(): array
    {
        $uri = $this->url;
        $nbPage = $this->getNbPages();
        $navArray = [];
        for ($i = 1; $i <= $nbPage; $i++) {
            // if($i == 1){
            //     $url = $uri;
            // }else{
            //     $url = $uri . "?page=" . $i;
            // }
            $url = $i == 1 ? $uri : $uri . "?page=" . $i;

            $navArray[$i] = $url;
        }
        return $navArray;
    }

    public function getNavHtml(): string
    {
        $urls = $this->getNav();
        $html = "";
        foreach ($urls as $key => $url) {
            $class = $this->getCurrentPage() == $key ? " active" : "";
            $html .= "<li class=\"page-item {$class}\"><a class=\"page-link\" href=\"{$url}\">{$key}</a></li>";
        }
        return <<<HTML
        <nav class="Page navigation">
            <ul class="pagination justify-content-center">
                {$html}
            </ul>
        </nav>
HTML;
    }

    private function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', 1);
    }


    private function getNbPages(): float
    {
        if ($this->count === null) {
            $this->count = $this->classTable->count()->nbrow;
        }
        return ceil($this->count / $this->perPage);
    }
}