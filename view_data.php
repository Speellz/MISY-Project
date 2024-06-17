<?php
include 'db_connect.php';

$viewType = $_POST['viewType'];
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$pageSize = 10;
$offset = ($page - 1) * $pageSize;

switch ($viewType) {
    case 'artists':
        $dataSql = "SELECT * FROM (
                        SELECT *, ROW_NUMBER() OVER (ORDER BY artist_id) AS row_num
                        FROM Artists
                    ) AS a
                    WHERE row_num > ? AND row_num <= ?";
        $countSql = "SELECT COUNT(*) as total FROM Artists";
        break;
    case 'albums':
        $dataSql = "SELECT * FROM (
                        SELECT *, ROW_NUMBER() OVER (ORDER BY album_id) AS row_num
                        FROM Albums
                    ) AS a
                    WHERE row_num > ? AND row_num <= ?";
        $countSql = "SELECT COUNT(*) as total FROM Albums";
        break;
    case 'songs':
        $dataSql = "SELECT * FROM (
                        SELECT *, ROW_NUMBER() OVER (ORDER BY song_id) AS row_num
                        FROM Songs
                    ) AS a
                    WHERE row_num > ? AND row_num <= ?";
        $countSql = "SELECT COUNT(*) as total FROM Songs";
        break;
    case 'genres':
        $dataSql = "SELECT * FROM (
                        SELECT *, ROW_NUMBER() OVER (ORDER BY genre_id) AS row_num
                        FROM Genres
                    ) AS a
                    WHERE row_num > ? AND row_num <= ?";
        $countSql = "SELECT COUNT(*) as total FROM Genres";
        break;
    default:
        echo json_encode(array("error" => "Invalid view type"));
        exit;
}

$params = array($offset, $offset + $pageSize);
$dataStmt = sqlsrv_query($conn, $dataSql, $params);
$countStmt = sqlsrv_query($conn, $countSql);

if ($dataStmt === false || $countStmt === false) {
    echo json_encode(array("error" => sqlsrv_errors()));
    exit;
}

$data = array();
while ($row = sqlsrv_fetch_array($dataStmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}


$totalCount = sqlsrv_fetch_array($countStmt, SQLSRV_FETCH_ASSOC)['total'];

// json encoding kontrolü
$jsonData = json_encode(array(
    'data' => $data,
    'totalCount' => $totalCount
));

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(array("error" => "JSON encoding error: " . json_last_error_msg()));
    exit;
}

echo $jsonData;

sqlsrv_free_stmt($dataStmt);
sqlsrv_free_stmt($countStmt);
sqlsrv_close($conn);
?>
