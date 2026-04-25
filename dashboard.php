<?php
require 'db.php';

// If someone tries to visit this page without logging in, send them back to login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// ---- HANDLE DELETE (CRUD) ----
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $conn->query("DELETE FROM items WHERE item_id=$delete_id");
    header("Location: dashboard.php"); // Refresh page
}

// ---- HANDLE UPDATE (CRUD) ----
if (isset($_GET['found'])) {
    $found_id = $_GET['found'];
    $conn->query("UPDATE items SET status='Found' WHERE item_id=$found_id");
    header("Location: dashboard.php"); // Refresh page
}
?>

<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
    <h2>Welcome, <?php echo $_SESSION['name']; ?> (<?php echo $_SESSION['role']; ?>)</h2>
    
    <a href="add_item.php"><button>Report a Lost Item</button></a>
    <a href="logout.php" style="float:right;">Logout</a>
    <hr>

    <h3>All Lost & Found Items</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Item Name</th>
            <th>Location</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        
        <?php
        // ---- HANDLE READ (CRUD) ----
        // Get all items from the database
        $items = $conn->query("SELECT * FROM items");
        
        while ($row = $items->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['item_name'] . "</td>";
            echo "<td>" . $row['location'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            
            echo "<td>";
            // ACCESS CONTROL: Only Admins can Update status to 'Found'
            if ($_SESSION['role'] == 'Admin' && $row['status'] == 'Lost') {
                echo "<a href='dashboard.php?found=" . $row['item_id'] . "'>Mark Found</a> | ";
            }
            
            // ACCESS CONTROL: Admins can delete anything. Students can only delete their own posts.
            if ($_SESSION['role'] == 'Admin' || $_SESSION['user_id'] == $row['reported_by']) {
                echo "<a href='dashboard.php?delete=" . $row['item_id'] . "'>Delete</a>";
            }
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>