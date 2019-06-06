<?php
use App\Model\{
    Post,
    Category
};
use App\Connection;

$id = (int)$params['id'];
$slug = $params['slug'];


$pdo = Connection::getPDO();

$statement = $pdo->prepare("SELECT * FROM post WHERE id = ? ");
$statement->execute([$id]);
$statement->setFetchMode(PDO::FETCH_CLASS, Post::class);
/**@var Post|false */
$post = $statement->fetch();
//Si aucun article correspond à l'id
if (!$post) {
    throw new Exception('Aucun article ne correspond à cet ID');
}
if ($post->getSlug() !== $slug) {
    $url = $router->url(
        'post',
        [
            'id' => $id,
            'slug' => $post->getSlug()
        ]
    );
    http_response_code(301);
    header('Location: ' . $url);
    exit();
}

//requete avec JOIN
$query = $pdo->prepare('
    SELECT c.id, c.slug, c.name
    FROM post_category pc
    JOIN category c ON pc.category_id = c.id
    WHERE pc.post_id = :id
');
$query->execute([':id' => $post->getId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category[] */
$categories = $query->fetchAll();


$title = "Article : " . $post->getSlug();

?>
<div>
    <?php foreach ($categories as $key => $category) :
        if ($key > 0) {
            echo ', ';
        }
        $category_url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]); ?>
        <a href="<?= $category_url ?>"><?= $category->getName() ?></a>
    <?php endforeach ?>
</div>

<section>
    <article class="article">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $post->getName() ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars($post->getContent())) ?></p>
            </div>
            <div class="card-footer text-muted">
                <?= $post->getCreatedAt()->format('d/m/Y h:i') ?>
            </div>
        </div>
    </article>
</section>


