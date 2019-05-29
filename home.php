<?php
require_once('config.php');

function getDB(	$dbuser='', 
				$dbpassword='', 
				$dbhost='',
				$dbname='') //:\PDO
{
	

	$dsn = 'mysql:dbname='.$dbname.';host='.$dbhost.';charset=UTF8';
	try {
    	$pdo = new PDO($dsn, $dbuser, $dbpassword);
    	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    	return $pdo;

	} catch (PDOException $e) {
    	echo 'Connexion échouée : ' . $e->getMessage();
    	die();
	}
}

//$sql = "SELECT * FROM `post` LIMIT 10";
//$pdo = getDB($dbuser, $dbpassword, $dbhost, $dbname);
//$statement = $pdo->prepare($sql);
//$statement->execute(); 

//$postsArray = $statement->fetchAll();

//$numPage = $_GET['page']
$pdo = getDB($dbuser, $dbpassword, $dbhost, $dbname);
$pagination = $pdo->query('SELECT count(id) FROM post')->fetch()["count(id)"]/10;

if (null !== $_GET['page'] && intval($_GET['page'] > 0 && $_GET['page'] <= $pagination)) {
    $start = 10 * $_GET['page'] - 10;
}else{
    if (null !== $_GET['page'] && !intval($_GET['page']) || $_GET['page'] > $pagination) {
        $message = 'Page introuvable';
    }
    $start = 0;
}

$rec = $pdo->query("SELECT * FROM post ORDER BY id LIMIT 10 OFFSET {$start}");
$rec = $rec->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Articles</h1>
    <section class="articles">
        <?php foreach($rec as $key => $value) : ?>
            <article>
		        <h2><a href="<?= $value->slug ?>"><?= $value->id ?>-<?= $value->name ?></a></h2>
                <p class="content"><?= $value->content ?></p>
                <p class="created"><?= $value->created_at ?></p>
            </article>
	    <?php endforeach; ?>
    </section>
    <section class="pagination">
        <p>
            <a href="/">1</a>
            <?php for ($i=2; $i <= $pagination ; $i++) : ?>
                <a href="/?page=<?= $i ?>"><?= $i ?></a>
            <?php endfor ?>
        </p>
    </section>
</body>
</html>