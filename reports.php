<?php
include 'db.php';

// ১. মোট প্রোডাক্ট ও স্টক ভ্যালু রিপোর্ট
$total_products = $conn->query("SELECT COUNT(*) as cnt FROM products")->fetch_assoc()['cnt'];
$total_stock_value = $conn->query("SELECT SUM(stock * price) as val FROM products")->fetch_assoc()['val'] ?? 0;

// ২. মোট বাকি (Total Due) রিপোর্ট
$total_due = $conn->query("SELECT SUM(due) as total_due FROM customers")->fetch_assoc()['total_due'] ?? 0;

// ৩. মোট খরচ (Total Expenses) রিপোর্ট
$total_expense = $conn->query("SELECT SUM(amount) as total_exp FROM expenses")->fetch_assoc()['total_exp'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile POS - Business Reports</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f9; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
        .report-card { background: #e9ecef; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
        a { display: inline-block; margin-top: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h2>Business Summary & Reports (ব্যবসায়িক রিপোর্ট)</h2>
    
    <table>
        <tr>
            <th>Report Parameter</th>
            <th>Value / Amount</th>
        </tr>
        <tr>
            <td>Total Unique Products in Inventory</td>
            <td><strong><?php echo $total_products; ?> Items</strong></td>
        </tr>
        <tr>
            <td>Total Inventory Stock Value (Asset)</td>
            <td><strong><?php echo number_format($total_stock_value, 2); ?> TK</strong></td>
        </tr>
        <tr>
            <td>Total Customer Dues (বাকির পরিমাণ)</td>
            <td><strong style="color: red;"><?php echo number_format($total_due, 2); ?> TK</strong></td>
        </tr>
        <tr>
            <td>Total Operating Expenses (মোট খরচ)</td>
            <td><strong style="color: orange;"><?php echo number_format($total_expense, 2); ?> TK</strong></td>
        </tr>
    </table>

    <a href="dashboard.php">&larr; Back to Dashboard</a>
</div>

</body>
</html>
