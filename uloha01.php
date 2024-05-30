<?php
include 'connect.php'; // Assuming connect.php contains the connection details

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1>požiadavka 01</h1>";
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo implode(" | ", $row) . "<br>";
    }
}

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo implode(" | ", $row) . "<br>";
    }
}

$sql = "SELECT * FROM suppliers";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo implode(" | ", $row) . "<br>";
    }
}

echo "<h1>požiadavka 02</h1>";
$sql = "SELECT * FROM customers ORDER BY Country, ContactName";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo implode(" | ", $row) . "<br>";
    }
}

echo "<h1>požiadavka 03</h1>";
$sql = "SELECT * FROM orders ORDER BY OrderDate";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo implode(" | ", $row) . "<br>";
    }
}

echo "<h1>požiadavka 04</h1>";
$sql = "SELECT COUNT(*) as count FROM orders WHERE YEAR(ShippedDate) = 1997";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Počet objednávok v roku 1997: " . $row['count'] . "<br>";
    }
}

echo "<h1>požiadavka 05</h1>";
$sql = "SELECT FirstName, LastName FROM employees WHERE Title LIKE '%Manager%' ORDER BY LastName";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo $row['FirstName']. " " .$row['LastName'] . "<br>";
    }
}

echo "<h1>požiadavka 06</h1>";
$sql = "SELECT * FROM orders WHERE OrderDate = '1997-05-19'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo implode(" | ", $row) . "<br>";
    }
}

$conn->close();
?>
