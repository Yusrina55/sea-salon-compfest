<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $duration = $_POST['duration'];

    $service_query = "INSERT INTO services (name, duration) VALUES (:name, :duration)";
    $stmt = $pdo->prepare($service_query);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Service added successfully.";
    } else {
        echo "Error: " . $service_query . "<br>" . $pdo->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Add Service</title>
</head>
<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Add Service</h1>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Service Name" class="border p-2 w-full mb-4" required>
            <input type="number" name="duration" placeholder="Duration (minutes)" class="border p-2 w-full mb-4" required>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4">Add Service</button>
        </form>
    </div>
</body>
</html>
