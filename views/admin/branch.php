<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header('Location: login.php');
    exit();
}

require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $branch_name = $_POST['branch_name'];
    $branch_location = $_POST['branch_location'];
    $opening_time = $_POST['opening_time'];
    $closing_time = $_POST['closing_time'];

    $branch_query = "INSERT INTO branches (name, location, opening_time, closing_time) 
                     VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($branch_query);
    $stmt->execute([$branch_name, $branch_location, $opening_time, $closing_time]);
    
    echo "<script>alert('Branch created successfully.'); window.location.href='dashboard_admin.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Create Branch</title>
</head>
<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Create New Branch</h1>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="branch_name" class="block text-sm font-medium text-gray-700">Branch Name</label>
                <input type="text" id="branch_name" name="branch_name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="branch_location" class="block text-sm font-medium text-gray-700">Branch Location</label>
                <input type="text" id="branch_location" name="branch_location" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="opening_time" class="block text-sm font-medium text-gray-700">Opening Time</label>
                <input type="time" id="opening_time" name="opening_time" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="closing_time" class="block text-sm font-medium text-gray-700">Closing Time</label>
                <input type="time" id="closing_time" name="closing_time" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Create Branch</button>
        </form>
    </div>
</body>
</html>
