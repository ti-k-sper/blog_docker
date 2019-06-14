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

$categories = Post::queryCategories($post->getId());

$title = "Article : " . $post->getSlug();

?>
<div class="text-muted text-center pb-5 mb-5">
    <?php foreach ($categories as $key => $category) :
        if ($key > 0) {
            echo ', ';
        }
        $category_url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
        ?><a href="<?= $category_url ?>"><?= $category->getName() ?></a><?php endforeach; ?>
</div>
    <p class="mx-4 text-justify"><?= nl2br(htmlspecialchars($post->getContent())) ?></p><hr />
    <?= $post->getCreatedAt()->format('d/m/Y h:i') ?>
</div>
