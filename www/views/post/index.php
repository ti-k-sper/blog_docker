<?php
use App\Model\{
    Post,
    Category
};
use App\Connection;
use App\Helpers\Text;

$paginatedQuery = new App\PaginatedQuery(
    "SELECT count(id) FROM post", 
    "SELECT * FROM post 
    ORDER BY created_at DESC", 
    Post::class, 
    $router->url('home')
);
$posts = $paginatedQuery->getItems();

$postById = [];

$title = 'Mon blog en MVC';
?>

<?php if (null !== $message) : ?>
    <div class="alert-message">
        <?= $message ?>
    </div>
<?php endif ?>

<section class="row articles">
<?php /** @var Post::class $post */
    foreach ($posts as $post) {
        $postById[$post->getId()] = $post;
        $categories = Post::queryCategories($post->getId());
        $postById[$post->getId()]->setCategories($categories);
        //dd($posts);
        //dd($post);
        dd($postById);
        $categories = $post->getCategories();
        require 'card.php';
    }
    ?>
</section>

<?php
    echo $paginatedQuery->getNavHTML();