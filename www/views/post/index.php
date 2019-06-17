<?php
use App\Connection;
use App\Model\Post;
use App\Model\Category;

$paginatedQuery = new App\PaginatedQuery(
    "SELECT count(id) FROM post",
    "SELECT * FROM post ORDER BY created_at DESC",
    Post::class,
    $router->url('home')
);
$posts = $paginatedQuery->getItems();


$ids = array_map(function (Post $post) {
    return $post->getId();
}, $posts);


$categories = Connection::getPDO()
->query("SELECT c.*, pc.post_id
        FROM post_category pc 
        LEFT JOIN category c on pc.category_id = c.id
        WHERE post_id IN (" . implode(', ', $ids) . ")")
->fetchAll(\PDO::FETCH_CLASS, \App\Model\Category::class);


$postById = [];
foreach ($posts as $post) {
    $postById[$post->getId()] = $post;
}
foreach ($categories as $category) {
    $postById[$category->post_id]->setCategories($category);
}


$title = 'Mon Super MEGA blog';
?>

<?php if (null !== $message) : ?>
    <div class="alert-message">
        <?= $message ?>
    </div>
<?php endif ?>
<section class="row">
    <?php /** @var Post::class $post */
    foreach ($postById as $post) {
        require 'card.php';
    }
    ?>
</section>
<?php
echo $paginatedQuery->getNavHtml();
