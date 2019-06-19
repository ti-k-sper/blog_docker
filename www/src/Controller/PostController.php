<?php
namespace App\Controller;

use \App\Model\Entity\PostEntity;

use \App\Model\Entity\CategoryEntity;


class PostController extends Controller
{
    public function __construct()
    {
        $this->loadModel('post');//3
        //$this->post
        $this->loadModel('category');
    }
    
    public function all()
    {
        //dd($this->post);
        $paginatedQuery = new PaginatedQueryController(
            $this->post,
            $this->generateUrl('home')
        );
        
        $postById = $paginatedQuery->getItems();
        
        $title = 'Mon blog en MVC';
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

        $post = $this->post->getPostById($id);
        //dd($post);
        /* =>PostTable
        $pdo = Connection::getPDO();
        
        $statement = $pdo->prepare("SELECT * FROM post WHERE id=?");
        $statement->execute([$id]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, PostEntity::class);
        /** @var Post|false */
        /*$post = $statement->fetch();
        */
        if (!$post) {
            throw new Exception('Aucun article ne correspond à cet ID');
        }
        if ($post->getSlug() !== $slug) {
            $url = $this->generateUrl('post', ['id' => $id, 'slug' => $post->getSlug()]);
            http_response_code(301);
            header('Location: ' . $url);
            exit();
        }
        /*if ($post->getSlug() !== $slug) {
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
        }*/

        $categories = $this->category->allInId($post->getId());
        //dd($categories);
        /* =>$categories
        $query = $pdo->prepare(
            "SELECT c.id, c.slug, c.name
            FROM post_category pc
            JOIN category c ON pc.category_id = c.id
            WHERE pc.post_id = :id"
            );
        $query->execute([':id' => $post->getId()]);
        $query->setFetchMode(\PDO::FETCH_CLASS, CategoryEntity::class);
        /** @var Category[] */
        /*$categories = $query->fetchAll();*/

        $title = "Article : " . $post->getName();

        $this->render(
            "post/show",
            [
                "title" => $title,
                "categories" => $categories,
                "post" => $post
            ]);
    }
}