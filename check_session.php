<?php
session_start();

$response = array('loggedIn' => false);

if (isset($_SESSION['username'])) {
    $response['loggedIn'] = true;
    $response['username'] = $_SESSION['username'];
    $response['email'] = $_SESSION['email'];
}

echo json_encode($response);
?>