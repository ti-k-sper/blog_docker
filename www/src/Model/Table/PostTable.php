<?php
namespace App\Model\Table;

use App\Model\Entity\PostEntity;

class PostTable extends Table
{
    public function allByLimit(int $limit, int $offset)
    {
        $posts = $this->query("{$this->query} LIMIT {$this->perPage}  OFFSET {$offset}");
        
        $ids = array_map(function (PostEntity $post) {
            return $post->getId();
        }, $posts);
        
        $categories = Connection::getPDO()
        ->query("SELECT c.*, pc.post_id
                FROM post_category pc 
                LEFT JOIN category c on pc.category_id = c.id
                WHERE post_id IN (" . implode(', ', $ids) . ")")
        ->fetchAll(\PDO::FETCH_CLASS, \App\Model\Entity\CategoryEntity::class);
        
        $postById = [];
        foreach ($posts as $post) {
            $postById[$post->getId()] = $post;
        }
        foreach ($categories as $category) {
            $postById[$category->post_id]->setCategories($category);
        }

        return $postById;
    }
}