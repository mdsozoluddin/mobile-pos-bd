<?php
include 'db.php';

$sale_id = $_GET['id'] ?? 0;

// বিক্রয়ের তথ্য ফেচ করা (যদি সেল টেবিল থাকে, অথবা সরাসরি সেশনের মাধ্যমে করা যায়)
// আপাতত আমরা সরাসরি ডেটাবেজ থেকে রসিদ তৈরি করার স্ট্রাকচার দিচ্ছি
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice / Cash Memo</title>
    <style>
        body { font-family: monospace; margin: 0; padding: 20px; background: #fff; color: #000; }
        .invoice-box { max-width: 400px; margin: auto; padding: 15px; border: 1px dashed #333; background: #fff; }
        .center { text-align: center; }
        .flex { display: flex; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border-bottom: 1px dashed #ddd; padding: 8px; text-align: left; font-size: 14px; }
        th { background: #f8f9fa; }
        .total { font-weight: bold; text-align: right; margin-top: 15px; font-size: 16px; }
        .print-btn { display: block; width: 100%; padding: 10px; background: #28a745; color: white; border: none; font-weight: bold; cursor: pointer; margin-top: 20px; border-radius: 4px; }
        @media print {
            .print-btn, a { display: none; }
            body { padding: 0; }
            .invoice-box { border: none; }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="center">
        <h2>Mobile POS BD</h2>
        <p>Retail & Wholesale Management Software<br>Phone: 017XXXXXXXX</p>
        <hr style="border: 0.5px dashed #333;">
    </div>

    <p><strong>Invoice No:</strong> #<?php echo rand(1000, 9999); ?></p>
    <p><strong>Date:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>

    <table>
        <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
        <tr>
            <td>Sample Product</td>
            <td>1</td>
            <td>500 TK</td>
        </tr>
    </table>

    <div class="total">
        Grand Total: 500.00 TK
    </div>

    <button class="print-btn" onclick="window.print()">Print Cash Memo</button>
    <br>
    <a href="sale.php" style="color: #007bff; text-decoration: none; font-family: Arial, sans-serif;">&larr; Back to Sales Counter</a>
</div>

</body>
</html>
