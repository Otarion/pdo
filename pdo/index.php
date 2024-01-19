<?php
// Seulement des appels de fonctions ici ! Aucune définition
include __DIR__.'/functions.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10;

$pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
</head>
<body>

<?php

$posts = getPostsWithCategories($pdo, $page, $perPage);

$noCategoryPosts = array_filter($posts, 'hasNoCategory');

foreach ($noCategoryPosts as $post) {

   echo '<div>'.
        '<p>'.$post['title'] .'</p>'.
        '<p>'.$post['body'] .'</p>'.
        '<p>'.$post['excerpt'] .'</p>'.
   '</div>'.

   '<div>'.
        '<a href="./comments.php">'.
        '<img src="./comment.svg" alt="Comment">'.
        '</a>'.

        '<a href="./update.php">'.
        '<img src="./update.svg" alt="Update">'.
        '</a>'.

        '<a href="./delete.php">'.
        '<img src="./delete.svg" alt="Delete">'.
        '</a>'.

   '</div>';
};

?>

</body>
</html>

