<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clarkdb";

$mysqli = new mysqli($servername, $username, $password);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$mysqli->query("CREATE DATABASE IF NOT EXISTS `clarkdb`");
$mysqli->select_db($dbname);

$mysqli->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL,
    address VARCHAR(255) NOT NULL,
    con_num VARCHAR(50) NOT NULL
)");

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = (int) $_GET['id'];
    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: index.php?deleted=1');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: index.php');
    exit;
}

$name = trim($_POST['name']);
$age = (int) $_POST['age'];
$gender = trim($_POST['gender']);
$email = trim($_POST['email']);
$address = trim($_POST['address']);
$con_num = trim($_POST['con_num']);
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

if ($id > 0) {
    $stmt = $mysqli->prepare("UPDATE users SET name = ?, age = ?, gender = ?, email = ?, address = ?, con_num = ? WHERE id = ?");
    $stmt->bind_param("sissssi", $name, $age, $gender, $email, $address, $con_num, $id);
} else {
    $stmt = $mysqli->prepare("INSERT INTO users (name, age, gender, email, address, con_num) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $name, $age, $gender, $email, $address, $con_num);
}

if ($stmt->execute()) {
    header('Location: index.php?' . ($id > 0 ? 'updated=1' : 'success=1'));
    exit;
} else {
    echo "Operation failed: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
