<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../public/style.css" rel="stylesheet">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Admin Dashboard</h1>
        <a href="branch.php" class="bg-blue-500 text-black py-2 px-4 mb-4 inline-block">Branch</a>
        <a href="add_service.php" class="bg-blue-500 text-black py-2 px-4 mb-4 inline-block">Add Services</a>
        <a href="see_reservation.php" class="bg-blue-500 text-black py-2 px-4 mb-4 inline-block">See Reservation</a>
        <a href="see_review.php" class="bg-blue-500 text-black py-2 px-4 mb-4 inline-block">See Review</a>
    </div>
</body>
</html>
