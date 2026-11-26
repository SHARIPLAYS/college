<?php
session_start();
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $stmt = $pdo->prepare("SELECT id FROM users WHERE login = :login");
    $stmt->execute(['login' => $login]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: profile.php');
        exit;
    } else {
        $error = "Пользователь не найден";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Вход</title></head>
<body>
    <h2>Вход в Колледж.Банк</h2>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        Логин: <input type="text" name="login" required><br><br>
        <button type="submit">Войти</button>
    </form>
</body>
</html>