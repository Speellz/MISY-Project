<?php

include 'db_connect.php';
session_start();

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

if (empty($username) || empty($email) || empty($password)) {
    die("Please fill all fields.");
}

$password_hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO Users (username, password, email) VALUES (?, ?, ?)";
$params = array($username, $password_hashed, $email);

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die("Error during registration: " . print_r(sqlsrv_errors(), true));
} else {
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    header("Location: index.php");
    exit();
}
?>