<?php
require_once '../config.php'; // Sesuaikan jalurnya jika berbeda
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Customer') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['review_success']) && $_GET['review_success'] == 1) {
    echo "<script>alert('Review berhasil dibuat!');</script>";
}

// Ambil informasi user dari sesi
$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];

// Ambil data reservasi user dari database
$stmt = $pdo->prepare('SELECT reservations.*, services.name as service_name 
                       FROM reservations 
                       JOIN services ON reservations.service_id = services.id 
                       WHERE reservations.user_id = ?');
$stmt->execute([$user_id]);
$reservations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold">Welcome, <?= htmlspecialchars($full_name) ?></h1>
        <a href="reservation.php" class="bg-blue-500 text-white py-2 px-4 mb-4 inline-block">Make a Reservation</a>
        <a href="review.php" class="bg-blue-500 text-white py-2 px-4 mb-4 inline-block">Make a Review</a>
        <h2 class="text-xl mt-4">Your Reservations</h2>
        <table class="table-auto w-full mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">Service</th>
                    <th class="px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td class="border px-4 py-2"><?= htmlspecialchars($reservation['service_name']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($reservation['reservation_date']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
