<?php
include 'db.php';

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // পাসওয়ার্ড সিকিউর বা হ্যাশ করার জন্য

    // ইউজার আগে থেকেই আছে কি না চেক করা
    $check = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($check->num_rows > 0) {
        $message = "Username already exists!";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            $message = "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mobile POS - Register</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 100px auto; background: #f4f4f9; max-width: 400px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, button { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #28a745; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background: #218838; }
        .msg { margin-bottom: 10px; font-size: 14px; color: green; }
    </style>
</head>
<body>

<h2>Create Admin / User Account</h2>
<?php if($message != ""): ?>
    <div class="msg"><?php echo $message; ?></div>
<?php endif; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Choose Username" required>
    <input type="password" name="password" placeholder="Choose Password" required>
    <button type="submit">Register</button>
</form>

<p style="text-align: center; margin-top: 15px;"><a href="login.php" style="color: #007bff; text-decoration: none;">Already have an account? Login</a></p>

</body>
</html>
