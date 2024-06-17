<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $album_id = $_POST['album_id'];
    $genre_id = $_POST['genre_id'];
    $artist_id = $_POST['artist_id'];

    // süreyi saat ve dakika formatından dönüştürme(burayı kontrol et)
    $duration = date('H:i:s', strtotime($duration));

    $sql = "INSERT INTO Songs (title, duration, album_id, genre_id, artist_id) VALUES (?, ?, ?, ?, ?)";
    $params = array($title, $duration, $album_id, $genre_id, $artist_id);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Song added successfully.";
    }

    // bağlantıyı kapatma
    sqlsrv_close($conn);
} else {
    echo "Invalid request method.";
}
?>
