<?php
require 'auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = hash_password($_POST['password']);
    $role = 'Customer';

    $register_query = "INSERT INTO users (full_name, email, phone_number, password, role) 
                       VALUES ('$full_name', '$email', '$phone_number', '$password', '$role')";
    
    if ($conn->query($register_query) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Error: " . $register_query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet">
    <title>Register</title>
</head>
<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Register</h1>
        <form method="POST" action="">
            <input type="text" name="full_name" placeholder="Full Name" class="border p-2 w-30 mb-4">
            <input type="email" name="email" placeholder="Email" class="border p-2 w-30 mb-4">
            <input type="text" name="phone_number" placeholder="Phone Number" class="border p-2 w-30 mb-4">
            <input type="password" name="password" placeholder="Password" class="border p-2 w-30 mb-4">
            <button type="submit" class="bg-blue-500 text-black py-2 px-4">Register</button>
        </form>
    </div>
</body>
</html>
