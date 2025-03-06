<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="logs.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form action="log.php" method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button><br>
        </form>
        <p>Don't have an account? <a href="SignUp.php">Signup here</a></p>
    </div>
    
</body>
</html>
