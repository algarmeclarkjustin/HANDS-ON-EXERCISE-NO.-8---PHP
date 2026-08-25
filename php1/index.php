<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Output 1</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>PHP Output 1</h1>

        <form action="" method="POST">
            <div>
                <label for="name">Name:</label>
                <input id="name" name="name" placeholder="Enter your Name" required>
            </div>

            <div>
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" placeholder="Enter your age" min="1" max="120" required>
            </div>

            <div>
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="">-- Select Gender --</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
                
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" placeholder="Enter your Address" required>
                
            </div>

            <div>
                <label for="contact_num">Contact Number:</label>
                <input type="tel" id="contact_num" name="contact_num" placeholder="Enter your Contact Number"pattern="[0-9+\-\s]+" required>
                
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>