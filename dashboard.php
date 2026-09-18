<?php
include 'db.php';
session_start();

// যদি লগইন করা না থাকে, তবে লগইন পেজে রিডাইরেক্ট করবে
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// ডেটাবেজ থেকে ডাইনামিক ডাটা সংগ্রহ (যেমন: মোট প্রোডাক্ট, কাস্টমার, খরচ ইত্যাদি)
$product_count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'] ?? 0;
$total_stock = $conn->query("SELECT SUM(stock) as total_stock FROM products")->fetch_assoc()['total_stock'] ?? 0;
$total_value = $conn->query("SELECT SUM(stock * price) as total_value FROM products")->fetch_assoc()['total_value'] ?? 0;
$customer_count = $conn->query("SELECT COUNT(*) as total FROM customers")->fetch_assoc()['total'] ?? 0;
$total_expense = $conn->query("SELECT SUM(amount) as total FROM expenses")->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile POS BD - Super Admin Dashboard</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f4f6f9; display: flex; height: 100vh; overflow: hidden; }

        /* Sidebar Styling */
        .sidebar { width: 260px; background: #0f172a; color: white; display: flex; flex-direction: column; justify-content: space-between; height: 100%; }
        .sidebar-brand { padding: 20px; font-size: 18px; font-weight: bold; background: #1e293b; border-bottom: 1px solid #334155; }
        .sidebar-brand span { font-size: 12px; color: #94a3b8; display: block; margin-top: 3px; }
        .sidebar-menu { list-style: none; padding: 15px 0; overflow-y: auto; flex: 1; }
        .sidebar-menu li a { display: block; padding: 12px 20px; color: #cbd5e1; text-decoration: none; font-size: 14px; transition: 0.3s; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: #1e293b; color: white; border-left: 4px solid #3b82f6; }

        /* Main Content Wrapper */
        .main-content { flex: 1; display: flex; flex-direction: column; height: 100%; overflow: hidden; }

        /* Top Navbar */
        .navbar { background: white; padding: 15px 30px; display: flex; justify-content: flex-end; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); gap: 20px; }
        .admin-profile { background: #3b82f6; color: white; padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 600; }

        /* Dashboard Body */
        .dashboard-body { padding: 30px; overflow-y: auto; flex: 1; }
        .welcome-banner { background: linear-gradient(135deg, #1e40af, #3b82f6); color: white; padding: 25px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .welcome-banner h2 { font-size: 24px; margin-bottom: 8px; }
        .welcome-banner p { font-size: 14px; opacity: 0.9; }

        /* Metric Cards Grid */
        .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; position: relative; }
        .card h3 { font-size: 28px; color: #1e293b; margin-bottom: 5px; }
        .card p { color: #64748b; font-size: 14px; font-weight: 500; }

        /* Footer */
        .footer { text-align: center; padding: 15px; font-size: 13px; color: #64748b; background: white; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>

    <!-- Sidebar Menu -->
    <div class="sidebar">
        <div>
            <div class="sidebar-brand">
                Mobile POS BD
                <span>BUSINESS MANAGEMENT</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="index.php">Inventory / Products</a></li>
                <li><a href="sale.php">POS Sale Counter</a></li>
                <li><a href="customers.php">Customer Due List</a></li>
                <li><a href="expenses.php">Expense Tracker</a></li>
                <li><a href="reports.php">Business Reports</a></li>
                <li><a href="invoice.php">Print Invoice</a></li>
                <li><a href="register.php">Add New User</a></li>
            </ul>
        </div>
        <div style="padding: 15px 20px; border-top: 1px solid #334155;">
            <a href="logout.php" style="color: #ef4444; text-decoration: none; font-size: 14px; font-weight: bold;">Logout</a>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="navbar">
            <div class="admin-profile">
                M &nbsp; <?php echo htmlspecialchars($_SESSION['username']); ?> (Super Admin)
            </div>
        </div>

        <!-- Dashboard Body Content -->
        <div class="dashboard-body">
            <div class="welcome-banner">
                <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                <p>Monitor sales, inventory stock, customer dues, expenses, and overall business performance from one clean, responsive dashboard[cite: 2].</p>
            </div>

            <!-- Dynamic Summary Cards -->
            <div class="cards-grid">
                <div class="card">
                    <h3><?php echo $product_count; ?></h3>
                    <p>Total Products (Items)</p>
                </div>
                <div class="card">
                    <h3><?php echo $total_stock; ?> Pcs</h3>
                    <p>Total Stock Quantity</p>
                </div>
                <div class="card">
                    <h3><?php echo number_format($total_value, 2); ?> TK</h3>
                    <p>Total Inventory Value</p>
                </div>
                <div class="card">
                    <h3><?php echo $customer_count; ?></h3>
                    <p>Total Customers</p>
                </div>
                <div class="card">
                    <h3><?php echo number_format($total_expense, 2); ?> TK</h3>
                    <p>Total Operational Expenses</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            Copyright &copy; 2026 Mobile POS BD. All rights reserved[cite: 2].
        </div>
    </div>

</body>
</html>
