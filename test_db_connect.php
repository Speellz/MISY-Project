<?php
include 'db_connect.php';

if ($conn) {
    echo "Database connection established successfully!";
} else {
    echo "Database connection failed.";
}
?>
