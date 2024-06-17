<?php
include 'db_connect.php';

$addType = $_POST['addType'];

switch ($addType) {
    case 'artist':
        $name = $_POST['name'];
        $bio = $_POST['bio'];
        $country = $_POST['country'];
        $sql = "INSERT INTO Artists (name, bio, country) VALUES (?, ?, ?)";
        $params = array($name, $bio, $country);
        break;
    case 'album':
        $title = $_POST['title'];
        $release_date = $_POST['release_date'];
        $artist_id = $_POST['artist_id'];
        $sql = "INSERT INTO Albums (title, release_date, artist_id) VALUES (?, ?, ?)";
        $params = array($title, $release_date, $artist_id);
        break;
    case 'song':
        $title = $_POST['title'];
        $duration = $_POST['duration'];
        $album_id = $_POST['album_id'];
        $genre_id = $_POST['genre_id'];
        $artist_id = $_POST['artist_id'];
        $sql = "INSERT INTO Songs (title, duration, album_id, genre_id, artist_id) VALUES (?, ?, ?, ?, ?)";
        $params = array($title, $duration, $album_id, $genre_id, $artist_id);
        break;
    case 'genre':
        $name = $_POST['name'];
        $sql = "INSERT INTO Genres (name) VALUES (?)";
        $params = array($name);
        break;
    default:
        echo "Invalid add type";
        exit;
}

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    echo "Data added successfully";
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
