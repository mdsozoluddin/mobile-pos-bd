<?php
include 'db.php';

// নতুন প্রোডাক্ট সেভ করার কোড
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (name, stock, price) VALUES ('$name', '$stock', '$price')";
    $conn->query($sql);
    header("Location: index.php");
    exit();
}

// প্রোডাক্ট লিস্ট ফেচ করা
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile POS BD - Inventory</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f9; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, button { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #28a745; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background: #218838; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
    </style>
</head>
<body>

<div class="container">
    <h2>Mobile POS - Product Inventory</h2>
    
    <!-- নতুন প্রোডাক্ট ফর্ম -->
    <form method="POST">
        <input type="text" name="name" placeholder="Product Name (e.g. Charger, Display)" required>
        <input type="number" name="stock" placeholder="Stock Quantity" required>
        <input type="number" step="0.01" name="price" placeholder="Selling Price" required>
        <button type="submit">Add Product</button>
    </form>

    <hr>

    <h3>Product List</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Stock</th>
            <th>Price</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['stock']); ?></td>
            <td><?php echo htmlspecialchars($row['price']); ?> TK</td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
