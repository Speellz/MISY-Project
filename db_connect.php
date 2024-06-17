<?php
$serverName = "SPELLZ\SQLEXPRESS";
$database = "Project";
$username = "";
$password = "";

$connectionOptions = array(
    "Database" => $database,
    "Uid" => $username,
    "PWD" => $password
);

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die("Veritabanına bağlanırken hata oluştu: " . print_r(sqlsrv_errors(), true));
}
?>
