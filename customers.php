<?php
include 'db.php';

// নতুন কাস্টমার যোগ করার লজিক
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $due = $_POST['due'] ?? 0;

    $sql = "INSERT INTO customers (name, phone, due) VALUES ('$name', '$phone', '$due')";
    $conn->query($sql);
    header("Location: customers.php");
    exit();
}

// কাস্টমার লিস্ট ফেচ করা (প্রয়োজনে টেবিল আগে তৈরি করে নিতে হবে)
$result = $conn->query("SELECT * FROM customers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile POS - Customer Due Ledger</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f9; }
        .container { max-width: 700px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, button { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #dc3545; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background: #c82333; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #343a40; color: white; }
        a { display: inline-block; margin-top: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h2>Customer Due Ledger (বাকির খাতা)</h2>
    
    <!-- কাস্টমার ফর্ম -->
    <form method="POST">
        <input type="text" name="name" placeholder="Customer Name" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="number" step="0.01" name="due" placeholder="Initial Due Amount (TK)" value="0">
        <button type="submit">Add Customer / Due</button>
    </form>

    <hr>

    <h3>Customer List & Dues</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Due Amount</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['due']); ?> TK</td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3" style="text-align:center;">No customer records found.</td></tr>
        <?php endif; ?>
    </table>

    <a href="dashboard.php">&larr; Back to Dashboard</a>
</div>

</body>
</html>
