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
    SELECT SUM(`order details`.Quantity * `order details`.UnitPrice) as Total_Income_1994 
    FROM orders
    JOIN `order details` ON orders.OrderID = `order details`.OrderID
    WHERE YEAR(orders.OrderDate) = 1994
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 02</h1>";
$query = "
    SELECT customers.CompanyName, SUM(`order details`.Quantity * `order details`.UnitPrice) as TotalPaid 
    FROM orders
    JOIN `order details` ON orders.OrderID = `order details`.OrderID
    JOIN customers ON orders.CustomerID = customers.CustomerID
    GROUP BY customers.CustomerID
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 03</h1>";
$query = "
    SELECT products.ProductName, SUM(`order details`.Quantity) as TotalSold 
    FROM `order details`
    JOIN products ON `order details`.ProductID = products.ProductID
    GROUP BY `order details`.ProductID
    ORDER BY TotalSold DESC
    LIMIT 10
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 04</h1>";
$query = "
    SELECT customers.CompanyName, SUM(`order details`.Quantity * `order details`.UnitPrice) as TotalRevenue 
    FROM orders
    JOIN `order details` ON orders.OrderID = `order details`.OrderID
    JOIN customers ON orders.CustomerID = customers.CustomerID
    GROUP BY customers.CustomerID
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 05</h1>";
$query = "
    SELECT customers.CompanyName, SUM(`order details`.Quantity * `order details`.UnitPrice) as TotalPaid 
    FROM orders
    JOIN `order details` ON orders.OrderID = `order details`.OrderID
    JOIN customers ON orders.CustomerID = customers.CustomerID
    WHERE customers.Country = 'UK'
    GROUP BY customers.CustomerID
    HAVING TotalPaid > 1000
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 06</h1>";
$query = "
    SELECT customers.CustomerID, customers.CompanyName, customers.Country,
           SUM(`order details`.Quantity * `order details`.UnitPrice) as TotalPaid,
           SUM(CASE WHEN YEAR(orders.OrderDate) = 1995 THEN `order details`.Quantity * `order details`.UnitPrice ELSE 0 END) as Paid_In_1995
    FROM orders
    JOIN `order details` ON orders.OrderID = `order details`.OrderID
    JOIN customers ON orders.CustomerID = customers.CustomerID
    GROUP BY customers.CustomerID
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 07</h1>";
$query = "
    SELECT COUNT(DISTINCT CustomerID) as TotalCustomers FROM orders
";
displayQueryResults($conn, $query);

echo "<h1>požiadavka 08</h1>";
$query = "
    SELECT COUNT(DISTINCT CustomerID) as TotalCustomers1997 
    FROM orders 
    WHERE YEAR(OrderDate) = 1997
";
displayQueryResults($conn, $query);

$conn->close();
?>
