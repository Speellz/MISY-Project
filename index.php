<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Database</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 1rem 0;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            margin: 0;
        }
        nav ul li {
            margin: 0 1rem;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        main {
            padding: 2rem;
        }
        section {
            margin-bottom: 2rem;
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label {
            margin: 0.5rem 0 0.2rem;
        }
        form input {
            padding: 0.5rem;
            margin-bottom: 1rem;
        }
        form button {
            padding: 0.5rem;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        footer {
            text-align: center;
            padding: 0rem;
            background-color: #333;
            color: #fff;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 1rem;
        }

        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #333;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .pagination a.active {
            background-color: #555;
        }

        .pagination a:hover {
            background-color: #777;
        }
    </style>
</head>
<body>
<header>
    <h1>Music Database</h1>
    <nav>
        <ul>
            <li><a href="#view">View Data</a></li>
            <li><a href="#add">Add Data</a></li>
            <li><a href="playlistphp.html">Playlists</a></li>
            <li><a href="songsphp.html">Songs</a></li>
            <li id="login-link" style="display: none;"><a href="login.html">Login</a></li>
            <li id="register-link" style="display: none;"><a href="register.html">Register</a></li>
            <li id="logout-link" style="display;"><a href="logout.php">Logout</a></li>
            <li id="user-info"><?php echo "Welcome, $username | Email: $email"; ?></li>
        </ul>
    </nav>
</header>
<main>
<section id="view">
            <h2>View Data</h2>
            <form id="viewForm">
                <label for="viewType">Select Data to View:</label>
                <select id="viewType" name="viewType">
                    <option value="artists">Artists</option>
                    <option value="albums">Albums</option>
                    <option value="songs">Songs</option>
                    <option value="genres">Genres</option>
                </select>
                <button type="button" onclick="viewData()">View</button>
            </form>
            <div id="viewResult"></div>
        </section>
        <section style="text-align: center;" id="add_data">
            <h2>Add Data</h2>
            <form id="addForm">
                <label for="addType">Select Data to Add:</label>
                <select id="addType" name="addType" onchange="updateFormFields()">
                    <option value="artist">Artist</option><br><br>
                    <option value="album">Album</option><br><br>
                    <option value="song">Song</option><br><br>
                    <option value="genre">Genre</option><br><br>
                </select>
                <div id="addFields"></div>
                <button type="button" onclick="addData()">Add</button>
            </form>
        </section>
</main>
<footer>
        <p>&copy; 2024 Music Database Created by</p>
        <p> CENK KAĞAN ÇAKIR, ASLI AKIN, ARDA YİĞİT EROĞLU</p></p> 
    </footer>
<script>
        function updateFormFields() {
            const addType = document.getElementById('addType').value;
            const addFields = document.getElementById('addFields');
            addFields.innerHTML = '';

            if (addType === 'artist') {
                addFields.innerHTML += '<label for="name">Name:</label><input type="text" id="name" name="name"><label for="bio">Bio:</label><textarea id="bio" name="bio"></textarea><label for="country">Country:</label><input type="text" id="country" name="country">';
            } else if (addType === 'album') {
                addFields.innerHTML += '<label for="title">Title:</label><input type="text" id="title" name="title"><label for="release_date">Release Date:</label><input type="date" id="release_date" name="release_date"><label for="artist_id">Artist ID:</label><input type="number" id="artist_id" name="artist_id">';
            } else if (addType === 'song') {
                addFields.innerHTML += '<label for="title">Title:</label><input type="text" id="title" name="title"><label for="duration">Duration:</label><input type="time" id="duration" name="duration"><label for="album_id">Album ID:</label><input type="number" id="album_id" name="album_id"><label for="genre_id">Genre ID:</label><input type="number" id="genre_id" name="genre_id"><label for="artist_id">Artist ID:</label><input type="number" id="artist_id" name="artist_id">';
            } else if (addType === 'genre') {
                addFields.innerHTML += '<label for="name">Name:</label><input type="text" id="name" name="name">';
            }
        }
    </script>
    <script src="scripts.js"></script>
</body>
</html>
