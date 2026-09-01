<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clarkdb";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("CREATE DATABASE IF NOT EXISTS `clarkdb`");
$conn->select_db($dbname);

$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL,
    address VARCHAR(255) NOT NULL,
    con_num VARCHAR(50) NOT NULL
)");

$editData = null;
if (isset($_GET['edit_id'])) {
    $editId = (int) $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $resultEdit = $stmt->get_result();
    $editData = $resultEdit->fetch_assoc();
    $stmt->close();
}

$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
$records = $result ? $result : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Output 1</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>PHP Output 1</h1>

        <form action="register.php" method="POST">
            <?php if ($editData): ?>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($editData['id']); ?>">
            <?php endif; ?>

            <div>
                <label for="name">Name:</label>
                <input id="name" name="name" value="<?php echo $editData ? htmlspecialchars($editData['name']) : ''; ?>" placeholder="Enter your Name" required>
            </div>

            <div>
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $editData ? htmlspecialchars($editData['age']) : ''; ?>" placeholder="Enter your age" min="1" max="120" required>
            </div>

            <div>
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="">-- Select Gender --</option>
                    <option value="male" <?php echo ($editData && $editData['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($editData && $editData['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $editData ? htmlspecialchars($editData['email']) : ''; ?>" placeholder="Enter your email" required>
            </div>

            <div>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $editData ? htmlspecialchars($editData['address']) : ''; ?>" placeholder="Enter your Address" required>
            </div>

            <div>
                <label for="con_num">Contact Number:</label>
                <input type="tel" id="con_num" name="con_num" value="<?php echo $editData ? htmlspecialchars($editData['con_num']) : ''; ?>" placeholder="Enter your Contact Number" pattern="[0-9+\-\s]+" required>
            </div>

            <input type="submit" name="submit" value="<?php echo $editData ? 'Update' : 'Submit'; ?>">

            <?php if ($editData): ?>
                <a href="index.php" class="cancel-btn">Cancel Edit</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-section">
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="success-message">Record Successfully Inserted to Database</div>
        <?php endif; ?>

        <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
            <div class="success-message">Record Successfully Updated</div>
        <?php endif; ?>

        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
            <div class="success-message">Record Successfully Deleted</div>
        <?php endif; ?>

        <h2>Registered Records</h2>

        <table id="userTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($records && $records->num_rows > 0): ?>
                    <?php while ($row = $records->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['age']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['con_num']); ?></td>
                            <td>
                                <a href="index.php?edit_id=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>
                                <a href="register.php?action=delete&id=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete this record?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.12.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#userTable').DataTable({
                order: [[0, 'desc']],
                paging: true,
                searching: true,
                lengthChange: true,
                ordering: true,
                info: true
            });
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>