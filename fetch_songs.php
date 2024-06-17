<?php
header("Content-Type: application/json; charset=UTF-8");
include 'db_connect.php';

$conn = getConnection();

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT title, duration, album_id, genre_id, artist_id FROM Songs";
$params = array();

if ($search) {
    $sql .= " WHERE title LIKE ? OR genre_id IN (SELECT genre_id FROM Genres WHERE genre_name LIKE ?)";
    $params = array("%$search%", "%$search%");
}

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(json_encode(array("error" => "Query failed: " . sqlsrv_errors())));
}

$songs = array();

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $songs[] = $row;
}

sqlsrv_close($conn);

echo json_encode($songs);
?>
