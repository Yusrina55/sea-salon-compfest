<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

require '../config.php';

$reservation_query = "SELECT reservations.id, users.full_name, services.name AS service_name, reservations.reservation_date, branches.name AS branch_name 
                      FROM reservations 
                      JOIN users ON reservations.user_id = users.id 
                      JOIN services ON reservations.service_id = services.id 
                      JOIN branches ON services.branch_id = branches.id 
                      ORDER BY reservations.reservation_date DESC";
$stmt = $pdo->query($reservation_query);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>View Reservations</title>
</head>
<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Reservations</h1>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">Customer Name</th>
                    <th class="py-2">Service</th>
                    <th class="py-2">Reservation Date</th>
                    <th class="py-2">Branch</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($reservation['id']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($reservation['full_name']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($reservation['service_name']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($reservation['reservation_date']); ?></td>
                    <td class="border px-4 py-2"><?php echo htmlspecialchars($reservation['branch_name']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
