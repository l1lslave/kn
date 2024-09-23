<?php
session_start(); // Якщо використовуєте сесії для аутентифікації
include 'connect.php';

// Перевірка, чи користувач залогінений
if (!isset($_SESSION['user_id'])) {
    die("Ви повинні увійти в систему, щоб завантажити аватарку.");
}

// Шлях для збереження завантажених файлів
$target_dir = "uploads/"; // Директорія для збереження файлів
$target_file = $target_dir . basename($_FILES["upload_pfp"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Перевіряємо, чи це зображення
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["upload_pfp"]["tmp_name"]);
    if ($check !== false) {
        echo "Файл є зображенням - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Файл не є зображенням.";
        $uploadOk = 0;
    }
}

// Перевірка розміру файлу
if ($_FILES["upload_pfp"]["size"] > 500000) {
    echo "Файл занадто великий.";
    $uploadOk = 0;
}

// Дозволяються лише певні формати файлів
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    echo "Лише JPG, JPEG, PNG і GIF файли дозволені.";
    $uploadOk = 0;
}

// Перевірка на помилки завантаження
if ($uploadOk == 0) {
    echo "Файл не було завантажено.";
} else {
    if (move_uploaded_file($_FILES["upload_pfp"]["tmp_name"], $target_file)) {
        echo "Файл " . basename($_FILES["upload_pfp"]["name"]) . " було успішно завантажено.";

        // Підключення до бази даних
        $conn = new mysqli("localhost", "root", "", "login");

        // Перевірка підключення
        if ($conn->connect_error) {
            die("Помилка підключення: " . $conn->connect_error);
        }

        // Оновлення профілю користувача
        $userId = $_SESSION['user_id'];
        $profileImagePath = $conn->real_escape_string($target_file);

        $sql = "UPDATE profilepfp SET file='$profileImagePath' WHERE id='$userId'";

        if ($conn->query($sql) === TRUE) {
            echo "Аватарку було успішно оновлено.";
            header("location: homepage.php?id=$userId");
            exit();
        } else {
            echo "Помилка: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Сталася помилка під час завантаження файлу.";
    }
}
?>
