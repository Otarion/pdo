<?php

require_once __DIR__.'/functions.php';

$pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;
    $content = isset($_POST['content']) ? $_POST['content'] : null;
 
    if ($postId === null || $content === null) {
        if ($postId === null) {
            echo 'L\'identifiant de l\'article à commenter est manquant.';
        }
        if ($content === null) {
            echo 'Le contenu du commentaire est manquant.';
        }
    } else {
        // Call the function to add the comment
        $success = addComment($pdo, $postId, $content);
 
        // Check the result of the operation
        if ($success) {
            echo 'Le commentaire a été ajouté avec succès.';
        } else {
            echo 'Erreur lors de la diffusion du commentaire.';
        }
    }
 } 

function addComment($pdo, $postId, $content) {
    $sql = "INSERT INTO comments (post_id, content) VALUES (:post_id, :content)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':post_id', $postId);
    $stmt->bindParam(':content', $content);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
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
    <title>Créer un commentaire</title>
</head>
<body>

<form action="comments.php?id=<?php echo $postId; ?>" method="post">
   <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
   <input type="hidden" name="postId" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

   <br><label for="content">Commentaire :</label><br>
   <textarea name="content" placeholder="Insérer votre commentaire" cols="50" required></textarea><br>

   <br><button type="submit">Commenter</button>
</form>

</body>
</html>