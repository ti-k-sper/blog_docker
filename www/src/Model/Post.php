<?php
namespace App\Model;

use \Datetime;

use App\Connection;

use App\Model\Category;

use App\Helpers\Text;

class Post
{
    private $id;

    private $name;

    private $slug;

    private $content;

    private $created_at;

    private $categories = [];

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getContent()
    {
        return $this->content;
    }
    /**
     * Get the value of created_at
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return new \DateTime($this->created_at);
    }

    public function setCategories($category)
    {
        $this->categories = $category;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function queryCategories(int $post_id): array
    {
        $pdo = Connection::getPDO();
        //requete avec JOIN
        $query = $pdo->prepare(
            "SELECT c.id, c.slug, c.name
            FROM post_category pc
            JOIN category c 
            ON pc.category_id = c.id
            WHERE pc.post_id = :id
        ");
        $query->execute([':id' => $post_id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        return $query->fetchAll();
    }

    public function getExcerpt(int $lenght): string
    {
        return nl2br(htmlentities(TEXT::excerpt($this->getContent(), $lenght)));
    }
}