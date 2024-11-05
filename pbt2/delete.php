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
    // Remove user with the matching ID
    foreach ($data as $index => $row) {
        if ($row['id'] == $id) {
            // Optionally delete the user's picture file
            unlink($row['picture']);
            unset($data[$index]);
            break;
        }
    }

    // Save updated data back to file
    file_put_contents($dataFile, json_encode(array_values($data)));

    // Redirect to the list page after deleting
    header("Location: viewList.php");
    exit;
}

// If no ID is specified, redirect to the list
header("Location: viewList.php");
exit;
