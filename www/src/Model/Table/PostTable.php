<?php
namespace App\Model\Table;

use App\Model\Entity\PostEntity;

class PostTable extends Table
{
    public function allByLimit(int $limit, int $offset)
    {
        $posts = $this->query("SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT {$limit}  OFFSET {$offset}");
        
        $ids = array_map(function (PostEntity $post) {
            return $post->getId();
        }, $posts);
        
        $categories = (new CategoryTable($this->db))->AllInId(implode(', ', $ids));
        
        $postById = [];
        foreach ($posts as $post) {
            $postById[$post->getId()] = $post;
        }
        foreach ($categories as $category) {
            $postById[$category->post_id]->setCategories($category);
        }

        return $postById;
    }

    public function getPostById(int $id)
    {
        /* =>$post
        $pdo = Connection::getPDO();
        $statement = $pdo->prepare("SELECT * FROM post WHERE id=?");
        $statement->execute([$id]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, PostEntity::class);
        /** @var Post|false */
        /*$post = $statement->fetch();
        */

        //query(string $statement, ?array $attributes = null, bool $one = false, ?string $class_name = null)
        return $this->query("SELECT * FROM post WHERE id=?", [$id], true, $class_name);
    }
}