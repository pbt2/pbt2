<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.php");
    exit;
}

// Path to the JSON file
$dataFile = 'registrations.txt';

// Initialize data array
$data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Create a new user entry
$newUser = [
    'id' => uniqid(), // Generate a unique ID
    'name' => $_POST['name'],
    'age' => $_POST['age'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'address' => $_POST['address'],
    'picture' => '' // Initialize picture field
];

// Handle file upload
if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
    $targetDir = 'uploads/'; // Ensure this directory exists and is writable
    $fileName = basename($_FILES['picture']['name']);
    $targetFilePath = $targetDir . $fileName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['picture']['tmp_name'], $targetFilePath)) {
        $newUser['picture'] = $targetFilePath; // Save the path of the uploaded picture
    } else {
        echo "Error uploading file.";
        exit;
    }
}

// Add the new user to the data array
$data[] = $newUser;

// Save the updated data back to the JSON file
file_put_contents($dataFile, json_encode($data));

// Redirect to the list page after saving
header("Location: viewList.php");
exit;
?>
