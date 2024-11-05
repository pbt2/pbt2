-<?php
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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission to update user
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $picture = $_FILES['picture']['name'] ? 'uploads/' . $_FILES['picture']['name'] : $user['picture'];

    // Move uploaded picture if a new one is uploaded
    if ($_FILES['picture']['name']) {
        if (!is_dir('uploads')) {
            mkdir('uploads', 0755, true);
        }
        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
    }

    // Update the user data
    foreach ($data as $index => $row) {
        if ($row['id'] == $id) {
            $data[$index]['name'] = $name;
            $data[$index]['age'] = $age;
            $data[$index]['email'] = $email;
            $data[$index]['phone'] = $phone;
            $data[$index]['address'] = $address;
            $data[$index]['picture'] = $picture;
            break;
        }
    }

    // Save updated data back to file
    file_put_contents($dataFile, json_encode($data));

    // Redirect to the list page after updating
    header("Location: viewList.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
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
      <nav>
        <a href="register.php">Register</a>
        <a href="viewList.php">View Registered Participants</a>
    </nav>
    <h2>Edit User: <?php echo htmlspecialchars($user['name']); ?></h2>
    <form method="POST" action="edit.php?id=<?php echo $user['id']; ?>" enctype="multipart/form-data">
        <label>Full Name: <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required></label><br>
        <label>Age: <input type="number" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required></label><br>
        <label>Phone Number: <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required></label><br>
        <label>Address: <textarea name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea></label><br>
        <label>Upload New Picture: <input type="file" name="picture" accept="image/*"></label><br>
        <button type="submit">Update User</button>
    </form>
    <a href="viewList.php">Cancel</a>
</body>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Malaysia Family Camping | Terengganu’s Honda Club </p>
    </footer>
</html>
