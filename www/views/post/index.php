<?php
use App\Model\Post;
use App\Helpers\Text;
use App\Connection;

$paginatedQuery = new App\PaginatedQuery(
    "SELECT count(id) FROM post", 
    "SELECT * FROM post 
    ORDER BY id", 
    Post::class, 
    $router->url('home')
);

$posts = $paginatedQuery->getItems();

$title = 'Mon blog en MVC';
?>

<?php if (null !== $message) : ?>
    <div class="alert-message">
        <?= $message ?>
    </div>
<?php endif ?>

<section class="row articles">
    <?php foreach ($posts as $post) : ?>
        <article class="col-3 mb-4 d-flex align-items-stretch article">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $post->getName() ?></h5>
                    <p class="card-text"><?= Text::excerpt($post->getContent(), 200) ?></p>
                </div>
                <a href="<?= $router->url('post', ['id' => $post->getId(), 'slug' => $post->getSlug()]) ?>" class="text-center pb-2">lire plus</a>
                <div class="card-footer text-muted">
                    <?= ($post->getCreatedAt())->format('d/m/Y h:i') ?>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</section>

<?php
    echo $paginatedQuery->getNavHTML();