<?php
include 'db.php';

// পণ্য বিক্রয় করার লজিক
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $sold_qty = $_POST['quantity'];

    // বর্তমান স্টক চেক করা
    $result = $conn->query("SELECT * FROM products WHERE id = $product_id");
    $product = $result->fetch_assoc();

    if ($product && $product['stock'] >= $sold_qty) {
        // নতুন স্টক হিসাব করা
        $new_stock = $product['stock'] - $sold_qty;
        
        // স্টক আপডেট করা
        $conn->query("UPDATE products SET stock = $new_stock WHERE id = $product_id");
        
        $total_price = $sold_qty * $product['price'];
        $message = "Sale Successful! Total Price: " . $total_price . " TK";
    } else {
        $message = "Error: Insufficient stock!";
    }
}

// প্রোডাক্ট লিস্ট ফেচ করা (ডراপডাউনের জন্য)
$products = $conn->query("SELECT * FROM products WHERE stock > 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile POS - Sales Counter</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f9; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        select, input, button { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #007bff; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background: #0056b3; }
        .msg { padding: 10px; margin-bottom: 15px; background: #d4edda; color: #155724; border-radius: 4px; }
        a { display: inline-block; margin-top: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h2>POS - Product Sale Counter</h2>
    
    <?php if($message != ""): ?>
        <div class="msg"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- বিক্রয় ফর্ম -->
    <form method="POST">
        <label>Select Product:</label>
        <select name="product_id" required>
            <option value="">-- Choose Product --</option>
            <?php while($row = $products->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo htmlspecialchars($row['name']); ?> (Stock: <?php echo $row['stock']; ?> | Price: <?php echo $row['price']; ?> TK)
                </option>
            <?php endwhile; ?>
        </select>

        <label>Quantity:</label>
        <input type="number" name="quantity" min="1" placeholder="Enter quantity" required>

        <button type="submit">Complete Sale & Update Stock</button>
    </form>

    <a href="index.php">&larr; Back to Inventory / Add Product</a>
</div>

</body>
</html>
