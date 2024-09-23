<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connect.php';

if(isset($_POST['SignUP'])){
    echo "vikonuetsa";
    $firstName=$_POST['firstName'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

    $checkEmail="SELECT * From users_home where email='$email'";
    $result=$conn->query($checkEmail);
    if($result->num_rows>0){
        echo "Email Addres Alredy Exists !";
    }
    else{
        $insertQuery="INSERT INTO users_home(firstName,email,password)
                        VALUES ('$firstName','$email','$password')";
            if($conn->query($insertQuery)==TRUE){
            header("location: index.php");
            }
            else{
                echo "Error:".$conn->error;
            }
    }
}

if(isset($_POST['SignIn'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

    $sql="SELECT * FROM users_home WHERE email='$email' and password='$password'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row=$result->fetch_assoc();
        $_SESSION['email']=$row['email'];
        header("location: homepage.php");
        exit();
    }
    else{
        echo "NOT Found, Incorrect Email or Password";
    }
}
?>