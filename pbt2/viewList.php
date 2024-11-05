<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.php");
    exit;
}

$dataFile = 'registrations.txt';

// Load existing data
$data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: darkgrey;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        img {
            border-radius: 50%;
        }
        .action-buttons a {
            display: inline-block;
            margin-right: 5px;
            padding: 5px 10px;
            color: white;
            background-color: #5d3a29;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .action-buttons a:hover {
            background-color: #45a049;
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #5d3a29;
            color: white;
            margin-top: auto; /* Push footer to bottom */
        }
        
    </style>
</head>
<body>
    <nav>
        <a href="register.php">Register</a>
        <a href="viewList.php">View Registered Participants</a>
    </nav>

    <h2>Registered Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Age</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Picture</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr>
                    <td colspan="8">No registered users found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($row['picture']); ?>" alt="User Picture" width="50" height="50">
                        </td>
                        <td>
                            <a href="view.php?id=<?php echo $row['id']; ?>">View</a>
                            <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Malaysia Family Camping | Terengganu’s Honda Club </p>
    </footer>
</body>
</html>
