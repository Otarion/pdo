<?php
require_once __DIR__.'/functions.php';

$pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');

$id = isset($_GET['id']) ? $_GET['id'] : null;

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'id de l'article à supprimer est présent
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($id !== null) {
        // Appeler la fonction pour supprimer l'article
        $success = deletePost($pdo, $id);

        // Vérifier le résultat de la suppression
        if ($success) {
            echo 'L\'article a été supprimé avec succès.';
        } else {
            echo 'Erreur lors de la suppression de l\'article.';
        }
    } else {
        echo 'L\'identifiant de l\'article à supprimer est manquant.';
    }
}

function deletePost($pdo, $id) {
  $query = $pdo->prepare("DELETE FROM posts WHERE id = ?");
  $success = $query->execute([$id]);

  return $success;
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10;

$posts = getPostsWithCategories($pdo, $page, $perPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer l'article</title>
</head>
<body>

<form action="delete.php" method="post">
    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
    <p>Êtes-vous sûr(e) de vouloir supprimer cet article ?</p>
    <br><button type="submit">Oui, je supprime.</button><br>
    <br><button type="button" onclick="window.history.back();">Non, je conserve cet article.</button><br>
</form>

</body>
</html>