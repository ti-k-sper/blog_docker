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

$statement = $pdo->prepare("SELECT * FROM post WHERE id = ? ");
$statement->execute([$id]);
$statement->setFetchMode(PDO::FETCH_OBJ);
$post = $statement->fetch();
//dump($post);


?>

<!-- <p>article avec l'id <big><?= $id . '</big> et le slug <big>' . $slug ?></big></p> -->

<section>
    <article class="article">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $post->name ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars($post->content)) ?></p>
            </div>
            <div class="card-footer text-muted">
                <?= (new DateTime($post->created_at))->format('d/m/Y h:i') ?>
            </div>
        </div>
    </article>
</section>


