<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title><?= $title ? 'Mon site | ' . $title : 'Mon site' ?></title>
</head>

<body class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="/">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/categories">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact">Contact</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input id="inputSearch" class="form-control mr-sm-2" type="search" placeholder="Search">
                <button class="btn btn-secondary my-2 my-sm-0" onclick="getValue()" type="button">Search</button>
            </form>
        </div>
    </nav>

    <section class="bg-light mb-2 mt-3 p-5" style="min-height:100vh">
        <header class="jumbotron  mb-5">
            <h1 class="text-center display-4"><?= $title ?? 'Mon site' ?></h1>
        </header>
        <?= $content ?>
    </section>

    <style type="text/css">
        .highlight{
            background: yellow;
            border: 2px inset grey;
            }
    </style>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        /*function getValue(){
            $('span').contents().unwrap();
            //$("span").removeAttr("style");
            var word = $('#inputSearch').val();//récupère la valeur de l'input #inputSearch
            var field = $('.article').html();//récupère le contenu html de l'article #article
            var pos = field.indexOf(word);//cherche la première occurence du mot
            var re = new RegExp('('+word+')(?![]^<>*)', "gi");//créer une expression régulière qui accept le mot mais exclu les caractères spéciaux
            if (pos > -1){
                //remplace tout les mots de la chaîne de caractère originale en fonction de la RegExp puis la stocke dans le content
                var content = field.replace(re, '<span style="background-color: yellow">'+word+'</span>');
                //Remplace le contenu original par le nouveau contenu
                $('.article').html(content);
            }
        }*/

        function getValue() {
            /* TO DO
                Gérer la casse,
                Supprimer les spans en trop de l'article traité
            */

            //$('span').removeAttr('style');
            $('span').contents().unwrap();
            var word = $('#inputSearch').val();// Récupère la valeur de l'input#inputSearch
            var field = $('.article').html();//Récupère le contenu html de l'article#article
            var pos = field.indexOf(word); //Cherche la première occurence du mot word
            var re = new RegExp('('+word+')(?![^<]*>)', "gi"); //Créé une expression régulière qui accepte le mot word mais exclue les caractères spéciaux
            if (pos > -1){
                //Remplace tous les mots word de la chaine de caractère originale en fonction de la regExp puis la stocke dans content
                var content = field.replace (re, '<span style="background-color: #00FF00">'+word+'</span>');
                //remplace le contenu orginal par le nouveau contenu
                $('.article').html(content);  
            }
        }
    </script>

    <footer class="footer bg-dark fixed-bottom py-1">
        <div class="text-center">
            <?php
                $debug = "";
                if(getenv("ENV_DEV")){
                    $end = microtime(TRUE);
                    $generationtime = number_format((($end - GENERATE_TIME_START)*1000), 2);
                    $debug = " - page générée en " . $generationtime . " ms.";
                }
            ?>
            <span class="text-white">realised by Yannick (in training) <?= $debug ?></span>
        </div>
    </footer>
</body>
</html>