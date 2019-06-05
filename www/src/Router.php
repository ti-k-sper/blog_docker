<?php
namespace App;

class Router
{

    private $router;

    private $viewPath;
    //        = contruction de l'objet
    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
    }
    //       =$_GET          URL         fichier     nom route
    public function get(string $uri, string $file, string $name): self
    {
        $this->router->map('GET', $uri, $file, $name);
        return $this;// pour ajouter différents get lors de l'appel
    }
    //$router->url('post', ['id' => $post->getId(), 'slug' => $post->getSlug()])
    public function url(string $name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }

    //verifie si une route match avec les routes prédéfinies
    public function run(): void
    {
        $match = $this->router->match();
        $router = $this;//$router->url('post', ['id' => $post->getId(), 'slug' => $post->getSlug()]), variable que ds views
        ob_start();//démarrage du cache
        if (is_array($match)) {
            $params = $match['params'];
            require $this->pathToFile($match['target']);
        } else {
            // no route was matched
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
            require $this->pathToFile("layout/404");
        }
        $content = ob_get_clean();//récupération du cache en string (html)
        require $this->pathToFile("layout/default");
    }

    private function pathToFile(string $file): string
    {
        return $this->viewPath . DIRECTORY_SEPARATOR . $file . '.php';
    }
}
