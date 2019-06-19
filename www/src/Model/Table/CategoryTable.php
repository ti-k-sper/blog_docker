<?php
namespace App\Model\Table;

class CategoryTable extends Table
{
    public function AllInId(string $ids)
    {
        return $this->query("SELECT c.*, pc.post_id
        FROM post_category pc 
        LEFT JOIN category c on pc.category_id = c.id
        WHERE post_id IN (".$ids.")");
    }

    public function allByLimit(int $limit, int $offset)
    {
        /*
        $paginatedQuery = new PaginatedQueryController(
            "SELECT count(id) FROM category",
            "SELECT * FROM category 
            ORDER BY id",
            CategoryEntity::class,
            $this->getRouter()
                ->url('categories'),
            10
        );*/
        return $this->query("SELECT * FROM {$this->table} LIMIT {$limit} OFFSET {$offset}");
    }
}