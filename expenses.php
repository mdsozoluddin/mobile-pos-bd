<?php
include 'db.php';

// নতুন খরচ যোগ করার লজিক
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $date = date('Y-m-d');

    $sql = "INSERT INTO expenses (title, amount, expense_date) VALUES ('$title', '$amount', '$date')";
    $conn->query($sql);
    header("Location: expenses.php");
    exit();
}

// খরচ তালিকা ফেচ করা
$result = $conn->query("SELECT * FROM expenses ORDER id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile POS - Expense Tracker</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f9; }
        .container { max-width: 700px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, button { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #ffc107; color: #333; font-weight: bold; cursor: pointer; }
        button:hover { background: #e0a800; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #343a40; color: white; }
        a { display: inline-block; margin-top: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h2>Expense Tracker (দৈনিক খরচ খাতা)</h2>
    
    <!-- খরচের ফর্ম -->
    <form method="POST">
        <input type="text" name="title" placeholder="Expense Reason (e.g. Electricity Bill, Tea)" required>
        <input type="number" step="0.01" name="amount" placeholder="Amount (TK)" required>
        <button type="submit">Add Expense</button>
    </form>

    <hr>

    <h3>Expense History</h3>
    <table>
        <tr>
            <th>Date</th>
            <th>Reason</th>
            <th>Amount</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['expense_date']); ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['amount']); ?> TK</td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3" style="text-align:center;">No expense records found.</td></tr>
        <?php endif; ?>
    </table>

    <a href="dashboard.php">&larr; Back to Dashboard</a>
</div>

</body>
</html>
