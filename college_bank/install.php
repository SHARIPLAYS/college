<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'college_bank';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    echo "База данных '$dbname' успешно создана (или уже существовала).<br>";

    $pdo->exec("USE `$dbname`");

    $sqlTable = "
        CREATE TABLE IF NOT EXISTS users (
            id INT NOT NULL AUTO_INCREMENT,
            login VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            name VARCHAR(100) DEFAULT NULL,
            bio TEXT DEFAULT NULL,
            skills TEXT DEFAULT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY uq_login (login)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    $pdo->exec($sqlTable);
    echo "Таблица 'users' успешно создана (или уже существовала).<br>";

    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    if ($stmt->fetchColumn() == 0) {
        $sqlInsert = "
            INSERT INTO users (login, password, name, bio, skills) VALUES
            ('student1', '123', 'Иван Иванов', 'Студент 2 курса ИТ-отделения', 'PHP, MySQL, HTML'),
            ('student2', '123', 'Петр Петров', 'Студент 3 курса', 'Python, JS');
        ";
        $pdo->exec($sqlInsert);
        echo "Тестовые пользователи добавлены.<br>";
    }

    echo "<br><b style='color:green;'>Установка завершена успешно! Можно переходить к <a href='login.php'>входу</a>.</b>";

} catch (PDOException $e) {
    die("<b style='color:red;'>Ошибка при установке: </b>" . $e->getMessage());
}
?>