<?php

include 'db_connect.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    die("Please fill all fields.");
}

$sql = "SELECT * FROM Users WHERE username = ?";
$params = array($username);

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die("Error during query execution: " . print_r(sqlsrv_errors(), true));
}

$user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    header("Location: index.php");
    exit();
} else {
    die("Invalid username or password.");
}
?>