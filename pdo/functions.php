<?php declare(strict_types = 1);
function getPDO(string $host, string $username, string $password): PDO
{
    return new PDO($host, $username, $password);
}

function getPostsWithCategories(PDO $pdo, int $page, int $perPage) : array
{
$start = ($page - 1) * $perPage;
$query = $pdo -> prepare("SELECT p.id, p.title, p.body, p.excerpt,p.created_at, c.name
                                          FROM posts p
                                          LEFT JOIN categories c ON p.category_id = c.id
                                          ORDER BY p.created_at DESC
                                          LIMIT :start, :perPage
"); 
$query->bindParam(':start', $start, PDO::PARAM_INT);
$query->bindParam(':perPage', $perPage, PDO::PARAM_INT);
$query->execute();

if ($query->errorCode() !== '00000') {
    // Afficher les erreurs de requête pour le débogage
    print_r($query->errorInfo());
}

return $query->fetchAll(PDO::FETCH_ASSOC);

};

function getPostWithCategory(int $id, PDO $pdo): array|false
{
    $query = $pdo->prepare('SELECT p.title, p.body, p.excerpt, p.created_at, c.name
                                               FROM posts p
                                               LEFT JOIN categories c ON p.category_id = c.id
                                               WHERE p.id = :id
    ');

    $query->bindValue('id', $id, PDO::PARAM_INT);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
};

function getPostByCategory ($categoryId, PDO $pdo, int $page, int $perPage) : array
{
    $start = ($page - 1) * $perPage;
    $query = $pdo->prepare('SELECT *
                                               FROM posts p 
                                               WHERE category_id = :categoryId
                                               ORDER BY p.created_at DESC
                                               LIMIT :start, :perPage
    ');
    $query->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    $query->bindParam(':start', $start, PDO::PARAM_INT);
    $query->bindParam(':perPage', $perPage, PDO::PARAM_INT);

    $query -> execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
};

function hasNoCategory($post) {
    return empty($post['name']);
 }
 if (isset($posts) && is_array($posts)) {
    $noCategoryPosts = array_filter($posts, 'hasNoCategory');
} else {
    $noCategoryPosts = [];
};