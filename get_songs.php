<?php
include 'db_connect.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT TOP 25 * FROM Songs";

if ($search) {
    $sql = "SELECT TOP 25 * FROM Songs WHERE Title LIKE ?";
    $params = array("%$search%");
    $stmt = sqlsrv_query($conn, $sql, $params);
} else {
    $stmt = sqlsrv_query($conn, $sql);
}

if ($stmt === false) {
    echo json_encode(['error' => sqlsrv_errors()]);
    exit;
}

$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

if (empty($data)) {
    echo json_encode(['error' => 'No data found']);
} else {
    echo json_encode($data);
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
