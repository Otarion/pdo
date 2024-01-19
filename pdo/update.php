<?php

require_once __DIR__.'/functions.php';

$pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');

if (isset($_GET['id'])) {
    $postId = (int)$_GET['id'];

    // Récupérer les détails de l'article à modifier
    $postDetails = getPostDetails($pdo, $postId);

    // Vérifier si l'article existe
    if ($postDetails) {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $title = $_POST['title'];
            $body = $_POST['body'];
            $excerpt = $_POST['excerpt'];

            // Appeler la fonction pour mettre à jour l'article
            $success = updatePost($pdo, $postId, $title, $body, $excerpt);

            // Vérifier le résultat de la mise à jour
            if ($success) {
                echo 'L\'article a été mis à jour avec succès.';
            } else {
                echo 'Erreur lors de la mise à jour de l\'article.';
            }
        }
    } else {
        echo 'L\'article spécifié n\'existe pas.';
    }
} else {
    echo 'L\'identifiant de l\'article est manquant.';
}

// La fonction pour mettre à jour un article
function updatePost($pdo, $postId, $title, $body, $excerpt) {

    $query = $pdo->prepare("UPDATE posts SET title = ?, body = ?, excerpt = ? WHERE id = ?");
    $success = $query->execute([$title, $body, $excerpt, $postId]);

    return $success;
}

// Fonction pour récupérer les détails d'un article
function getPostDetails($pdo, $postId) {
    $query = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $query->execute([$postId]);
    return $query->fetch(PDO::FETCH_ASSOC);
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
    <title>Modifier l'article</title>
</head>
<body>
    <form action="update.php?id=<?php echo $postId; ?>" method="post">

        <label for="title">Titre :</label><br>
        <input type="text" name="title" placeholder="Insérer le titre" value="<?php echo $postDetails['title']; ?>" required><br>

        <br><label for="body">Texte :</label><br>
        <textarea name="body" placeholder="Insérer le texte" cols="50" rows="20" required>
        <?php echo $postDetails['body']; ?>
        </textarea><br>

        <br><label for="excerpt">Extrait :</label><br>
        <textarea name="excerpt" placeholder="Insérer un extrait de l'article" cols="50" required>
        <?php echo $postDetails['excerpt']; ?>
        </textarea><br>

        <br><button type="submit">Modifier l'article</button>
    </form>
</body>
</html>