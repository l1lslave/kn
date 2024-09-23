<?php
session_start();
include 'connect.php';

if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    
    // Отримання даних користувача
    $query = mysqli_query($conn, "SELECT * FROM users_home WHERE email='$email'");
    if($row = mysqli_fetch_array($query)){
        $userId = $row['id']; // Ідентифікатор користувача
        $_SESSION['user_id'] = $userId;
        
        // Отримання зображення профілю з бази даних
        $queryImage = "SELECT file FROM profilepfp WHERE id='$userId'";
        $resultImage = $conn->query($queryImage);
        if ($resultImage->num_rows > 0) {
            $imageRow = $resultImage->fetch_assoc();
            $profilePicture = $imageRow['file']; // Шлях до зображення користувача
        }
        else{
            $profilePicture = "pfp_user.jpg";
        }
    }
}

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
    <link rel="stylesheet" href="css/homepage.css">
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
    <div class="Profile">
        <div class="ProfileWELCOME">
            <p> WELCOME <?php
            if(isset($_SESSION['email'])){
                $email=$_SESSION['email'];
                $query=mysqli_query($conn,"SELECT users_home.* FROM users_home WHERE users_home.email='$email'");
                while($row=mysqli_fetch_array($query)){
                    echo $row['firstName'];
                }
            }
            ?>
            </p>
            </div>
            <div class = "ProfilePicture">
                <form action ="upload.php" method="post" enctype="multipart/form-data">
                    <label for="fileInput">
                    <img src="<?php echo isset($profilePicture) ? $profilePicture : 'pfp_user.jpg'; ?>" height="250">
                        <div class = "overlay">
                            <div class = "iconPicture">            
                                <span class= "iconPICTUREhover">
                                <ion-icon name="brush-outline"></ion-icon>
                                </span>
                            </div>
                        </div>
                    </label>
                    <input type="file" name="upload_pfp" id="fileInput" style="display: none;" onchange="this.form.submit()">
                </form>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>