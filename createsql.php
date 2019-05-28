<?php
require_once 'vendor/autoload.php';//faker

$pdo = New PDO('mysql:host=172.17.0.2;dbname=blog;charset=UTF8', 'userblog', 'blogpwd');

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create('fr_FR');
//dd($faker);

for($i=0; $i<50; $i++){
    $pdo->exec("INSERT INTO post SET 
        name='{$faker->sentence()}', 
        slug='{$faker->slug}', 
        content='{$faker->paragraphs(rand(3, 15), true)}', 
        created_at='{$faker->date} {$faker->time}' ");
}

for($i=0; $i<50; $i++){
    $pdo->exec("INSERT INTO category SET 
        name='{$faker->sentence(3, false)}', 
        slug='{$faker->slug}' ");
}
