<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

include 'db_connect.php';

$user_id = $_SESSION['user_id'];
$playlistName = $_POST['playlistName'];
$playlistDescription = $_POST['playlistDescription'];
$song_ids = $_POST['songs'];

// yeni playlist
$sql = "INSERT INTO Playlists (name, description, user_id) VALUES (?, ?, ?)";
$params = array($playlistName, $playlistDescription, $user_id);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => sqlsrv_errors()]);
    exit;
}

// yeni playlist için id
$playlist_id = sqlsrv_insert_id($stmt);

// tabloya müzikleri aktarma
foreach ($song_ids as $song_id) {
    $sql = "INSERT INTO PlaylistSongs (playlist_id, song_id) VALUES (?, ?)";
    $params = array($playlist_id, $song_id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => sqlsrv_errors()]);
        exit;
    }
}

echo json_encode(['success' => true]);

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
