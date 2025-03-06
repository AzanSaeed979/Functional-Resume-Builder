<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>
</head>
<body>
  <header class="header">
    <img class="logo" src="images/logo1.png" alt="logo" width="55" height="55" 
         onclick="window.location.href='/webb/webb/index.php'" style="cursor: pointer;" />
    <br>
    <nav>
      <ul class="links">
        <li onclick="window.location.href='/webb/webb/index.php'">Home</li><br>
        <li onclick="window.location.href='/webb/webb/templates.php'">Templates</li><br>
        <li onclick="window.location.href='/webb/webb/personaldetails.php'">PersonalDetails</li><br>
      </ul>
    </nav>
    <br>
    <?php
      if (isset($_SESSION['email'])) {
          echo "Logged in as: " . htmlspecialchars($_SESSION['email']) . "<br>";
          echo '<button onclick="window.location.href=\'/webb/webb/logout.php\'">Logout</button>';
      } else {
          echo '<button onclick="window.location.href=\'/webb/webb/Login.php\'">Login</button>';
          echo '<button onclick="window.location.href=\'/webb/webb/SignUp.php\'">Sign Up</button>';
      }
    ?>
  </header>
</body>
</html>
