<?php

require_once __DIR__.'/functions.php';

$pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $excerpt = $_POST['excerpt'];

    $success = createPost($pdo, $title, $body, $excerpt);
    if ($success) {
        echo 'Le poste a été créé avec succès.';
    } else {
        echo 'Erreur lors de la création de le poste.';
    }
}

function createPost($pdo, $title, $body, $excerpt) {
    $query = $pdo->prepare("INSERT INTO posts (title, body, excerpt) VALUES (?, ?, ?)");
    $success = $query->execute([$title, $body, $excerpt]);

    return $success;
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10;

$pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');
$posts = getPostsWithCategories($pdo, $page, $perPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="create.php" method="post">

    <label for="title">Titre :</label><br>
    <input type="text" name="title" placeholder="Insérer le titre" required><br>

    <br><label for="body">Texte :</label><br>
    <textarea name="body" placeholder="Insérer le texte" cols="50" rows="20" required></textarea><br>

    <br><label for="excerpt">Extrait :</label><br>
    <textarea name="excerpt" placeholder="Insérer un extrait de l'article" cols="50" required></textarea><br>

    <br><button type="submit">Créer l'article</button>
</form>


</body>
</html>