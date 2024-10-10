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

// Perform query
$query = "SELECT DISTINCT locationsName FROM 縣市鄉鎮";
$result = mysqli_query($link, $query);

$counties = array();
while ($row = mysqli_fetch_assoc($result)) {
    $counties[] = $row['locationsName'];
}

// 输出JSON数据
header('Content-Type: application/json');

// Convert to JSON and output
echo json_encode($counties);

// Close connection
mysqli_close($link);
?>
