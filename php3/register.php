<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "clarkdb";

$conn = new mysqli($servername, $username, $password, $db);

if($conn->connect_error) {
    die("Connection Failed: ". $conn->connect_error);
}


if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $con_num = $_POST['con_num'];

    $sql = "INSERT INTO users(name, age, gender, email, address, con_num) VALUES('$name', '$age', '$gender', '$email', '$address', '$con_num')";

    if($conn->query($sql) === TRUE) {
        $isSuccess = true;
    } else {
        echo $sql." ".$conn->error;
    }

}

?>
<?php if($isSuccess): ?>
        <h3>Record Successfully Inserted to Database</h3>
    <?php endif; ?>
        <a href="./">Back to Main Form</a>