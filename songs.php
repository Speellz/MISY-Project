<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Songs</title>
</head>
<body>
    <h1>Songs</h1>
    <form method="get" action="songs.php">
        <input type="text" name="search" placeholder="Search by title or genre">
        <input type="submit" value="Search">
    </form>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Duration</th>
            <th>Album</th>
            <th>Genre</th>
            <th>Artist</th>
        </tr>
        <?php
        include 'db_connect.php';

        if ($conn === false) {
            die("Connection failed: " . print_r(sqlsrv_errors(), true));
        }

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $sql = "SELECT Songs.title, Songs.duration, Albums.name AS album, Genres.name AS genre, Artists.name AS artist
                FROM Songs
                LEFT JOIN Albums ON Songs.album_id = Albums.album_id
                LEFT JOIN Genres ON Songs.genre_id = Genres.genre_id
                LEFT JOIN Artists ON Songs.artist_id = Artists.artist_id
                WHERE Songs.title LIKE ? OR Genres.name LIKE ?";
        
        $params = array("%$search%", "%$search%");
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die("Error in query execution: " . print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_has_rows($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo "<tr><td>" . $row["title"] . "</td><td>" . $row["duration"]->format('H:i:s') . "</td><td>" . $row["album"] . "</td><td>" . $row["genre"] . "</td><td>" . $row["artist"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found</td></tr>";
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        ?>
    </table>
    <button onclick="location.href='login.html'">Login to Add Songs</button>
</body>
</html>
