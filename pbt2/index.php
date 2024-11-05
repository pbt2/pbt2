<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Basic validation for username and password
    if (empty($username) || empty($password)) {
        $_SESSION['errorMessage'] = "Username and password are required.";
        header("Location: register.php");
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if user already exists
    $userExists = false;
    if (file_exists("users.txt")) {
        $file = fopen("users.txt", "r");
        while (($line = fgets($file)) !== false) {
            $storedUser = explode(",", trim($line))[0];
            if ($storedUser === $username) {
                $userExists = true;
                break;
            }
        }
        fclose($file);
    }

    if ($userExists) {
        $_SESSION['errorMessage'] = "Username already taken. Please choose another.";
        header("Location: register.php");
        exit;
    }

    // Store the username and hashed password in a text file
    $file = fopen("users.txt", "a");
    if ($file) {
        fwrite($file, $username . "," . $hashedPassword . "\n");
        fclose($file);
        $_SESSION['successMessage'] = "Registration successful! You can now log in.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['errorMessage'] = "Unable to register. Please try again later.";
        header("Location: register.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: darkgrey;
            margin: 0;
            display: flex;
            flex-direction: column;
            height: 100vh; /* Full height */
        }
        .register-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 350px;
            margin: auto; /* Center the container */
            flex: 1; /* Allow this div to grow */
            display: flex;
            flex-direction: column; /* Stack elements vertically */
            justify-content: center; /* Center contents vertically */
        }

        h2 {
            text-align: center;
            color: #5d3a29;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #5d3a29;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 15px;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #5d3a29;
            color: white;
            margin-top: auto; /* Push footer to the bottom */
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Register</button>
        </form>
        <?php if (isset($_SESSION['successMessage'])): ?>
            <p class="success-message"><?php echo $_SESSION['successMessage']; ?></p>
            <?php unset($_SESSION['successMessage']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['errorMessage'])): ?>
            <p class="error-message"><?php echo $_SESSION['errorMessage']; ?></p>
            <?php unset($_SESSION['errorMessage']); ?>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Malaysia Family Camping | Terengganu’s Honda Club </p>
    </footer>
</body>
</html>
