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

    public function allInIdByLimit(int $limit, int $offset, int $idCategory)
    {
        $posts = $this->query("SELECT * FROM {$this->table} as p 
                            JOIN post_category as pc ON pc.post_id = p.id 
                            WHERE pc.category_id = {$idCategory} 
                            ORDER BY created_at DESC 
                            LIMIT {$limit} OFFSET {$offset}");
        //"SELECT p.* FROM post p JOIN post_category pc ON pc.post_id = p.id WHERE pc.category_id = {$category->getId()} ORDER BY created_at DESC"
        
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
}