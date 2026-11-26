<?php
require 'includes/auth.php';
require 'config/db.php';

$stmt = $pdo->prepare("SELECT name, bio, skills FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html>
<head><title>Мой профиль</title></head>
<body>
    <h2>Личный кабинет</h2>
    <p><strong>Имя:</strong> <?= e($user['name']) ?></p>
    <p><strong>О себе:</strong> <?= nl2br(e($user['bio'])) ?></p>
    <p><strong>Навыки:</strong> <?= e($user['skills']) ?></p>
    <hr>
    <a href="edit.php">Редактировать профиль</a> |
    <a href="logout.php">Выйти</a>
</body>
</html>