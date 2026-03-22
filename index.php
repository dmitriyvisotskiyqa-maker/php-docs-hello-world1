<?php

$conn = new mysqli("fgdf", "dfgd", "Dedfgdvas@dfgdfg", "dfgdf");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// INSERT
if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $conn->query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
}

// FETCH DATA FOR EDIT
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $editData = $result->fetch_assoc();
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP CRUD</title>
</head>
<body>

<h2>Simple PHP CRUD</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
    
    Name: <input type="text" name="name" value="<?= $editData['name'] ?? '' ?>" required>
    Email: <input type="email" name="email" value="<?= $editData['email'] ?? '' ?>" required>

    <?php if ($editData): ?>
        <button type="submit" name="update">Update</button>
    <?php else: ?>
        <button type="submit" name="create">Create</button>
    <?php endif; ?>
</form>

<hr>

<h3>User List</h3>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM users");

while ($row = $result->fetch_assoc()):
?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td>
        <a href="?edit=<?= $row['id'] ?>">Edit</a> |
        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
