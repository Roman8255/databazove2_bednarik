<?php
include 'connect.php'; // Assuming connect.php contains the connection details

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function displayQueryResults($conn, $query) {
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        while ($fieldInfo = $result->fetch_field()) {
            echo "<th>{$fieldInfo->name}</th>";
        }
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>$cell</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
}

echo "<h1>požiadavka 01</h1>";
echo "<h3>Zákazníci</h3>";
$sql = "SELECT * FROM customers";
displayQueryResults($conn, $sql);

echo "<h3>Objednávky</h3>";
$sql = "SELECT * FROM orders";
displayQueryResults($conn, $sql);

echo "<h3>Dodávatelia</h3>";
$sql = "SELECT * FROM suppliers";
displayQueryResults($conn, $sql);

echo "<h1>požiadavka 02</h1>";
$sql = "SELECT * FROM customers ORDER BY Country, ContactName";
displayQueryResults($conn, $sql);

echo "<h1>požiadavka 03</h1>";
$sql = "SELECT * FROM orders ORDER BY OrderDate";
displayQueryResults($conn, $sql);

echo "<h1>požiadavka 04</h1>";
$sql = "SELECT COUNT(*) as count FROM orders WHERE YEAR(ShippedDate) = 1995";
displayQueryResults($conn, $sql);

echo "<h1>požiadavka 05</h1>";
$sql = "SELECT FirstName, LastName FROM employees WHERE Title LIKE '%Manager%' ORDER BY LastName";
displayQueryResults($conn, $sql);

echo "<h1>požiadavka 06</h1>";
$sql = "SELECT * FROM orders WHERE OrderDate = '1995-09-28'";
displayQueryResults($conn, $sql);

$conn->close();
?>
