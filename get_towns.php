<?php
// Connect to database
// $link = mysqli_connect(
//     "echo-web-db.cpos8s20yabb.ap-southeast-2.rds.amazonaws.com",
//     "admin",
//     "00000000",
//     "city"
// ) or die("Cannot connect to DB");

$link = mysqli_connect(
    "127.0.0.1",
    "root",
    "0000",
    "縣市之鄉鎮資料"
) or die("Cannot connect to DB");

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get county parameter
$county = $_GET['locationsName']; // 確保使用正確的 GET 參數名稱

// Perform query
$query = "SELECT locationName FROM 縣市鄉鎮 WHERE locationsName = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $county);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$towns = array();
while ($row = mysqli_fetch_assoc($result)) {
    $towns[] = $row['locationName']; // 確保選擇正確的字段名
}

// 輸出JSON數據
header('Content-Type: application/json');

// 轉換為JSON並輸出
echo json_encode($towns);

// 關閉連接
mysqli_close($link);
?>
