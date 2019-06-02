<?php
/**
 * fichier qui génère la vue pour l'url /article/[i:id]
 * 
 */
$id = $params['id'];
$slug = $params['slug'];

$pdo = new PDO(
    "mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE'), 
    getenv('MYSQL_USER'), 
    getenv('MYSQL_PASSWORD'));
$post = $pdo->prepare("SELECT * FROM post WHERE {$id} ")
            ->execute()
            ->fetch();

dump($post);


$title = "Article : " . $slug;
?>


<p>article avec l'id <big><?= $id . '</big> et le slug <big>' . $slug ?></big></p>