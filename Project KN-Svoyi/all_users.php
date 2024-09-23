<?php
// Підключення до бази даних
$conn = new mysqli("localhost", "root", "", "login");

// Перевірка підключення
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// SQL запит для отримання всіх авторизованих користувачів
$sql = "
SELECT u.firstName, p.file
 FROM users_home u
 JOIN profilepfp p ON u.id = p.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul class='user-list'>";
    // Виводимо дані про кожного користувача
    while($row = $result->fetch_assoc()) {
        $username = htmlspecialchars($row['firstName']);
        $profileImage = htmlspecialchars($row['file']);
        
        echo "<li class='user-item'>";
        echo "<img src='$profileImage' alt='$username' class='user_avatar' />";
        echo "<span class='user-name'>$username</span>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Користувачі не знайдені.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <title> HOME </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=SUSE:wght@100..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/all_users.css">
</head>
<body>
    <header>
        <h2 class="logo">КН-Свої</h2>
        <nav class="navigation">
            <a href="index.php">Головна</a>
            <a href="#">Про нас</a>
            <a href="all_users.php">Контакти</a>
            <button class="LoginButton">Login</button>
        </nav>
    </header>
</body>
</html>