<?php
include 'db.php';

// ১. মোট প্রোডাক্ট সংখ্যা বের করা
$product_count_query = $conn->query("SELECT COUNT(*) as total FROM products");
$product_count = $product_count_query->fetch_assoc()['total'];

// ২. মোট স্টক পরিমাণ বের করা
$total_stock_query = $conn->query("SELECT SUM(stock) as total_stock FROM products");
$total_stock = $total_stock_query->fetch_assoc()['total_stock'] ?? 0;

// ৩. মোট ইনভেন্টরি বা মূল্যের পরিমাণ বের করা (Stock * Price)
$total_value_query = $conn->query("SELECT SUM(stock * price) as total_value FROM products");
$total_value = $total_value_query->fetch_assoc()['total_value'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile POS - Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f9; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .cards { display: flex; gap: 20px; margin-top: 20px; }
        .card { flex: 1; background: #007bff; color: white; padding: 20px; border-radius: 6px; text-align: center; }
        .card.green { background: #28a745; }
        .card.orange { background: #ffc107; color: #333; }
        .card h3 { margin: 0; font-size: 24px; }
        .card p { margin: 10px 0 0 0; font-size: 16px; }
        .menu { margin-top: 30px; display: flex; gap: 10px; }
        .menu a { padding: 10px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; }
        .menu a:hover { background: #5a6268; }
    </style>
</head>
<body>

<div class="container">
    <h2>Mobile POS Dashboard</h2>
    <p>Welcome to your inventory and sales dashboard overview.</p>

    <!-- সামারি কার্ডসমূহ -->
    <div class="cards">
        <div class="card">
            <h3><?php echo $product_count; ?></h3>
            <p>Total Products</p>
        </div>
        <div class="card green">
            <h3><?php echo $total_stock; ?> Pcs</h3>
            <p>Total Stock Quantity</p>
        </div>
        <div class="card orange">
            <h3><?php echo number_format($total_value, 2); ?> TK</h3>
            <p>Total Stock Value</p>
        </div>
    </div>

    <!-- ন্যাভিগেশন মেনু -->
    <div class="menu">
        <a href="index.php">Manage Inventory</a>
        <a href="sale.php">Sales Counter</a>
    </div>
</div>

</body>
</html>

<?php
include 'db.php';
session_start();

// যদি লগইন করা না থাকে, তবে লগইন পেজে রিডাইরেক্ট করবে
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// ১. মোট প্রোডাক্ট সংখ্যা বের করা
$product_count_query = $conn->query("SELECT COUNT(*) as total FROM products");
$product_count = $product_count_query->fetch_assoc()['total'];

// ২. মোট স্টক পরিমাণ বের করা
$total_stock_query = $conn->query("SELECT SUM(stock) as total_stock FROM products");
$total_stock = $total_stock_query->fetch_assoc()['total_stock'] ?? 0;

// ৩. মোট ইনভেন্টরি বা মূল্যের পরিমাণ বের করা (Stock * Price)
$total_value_query = $conn->query("SELECT SUM(stock * price) as total_value FROM products");
$total_value = $total_value_query->fetch_assoc()['total_value'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile POS - Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f9; }
        .navbar { background: #343a40; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h2 { margin: 0; font-size: 20px; }
        .nav-links a { color: white; text-decoration: none; margin-left: 15px; padding: 8px 12px; background: #495057; border-radius: 4px; font-size: 14px; }
        .nav-links a:hover { background: #007bff; }
        .container { max-width: 1000px; margin: 30px auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .cards { display: flex; gap: 20px; margin-top: 20px; }
        .card { flex: 1; background: #007bff; color: white; padding: 20px; border-radius: 6px; text-align: center; }
        .card.green { background: #28a745; }
        .card.orange { background: #ffc107; color: #333; }
        .card h3 { margin: 0; font-size: 24px; }
        .card p { margin: 10px 0 0 0; font-size: 16px; }
    </style>
</head>
<body>

<!-- ন্যাভিগেশন মেনু বা হেডার -->
<div class="navbar">
    <h2>Mobile POS BD (Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>)</h2>
    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="index.php">Inventory</a>
        <a href="sale.php">POS Sale</a>
        <a href="customers.php">Customers Due</a>
        <a href="expenses.php">Expenses</a>
        <a href="reports.php">Reports</a>
        <a href="logout.php" style="background: #dc3545;">Logout</a>
    </div>
</div>

<div class="container">
    <h2>System Overview Dashboard</h2>
    <p>Here is the live summary of your mobile retail and inventory management system.</p>

    <!-- সামারি কার্ডসমূহ -->
    <div class="cards">
        <div class="card">
            <h3><?php echo $product_count; ?></h3>
            <p>Total Products</p>
        </div>
        <div class="card green">
            <h3><?php echo $total_stock; ?> Pcs</h3>
            <p>Total Stock Quantity</p>
        </div>
        <div class="card orange">
            <h3><?php echo number_format($total_value, 2); ?> TK</h3>
            <p>Total Stock Value</p>
        </div>
    </div>
</div>

</body>
</html>
