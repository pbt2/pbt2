<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Camping Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: darkgrey;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #5d3a29;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        nav a {
            margin-right: 20px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        h2 {
            text-align: center;
            color: #5d3a29;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="tel"],
        textarea,
        input[type="file"] {
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
            margin-top: 10px;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #5d3a29;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <nav>
        <a href="register.php">Register</a>
        <a href="viewList.php">View Registered Participants</a>
    </nav>

    <h2>Register for Malaysia Family Camping</h2>
    <form method="POST" action="saveData.php" enctype="multipart/form-data">
        <label>Full Name: <input type="text" name="name" required></label>
        <label>Age: <input type="number" name="age" required></label>
        <label>Email: <input type="email" name="email" required></label>
        <label>Phone Number: <input type="tel" name="phone" required></label>
        <label>Address: <textarea name="address" required></textarea></label>
        <label>Upload Picture: <input type="file" name="picture" accept="image/*" required></label>
        <button type="submit">Register</button>
    </form>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Malaysia Family Camping | Terengganu’s Honda Club </p>
    </footer>
</body>
</html>
