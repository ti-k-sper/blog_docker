<?php
/**
 * fichier qui génère la vue pour l'url /categories
 * 
 */
$title = "Catégories";

$pdo = new PDO(
    "mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE') . ";charset=UTF8", 
    getenv('MYSQL_USER'), 
    getenv('MYSQL_PASSWORD'));

$categories = $pdo->query("SELECT * FROM category ")
            ->fetchAll();
//dump($categories);

?>

<ul>
    <?php foreach ($categories as $category) : ?>
        <li><a href="<?= $category['slug'] ?>-<?= $category['id'] ?>">Categorie <?= $category['name'] ?></a></li>
    <?php endforeach; ?>
</ul>