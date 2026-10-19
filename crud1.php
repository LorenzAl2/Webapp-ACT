<?php
// ---- db.php part ----
$conn = mysqli_connect("localhost", "root", "", "test_db");

// ---- Insert new user ----
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    mysqli_query($conn, "INSERT INTO user (name, email) VALUES ('$name', '$email')");
    header("Location: crud.php");
    exit;
}

// ---- Update user ----
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    mysqli_query($conn, "UPDATE user SET name='$name', email='$email' WHERE id=$id");
    header("Location: crud.php");
    exit;
}

// ---- Delete user ----
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM user WHERE id=$id");
    header("Location: crud.php");
    exit;
}

// ---- Get user for edit form ----
$editUser = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE id=$id");
    $editUser = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP CRUD</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>PHP CRUD</h1>

    <!-- Form -->
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $editUser['id'] ?? ''; ?>">
        <label>Name:</label>
        <input type="text" name="name" required value="<?php echo $editUser['name'] ?? ''; ?>">
        <label>Email:</label>
        <input type="email" name="email" required value="<?php echo $editUser['email'] ?? ''; ?>">
        <input type="submit" name="<?php echo $editUser ? 'update' : 'add'; ?>" value="<?php echo $editUser ? 'Update' : 'Add'; ?>">
    </form>

    <!-- Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM user");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td class='actions'>
                    <a href='crud.php?edit={$row['id']}'>Edit</a>
                    <a href='crud.php?delete={$row['id']}' onclick=\"return confirm('Delete user?');\">Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>

</body>
</html>
