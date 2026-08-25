<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Login</h1>

    <form>
        <label>Email:</label>
        <input type="email" placeholder="Enter your email" required>

        <label>Password:</label>
        <input type="password" placeholder="Enter your password" required>

        <button type="submit">Login</button>

        <p><a href="forgot_password.php">Forgot Password?</a></p>
    </form>
</div>

<?php include 'includes/footer.php'; ?>