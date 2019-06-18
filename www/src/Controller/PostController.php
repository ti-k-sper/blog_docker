<?php
namespace App\Controller;

use \App\Connection;
use \App\Model\Post;
use \App\Model\Category;

class PostController extends Controller{

    public function all()
    {
        
        $paginatedQuery = new \App\PaginatedQuery(
            "SELECT count(id) FROM post",
            "SELECT * FROM post ORDER BY created_at DESC",
            Post::class,
            $this->getRouter()
                ->url('home')
        );
        $posts = $paginatedQuery->getItems();
        
        
        $ids = array_map(function (Post $post) {
            return $post->getId();
        }, $posts);
        
        
        $categories = Connection::getPDO()
        ->query("SELECT c.*, pc.post_id
                FROM post_category pc 
                LEFT JOIN category c on pc.category_id = c.id
                WHERE post_id IN (" . implode(', ', $ids) . ")")
        ->fetchAll(\PDO::FETCH_CLASS, \App\Model\Category::class);
        
        
        $postById = [];
        foreach ($posts as $post) {
            $postById[$post->getId()] = $post;
        }
        foreach ($categories as $category) {
            $postById[$category->post_id]->setCategories($category);
        }
        
        $title = 'Mon Super MEGA blog';
        $this->render('post/all', 
        [
            "title" => $title,
            "posts" => $postById,
            "paginate" => $paginatedQuery->getNavHtml()
        ]);
    }

    public function show(array $params)
    {
        $id = (int)$params['id'];
        $slug = $params['slug'];
        
        
        $pdo = Connection::getPDO();
        
        $statement = $pdo->prepare("SELECT * FROM post WHERE id=?");
        $statement->execute([$id]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        /** @var Post|false */
        $post = $statement->fetch();
        
        if (!$post) {
            throw new Exception('Aucun article ne correspond à cet ID');
        }
        
        if ($post->getSlug() !== $slug) {
            $url = $this->getRouter()->url(
                'post',
                [
                    'id' => $id,
                    'slug' => $post->getSlug()
                ]
            );
            http_response_code(301);
            header('Location: ' . $url);
            exit();
        }
        
        
        $query = $pdo->prepare(
            "SELECT c.id, c.slug, c.name
            FROM post_category pc
            JOIN category c ON pc.category_id = c.id
            WHERE pc.post_id = :id"
            );
        $query->execute([':id' => $post->getId()]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        /** @var Category[] */
        $categories = $query->fetchAll();
        $title = "article : " . $post->getName();

        $this->render(
            "post/show",
            [
                "title" => $title,
                "categories" => $categories,
                "post" => $post
            ]);
    }
}