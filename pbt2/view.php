<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.php");
    exit;
}

$dataFile = 'registrations.txt';

// Load existing data
$data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Get the ID from the query parameter
$id = $_GET['id'] ?? null;

if ($id !== null) {
    // Find the user by ID
    $user = null;
    foreach ($data as $row) {
        if ($row['id'] == $id) {
            $user = $row;
            break;
        }
    }
    
    // If the user doesn't exist, redirect or show an error
    if ($user === null) {
        header("Location: viewList.php");
        exit;
    }
} else {
    header("Location: viewList.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User Details</title>
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
        .user-details {
            max-width: 800px; /* Increase the max width */
            margin: 20px auto;
            background: white;
            padding: 100px; /* Increase padding */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        img {
            max-width: 150px;
            border-radius: 10px;
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

    <div class="user-details">
        <h2>User Details</h2>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($user['address'])); ?></p>
        <p align="center"><strong>Picture:</strong><br>
            <img src="<?php echo htmlspecialchars($user['picture']); ?>" alt="User Picture">
        </p>
        <a href="edit.php?id=<?php echo $user['id']; ?>"></a> 
        <a href="viewList.php"></a>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Malaysia Family Camping | Terengganu’s Honda Club </p>
    </footer>
</body>
</html>
