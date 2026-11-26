<?php
require '../includes/auth.php';
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../profile.php');
    exit;
}

// 1. ВАЛИДАЦИЯ (Защита от пустых данных и слишком длинных строк)
$name = trim($_POST['name'] ?? '');
$bio = trim($_POST['bio'] ?? '');
$skills = trim($_POST['skills'] ?? '');

if (empty($name) || strlen($name) > 100) {
    die("Ошибка: Некорректное имя.");
}

// 2. ЗАЩИТА ОТ IDOR (Запрет чужого ID)
// Мы НЕ берем ID из формы (скрытого поля), мы берем его ТОЛЬКО из сессии.
// Злоумышленник не сможет подменить ID и отредактировать чужой профиль.
$id = $_SESSION['user_id'];

// 3. СОХРАНЕНИЕ ЧЕРЕЗ PDO UPDATE
try {
    $sql = "UPDATE users SET name = :name, bio = :bio, skills = :skills WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':bio' => $bio,
        ':skills' => $skills,
        ':id' => $id
    ]);

    // Успех - редирект обратно в профиль
    header('Location: ../profile.php?success=1');
    exit;

} catch (PDOException $e) {
    // В реальном проекте ошибку пишут в лог, а пользователю показывают красивую страницу
    die("Ошибка при сохранении: " . $e->getMessage());
}
?>