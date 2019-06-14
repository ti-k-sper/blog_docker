<?php
use App\Model\{
    Post,
    Category
};
use App\Connection;
use App\Helpers\Text;

$pdo = Connection::getPDO();


$categories = $pdo->query("SELECT * FROM category ")
            ->fetchAll();

$title = "Catégories";

?>

<ul class="list-group list-group-flush">
    <?php foreach ($categories as $category) : ?>
        <li class="list-group-item"><a href="/category/<?= $category['slug'] ?>-<?= $category['id'] ?>">Catégorie <?= $category['name'] ?></a></li>
    <?php endforeach; ?>
</ul>