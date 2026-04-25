<?php
require 'db.php'; // Connect to database

// If the user clicks the login button...
if (isset($_POST['login'])) {
    $ewu_id = $_POST['ewu_id'];
    $password = $_POST['password'];

    // Search the database for this user
    $query = "SELECT * FROM users WHERE ewu_id='$ewu_id' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Save user details in the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];
        
        // Send them to the dashboard
        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "<p style='color:red;'>Wrong ID or Password!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>EWU Lost & Found - Login</title></head>
<body>
    <h2>EWU Lost & Found Portal</h2>
    <form method="POST" action="">
        <label>EWU ID (e.g., 2024-1-60-001 or admin-01):</label><br>
        <input type="text" name="ewu_id" required><br><br>
        
        <label>Password (Hint: 1234):</label><br>
        <input type="password" name="password" required><br><br>
        
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>