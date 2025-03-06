
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="logs.css">
</head>
<body>
    <div class="form-container">
        <h2>Signup</h2>
        <form action="sig.php" method="POST">
            <input type="text" name="first_name" placeholder="First Name" required><br>
            <input type="text" name="last_name" placeholder="Last Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="text" name="phone" placeholder="Phone Number"><br>
            <input type="text" name="country" placeholder="Country"><br>
            <button type="submit">Register</button><br>
        </form>
        <p>Already have an account? <a href="Login.php">Login here</a></p>
    </div>
</body>
</html>
