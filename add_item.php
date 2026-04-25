<?php
require 'db.php';

// Security check: Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// If they click the submit button...
if (isset($_POST['submit_item'])) {
    $item_name = $_POST['item_name'];
    $location = $_POST['location'];
    $user_id = $_SESSION['user_id']; // The ID of the person logged in

    // ---- HANDLE CREATE (CRUD) ----
    $sql = "INSERT INTO items (item_name, location, status, reported_by) 
            VALUES ('$item_name', '$location', 'Lost', $user_id)";
            
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php"); // Send back to dashboard on success
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Report Lost Item</title></head>
<body>
    <h2>Report a Lost Item</h2>
    <form method="POST" action="">
        <label>What did you lose?</label><br>
        <input type="text" name="item_name" required><br><br>
        
        <label>Where in EWU did you lose it? (e.g., Library, Lift 3)</label><br>
        <input type="text" name="location" required><br><br>
        
        <button type="submit" name="submit_item">Submit Report</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>