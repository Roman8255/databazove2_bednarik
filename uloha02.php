<?php
include 'connect.php'; 

$conn = new mysqli($servername, $username, $password, $dbname);

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
$query = "
    SELECT orders.OrderID, orders.CustomerID, orders.EmployeeID, orders.OrderDate, customers.CompanyName
    FROM orders
    JOIN customers ON orders.CustomerID = customers.CustomerID
    WHERE YEAR(orders.OrderDate) = 1996
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 02</h1>";
$query = "
    SELECT employees.City, 
           COUNT(DISTINCT employees.EmployeeID) AS EmployeeCount, 
           COUNT(DISTINCT customers.CustomerID) AS CustomerCount
    FROM employees
    JOIN customers ON employees.City = customers.City
    GROUP BY employees.City
    HAVING EmployeeCount > 0
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 03</h1>";
$query = "
    SELECT customers.City, 
           COUNT(DISTINCT employees.EmployeeID) AS EmployeeCount, 
           COUNT(DISTINCT customers.CustomerID) AS CustomerCount
    FROM customers
    LEFT JOIN employees ON customers.City = employees.City
    GROUP BY customers.City
    HAVING CustomerCount > 0
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 04</h1>";
$query = "
    SELECT city,
           COUNT(DISTINCT EmployeeID) AS EmployeeCount,
           COUNT(DISTINCT CustomerID) AS CustomerCount
    FROM (
        SELECT City, EmployeeID, NULL AS CustomerID
        FROM employees
        UNION
        SELECT City, NULL AS EmployeeID, CustomerID
        FROM customers
    ) AS combined
    GROUP BY City
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 05</h1>";
?>
<form method="post">
  <label for="shipDate">Zadaj dátum:</label>
  <input type="date" id="shipDate" name="shipDate">
  <button type="submit">Potvrdiť</button>
</form>
<?php

$shipDate = isset($_POST['shipDate']) ? $_POST['shipDate'] : '';

$query = "
    SELECT orders.OrderID, CONCAT(employees.FirstName, ' ', employees.LastName) AS EmployeeName
    FROM orders
    JOIN employees ON orders.EmployeeID = employees.EmployeeID
    WHERE orders.ShippedDate > '$shipDate'
";

displayQueryResults($conn, $query);

echo "<h1>požiadavka 06</h1>";
$query = "
    SELECT ProductID, SUM(Quantity) AS TotalQuantity
    FROM `order details`
    GROUP BY ProductID
    HAVING TotalQuantity < 200
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 07</h1>";
$query = "
    SELECT CustomerID, COUNT(OrderID) AS OrderCount
    FROM orders
    WHERE OrderDate > '1996-12-31'
    GROUP BY CustomerID
    HAVING OrderCount > 15
";
displayQueryResults($conn, $query);

$conn->close();
?>
