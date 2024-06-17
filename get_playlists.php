<?php
include 'db_connect.php';

$sql = "SELECT * FROM playlists";

$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    echo "Error" . sqlsrv_errors();
    exit;
}

$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

echo json_encode($data);

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
