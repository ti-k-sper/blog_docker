<?php
/**
 * fichier qui génère la vue pour l'url /article/[i:id]
 * 
 */
$id = $params['id'];
$slug = $params['slug'];
$title = "Article : " . $slug;


$pdo = new PDO(
    "mysql:host=" . getenv('MYSQL_HOST') . ";dbname=" . getenv('MYSQL_DATABASE') . ";charset=UTF8", 
    getenv('MYSQL_USER'), 
    getenv('MYSQL_PASSWORD'));

$post = $pdo->query("SELECT * FROM post WHERE id = {$id} ")
            ->fetch();
//dump($post);

$postName = $post['name'];
$postContent = $post['content'];
$postCreated = $post['created_at'];

?>

<!-- <p>article avec l'id <big><?= $id . '</big> et le slug <big>' . $slug ?></big></p> -->

<section>
    <article class="article">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $postName ?></h5>
                <p class="card-text"><?= $postContent ?></p>
            </div>
            <div class="card-footer text-muted">
                <?= (new DateTime($postCreated_at))->format('d/m/Y h:i') ?>
            </div>
        </div>
    </article>
</section>


