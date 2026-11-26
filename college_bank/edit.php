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
<head><title>Редактирование</title></head>
<body>
    <h2>Редактировать профиль</h2>
    <form action="actions/update.php" method="POST">
        <label>Имя:</label><br>
        <input type="text" name="name" value="<?= e($user['name']) ?>" required maxlength="100"><br><br>

        <label>О себе:</label><br>
        <textarea name="bio" rows="4" cols="40"><?= e($user['bio']) ?></textarea><br><br>

        <label>Навыки:</label><br>
        <input type="text" name="skills" value="<?= e($user['skills']) ?>"><br><br>

        <button type="submit">Сохранить</button>
        <a href="profile.php">Отмена</a>
    </form>
</body>
</html>