<?php
// Connect to database
$link = mysqli_connect(
    "127.0.0.1",
    "root",
    "0000",
    "_merge_data"
) or die("Cannot connect to DB");

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get parameters (sanitize and validate them)
$county = isset($_GET['locationsName']) ? mysqli_real_escape_string($link, $_GET['locationsName']) : '';
$town = isset($_GET['locationName']) ? mysqli_real_escape_string($link, $_GET['locationName']) : '';
$dataTime = isset($_GET['dataTime']) ? $_GET['dataTime'] : '';

// Calculate time range
$startDateTime = date('Y-m-d H:i:s', strtotime($dataTime . ' -1 hour'));
$endDateTime = date('Y-m-d H:i:s', strtotime($dataTime . ' +23 hours'));

// Perform query
$query = "SELECT * FROM `{$county}_{$town}`
          WHERE dataTime BETWEEN ? AND ?
          ORDER BY dataTime";
          
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "ss", $startDateTime, $endDateTime);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch data
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Output JSON data
header('Content-Type: application/json');

// Convert to JSON and output
echo json_encode($data);

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($link);
?>
