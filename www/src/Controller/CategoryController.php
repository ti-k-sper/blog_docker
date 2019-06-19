<?php
namespace App\Controller;

use App\Model\Entity\ {
    CategoryEntity,
    PostEntity
};

use App\Controller\PaginatedQueryController;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->loadModel('post');//3
        //$this->post
        $this->loadModel('category');
    }

    public function all()
    {
        $paginatedQuery = new PaginatedQueryController(
            $this->category,
            $this->generateUrl('categories')
        );
        /*=>CategoryTable
        $paginatedQuery = new PaginatedQueryController(
            "SELECT count(id) FROM category",
            "SELECT * FROM category 
            ORDER BY id",
            CategoryEntity::class,
            $this->getRouter()
                ->url('categories'),
            10
        );*/
        $categories = $paginatedQuery->getItems();

        $title = "Catégories";

        $this->render(
            "category/all",
            [
            "title" => $title,
            "categories" => $categories,
            "paginate" => $paginatedQuery->getNavHTML()
            ]);
        
    }

    public function show(array $params)
    {
        $id = (int)$params['id'];
        $slug = $params['slug'];

        $category = $this->category->find($id);
        //dd($category);
        /*=>Table
        $pdo = Connection::getPDO();
        $statement = $pdo->prepare("SELECT * FROM category WHERE id=?");
        $statement->execute([$id]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, CategoryEntity::class);
        /** @var Category|false */
        /*$category = $statement->fetch();
        */
        if (!$category) {
            throw new Exception('Aucune categorie ne correspond à cet ID');
        }
        if ($category->getSlug() !== $slug) {
            $url = $this->generateUrl('category', ['id' => $id, 'slug' => $category->getSlug()]);
            http_response_code(301);
            header('Location: ' . $url);
            exit();
        }

        $uri = $this->generateUrl("category", ["id" => $category->getId(), "slug" => $category->getSlug()]);
        //dd($uri);
        $paginatedQuery = new PaginatedQueryController(
            $this->post,
            $uri
        );
        //dd($paginatedQuery);

        /*=>CategoryTable AllInIdByLimit
        $paginatedQuery = new PaginatedQueryController(
            "SELECT count(category_id) FROM post_category WHERE category_id = {$category->getId()}",
            "SELECT p.*
            FROM post p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$category->getId()}
            ORDER BY created_at DESC",
            PostEntity::class,
            $uri
        );
        */
        /*
        $ids = array_map(function (Post $post) {
            return $post->getId();
        }, $posts);
        /*
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
        */

        $postById = $paginatedQuery->getItemsInId($id);

        $title = 'Catégorie : ' . $category->getName();

        $this->render(
            "category/show",
            [
                "title" => $title,
                "posts" => $postById,
                "paginate" => $paginatedQuery->getNavHTML()
            ]);
    }
}