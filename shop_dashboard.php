<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// রিটেইলার দোকানের ডাইনামিক ডাটা
$product_count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'] ?? 0;
$total_stock = $conn->query("SELECT SUM(stock) as total_stock FROM products")->fetch_assoc()['total_stock'] ?? 0;
$total_due = $conn->query("SELECT SUM(due) as total_due FROM customers")->fetch_assoc()['total_due'] ?? 0;
$total_expense = $conn->query("SELECT SUM(amount) as total_exp FROM expenses")->fetch_assoc()['total_exp'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Retail Shop Dashboard - Mobile POS BD</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f8fafc; display: flex; height: 100vh; overflow: hidden; }

        /* Shop Sidebar */
        .sidebar { width: 260px; background: #047857; color: white; display: flex; flex-direction: column; justify-content: space-between; height: 100%; }
        .sidebar-brand { padding: 20px; font-size: 18px; font-weight: bold; background: #065f46; border-bottom: 1px solid #047857; }
        .sidebar-brand span { font-size: 12px; color: #a7f3d0; display: block; margin-top: 3px; }
        .sidebar-menu { list-style: none; padding: 15px 0; overflow-y: auto; flex: 1; }
        .sidebar-menu li a { display: block; padding: 12px 20px; color: #ecfdf5; text-decoration: none; font-size: 14px; transition: 0.3s; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: #065f46; color: white; border-left: 4px solid #fbbf24; }

        /* Main Content */
        .main-content { flex: 1; display: flex; flex-direction: column; height: 100%; overflow: hidden; }
        .navbar { background: white; padding: 15px 30px; display: flex; justify-content: flex-end; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .shop-profile { background: #047857; color: white; padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 600; }

        /* Dashboard Body */
        .dashboard-body { padding: 30px; overflow-y: auto; flex: 1; }
        .welcome-banner { background: linear-gradient(135deg, #065f46, #047857); color: white; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .welcome-banner h2 { font-size: 24px; margin-bottom: 8px; }
        .welcome-banner p { font-size: 14px; opacity: 0.9; }

        /* Cards Grid */
        .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .card h3 { font-size: 28px; color: #1e293b; margin-bottom: 5px; }
        .card p { color: #64748b; font-size: 14px; font-weight: 500; }
        .footer { text-align: center; padding: 15px; font-size: 13px; color: #64748b; background: white; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>

    <!-- Shop Sidebar Menu -->
    <div class="sidebar">
        <div>
            <div class="sidebar-brand">
                Shop Portal
                <span>RETAIL MANAGEMENT</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="shop_dashboard.php" class="active">Shop Dashboard</a></li>
                <li><a href="sale.php">POS Counter (Sell)</a></li>
                <li><a href="index.php">Manage Products</a></li>
                <li><a href="customers.php">Customer Dues (বাকি খাতা)</a></li>
                <li><a href="expenses.php">Daily Expenses</a></li>
                <li><a href="reports.php">Business Reports</a></li>
                <li><a href="invoice.php">Print Cash Memo</a></li>
            </ul>
        </div>
        <div style="padding: 15px 20px; border-top: 1px solid #065f46;">
            <a href="logout.php" style="color: #fca5a5; text-decoration: none; font-size: 14px; font-weight: bold;">Logout</a>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="navbar">
            <div class="shop-profile">
                🏪 Shop User: <?php echo htmlspecialchars($_SESSION['username']); ?>
            </div>
        </div>

        <div class="dashboard-body">
            <div class="welcome-banner">
                <h2>Welcome to Your Shop, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                <p>Manage your daily mobile sales, inventory stock levels, customer dues, and business expenses instantly.</p>
            </div>

            <!-- Shop Metrics Cards -->
            <div class="cards-grid">
                <div class="card">
                    <h3><?php echo $product_count; ?></h3>
                    <p>Total Products</p>
                </div>
                <div class="card">
                    <h3><?php echo $total_stock; ?> Pcs</h3>
                    <p>Available Stock Qty</p>
                </div>
                <div class="card">
                    <h3><?php echo number_format($total_due, 2); ?> TK</h3>
                    <p>Total Customer Dues (বাকি)</p>
                </div>
                <div class="card">
                    <h3><?php echo number_format($total_expense, 2); ?> TK</h3>
                    <p>Total Store Expenses</p>
                </div>
            </div>
        </div>

        <div class="footer">
            Copyright &copy; 2026 Mobile POS BD. Retail Management Panel.
        </div>
    </div>

</body>
</html>
